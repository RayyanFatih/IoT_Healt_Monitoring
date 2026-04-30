<?php

namespace App\Http\Controllers;

use App\Mail\LoginOtpMail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // ─────────────────────────────────────────────
    //  REGISTER
    // ─────────────────────────────────────────────

    public function showRegister()
    {
        // Jika sudah login, langsung ke dashboard
        if (Session::get('logged_in')) {
            return redirect('/dashboard');
        }

        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required'      => 'Nama tidak boleh kosong.',
            'email.required'     => 'Email tidak boleh kosong.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password tidak boleh kosong.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => true]);
    }

    // ─────────────────────────────────────────────
    //  LOGIN
    // ─────────────────────────────────────────────

    public function showLogin()
    {
        // Jika sudah login, langsung ke dashboard
        if (Session::get('logged_in')) {
            return redirect('/dashboard');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email atau password salah.');
        }

        // ── Cek apakah OTP lama masih valid (dalam 30 menit) ──────────────
        // Jika iya, gunakan kembali tanpa kirim email baru.
        $now = now()->timestamp;
        if ($user->otp_code && $user->otp_expires_at && $user->otp_expires_at > $now) {
            // Simpan info sesi OTP (tanpa generate baru)
            Session::put('otp_code',    $user->otp_code);
            Session::put('otp_email',   $user->email);
            Session::put('otp_name',    $user->name);
            Session::put('otp_expiry',  $user->otp_expires_at);
            Session::put('otp_user_id', $user->id);

            return redirect('/otp');
        }

        // ── Generate OTP baru ─────────────────────────────────────────────
        $otp    = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiry = now()->addMinutes(30)->timestamp; // berlaku 30 menit

        // Simpan ke database agar bertahan setelah logout
        $user->update([
            'otp_code'       => $otp,
            'otp_expires_at' => $expiry,
        ]);

        // Simpan ke session juga
        Session::put('otp_code',    $otp);
        Session::put('otp_email',   $user->email);
        Session::put('otp_name',    $user->name);
        Session::put('otp_expiry',  $expiry);
        Session::put('otp_user_id', $user->id);

        // Kirim email OTP
        Mail::to($user->email)->send(new LoginOtpMail($otp, $user->name));

        return redirect('/otp');
    }

    // ─────────────────────────────────────────────
    //  OTP VERIFICATION
    // ─────────────────────────────────────────────

    public function showOtp()
    {
        if (!Session::has('otp_code')) {
            return redirect('/login');
        }

        return view('otp', [
            'maskedEmail' => Session::get('otp_email'),
            'expiry'      => Session::get('otp_expiry'),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        if (!Session::has('otp_code')) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi OTP tidak ditemukan. Silakan login ulang.',
            ], 400);
        }

        // Check expiry
        if (now()->timestamp > Session::get('otp_expiry')) {
            Session::forget(['otp_code', 'otp_email', 'otp_name', 'otp_expiry', 'otp_user_id']);
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kedaluwarsa. Silakan login ulang.',
                'expired' => true,
            ], 400);
        }

        if ($request->code !== Session::get('otp_code')) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP tidak sesuai. Coba lagi.',
            ], 400);
        }

        // OTP valid — set authenticated session
        $userId = Session::get('otp_user_id');
        Session::put('user_id',    $userId);
        Session::put('user_name',  Session::get('otp_name'));
        Session::put('user_email', Session::get('otp_email'));
        Session::put('logged_in',  true);

        // Hapus OTP dari DB setelah berhasil digunakan
        if ($userId) {
            User::where('id', $userId)->update([
                'otp_code'       => null,
                'otp_expires_at' => null,
            ]);
        }

        // Clean up OTP session data
        Session::forget(['otp_code', 'otp_email', 'otp_name', 'otp_expiry', 'otp_user_id']);

        return response()->json(['success' => true]);
    }

    public function resendOtp(Request $request)
    {
        if (!Session::has('otp_email')) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi tidak ditemukan. Silakan login ulang.',
            ], 400);
        }

        $email  = Session::get('otp_email');
        $name   = Session::get('otp_name');
        $userId = Session::get('otp_user_id');

        // Generate OTP baru
        $otp    = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiry = now()->addMinutes(30)->timestamp;

        // Update DB
        if ($userId) {
            User::where('id', $userId)->update([
                'otp_code'       => $otp,
                'otp_expires_at' => $expiry,
            ]);
        }

        Session::put('otp_code',   $otp);
        Session::put('otp_expiry', $expiry);

        Mail::to($email)->send(new LoginOtpMail($otp, $name));

        return response()->json([
            'success' => true,
            'message' => 'Kode baru telah dikirim.',
        ]);
    }

    // ─────────────────────────────────────────────
    //  LOGOUT
    // ─────────────────────────────────────────────

    public function logout()
    {
        // Hapus hanya session login — OTP di DB tetap ada sampai kedaluwarsa
        Session::forget(['user_id', 'user_name', 'user_email', 'logged_in',
                         'otp_code', 'otp_email', 'otp_name', 'otp_expiry', 'otp_user_id']);
        return redirect('/login');
    }

    // ─────────────────────────────────────────────
    //  PROFILE
    // ─────────────────────────────────────────────

    public function getProfile(Request $request)
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Belum login.'], 401);
        }

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan.'], 404);
        }

        return response()->json([
            'success' => true,
            'name'    => $user->name,
            'dob'     => $user->dob,
            'age'     => $user->age,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Belum login.'], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'dob'  => 'nullable|date|before:today',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'dob.date'      => 'Format tanggal tidak valid.',
            'dob.before'    => 'Tanggal lahir harus sebelum hari ini.',
        ]);

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan.'], 404);
        }

        $age = null;
        if ($request->dob) {
            $birth = new \DateTime($request->dob);
            $today = new \DateTime();
            $age   = (int) $birth->diff($today)->y;
        }

        $user->update([
            'name' => $request->name,
            'dob'  => $request->dob,
            'age'  => $age,
        ]);

        // Update session name too
        Session::put('user_name', $user->name);

        return response()->json([
            'success' => true,
            'name'    => $user->name,
            'dob'     => $user->dob,
            'age'     => $age,
        ]);
    }

    // ─────────────────────────────────────────────
    //  FORGOT PASSWORD
    // ─────────────────────────────────────────────

    public function showForgotPassword()
    {
        if (Session::get('logged_in')) {
            return redirect('/dashboard');
        }
        return view('lupa_password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email tidak boleh kosong.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        // Selalu tampilkan pesan sukses meskipun email tidak terdaftar
        // (mencegah user enumeration attack)
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token  = bin2hex(random_bytes(32)); // 64 karakter hex
            $expiry = now()->addMinutes(60)->timestamp;

            // Simpan / update token di tabel password_reset_tokens
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'token'      => hash('sha256', $token),
                    'created_at' => now(),
                ]
            );

            $resetUrl = url('/reset-password') . '?token=' . $token . '&email=' . urlencode($user->email);

            Mail::to($user->email)->send(new ResetPasswordMail($resetUrl, $user->name));
        }

        return back()->with('reset_sent', true);
    }

    // ─────────────────────────────────────────────
    //  RESET PASSWORD
    // ─────────────────────────────────────────────

    public function showResetPassword(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
            return redirect('/forgot-password')
                ->with('error', 'Link reset password tidak valid.');
        }

        // Cek token di DB
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$record || !hash_equals($record->token, hash('sha256', $token))) {
            return redirect('/forgot-password')
                ->with('error', 'Link reset password tidak valid atau sudah digunakan.');
        }

        // Cek expiry (60 menit)
        if (now()->diffInMinutes($record->created_at, false) < -60) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect('/forgot-password')
                ->with('error', 'Link reset password sudah kedaluwarsa. Silakan minta link baru.');
        }

        return view('reset_password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required'  => 'Password tidak boleh kosong.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !hash_equals($record->token, hash('sha256', $request->token))) {
            return back()->with('error', 'Link reset password tidak valid atau sudah digunakan.');
        }

        if (now()->diffInMinutes($record->created_at, false) < -60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect('/forgot-password')
                ->with('error', 'Link reset password sudah kedaluwarsa. Silakan minta link baru.');
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Akun tidak ditemukan.');
        }

        // Update password
        $user->update(['password' => Hash::make($request->password)]);

        // Hapus token setelah berhasil digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')
            ->with('success', 'Password berhasil diubah! Silakan masuk dengan password baru Anda.');
    }

    // ─────────────────────────────────────────────
    //  HELPERS
    // ─────────────────────────────────────────────

    private function maskEmail(string $email): string
    {
        [$local, $domain] = explode('@', $email);
        $maskedLocal = substr($local, 0, 2) . str_repeat('*', max(strlen($local) - 2, 1));
        return $maskedLocal . '@' . $domain;
    }
}
