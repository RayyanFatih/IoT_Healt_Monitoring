<?php

namespace App\Http\Controllers;

use App\Mail\LoginOtpMail;
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
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store in session (expires in 1 minute)
        Session::put('otp_code',   $otp);
        Session::put('otp_email',  $user->email);
        Session::put('otp_name',   $user->name);
        Session::put('otp_expiry', now()->addMinutes(2)->timestamp);
        Session::put('otp_user_id', $user->id);

        // Send OTP email
        Mail::to($user->email)->send(new LoginOtpMail($otp, $user->name));

        return response()->json([
            'success' => true,
            'email'   => $user->email,
        ]);
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
        Session::put('user_id',    Session::get('otp_user_id'));
        Session::put('user_name',  Session::get('otp_name'));
        Session::put('user_email', Session::get('otp_email'));
        Session::put('logged_in',  true);

        // Clean up OTP data
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

        $email = Session::get('otp_email');
        $name  = Session::get('otp_name');

        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Session::put('otp_code',   $otp);
        Session::put('otp_expiry', now()->addMinutes(1)->timestamp);

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
        Session::forget(['user_id', 'user_name', 'user_email', 'logged_in']);
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
    //  HELPERS
    // ─────────────────────────────────────────────

    private function maskEmail(string $email): string
    {
        [$local, $domain] = explode('@', $email);
        $maskedLocal = substr($local, 0, 2) . str_repeat('*', max(strlen($local) - 2, 1));
        return $maskedLocal . '@' . $domain;
    }
}
