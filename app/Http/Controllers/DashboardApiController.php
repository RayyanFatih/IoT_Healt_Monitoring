<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Vital;
use App\Models\Session;
use Illuminate\Http\JsonResponse;

class DashboardApiController extends Controller
{
    /**
     * Get patient profile
     */
    public function getPatientProfile(): JsonResponse
    {
        $patient = Patient::first();
        
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }

    /**
     * Get current vitals
     */
    public function getCurrentVitals(): JsonResponse
    {
        $patient = Patient::first();
        
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $vital = $patient->vitals()->latest()->first();

        if (!$vital) {
            return response()->json(['error' => 'No vital data available'], 404);
        }

        return response()->json([
            'heart_rate' => $vital->heart_rate,
            'spo2' => $vital->spo2,
            'timestamp' => $vital->created_at,
            'hasWarning' => $vital->has_warning,
            'sensorStatus' => $vital->sensor_status,
        ]);
    }

    /**
     * Get all sessions for patient
     */
    public function getSessionHistory(): JsonResponse
    {
        $patient = Patient::first();
        
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $sessions = $patient->sessions()->orderBy('session_date', 'desc')->get();

        return response()->json($sessions->map(function ($session) {
            return [
                'id' => $session->id,
                'name' => $session->name,
                'date' => $session->session_date->format('M d, Y'),
                'time' => $session->session_time->format('H:i A'),
                'avgHeartRate' => $session->avg_heart_rate,
                'avgSpo2' => $session->avg_spo2,
                'readings' => $session->readings_count,
                'duration' => $session->duration,
                'chartData' => $session->chart_data,
            ];
        }));
    }

    /**
     * Get chart data for specific session
     */
    public function getChartData($sessionId = null): JsonResponse
    {
        $patient = Patient::first();
        
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        if ($sessionId) {
            $session = Session::find($sessionId);
            if (!$session) {
                return response()->json(['error' => 'Session not found'], 404);
            }
            $chartData = $session->chart_data ?: [];
        } else {
            // Get latest session chart data
            $session = $patient->sessions()->latest('session_date')->first();
            $chartData = $session?->chart_data ?: $this->generateMockChartData();
        }

        return response()->json([
            'chartData' => $chartData,
        ]);
    }

    /**
     * Get session statistics
     */
    public function getSessionStats(): JsonResponse
    {
        $patient = Patient::first();
        
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $latestSession = $patient->sessions()->latest('session_date')->first();

        if (!$latestSession) {
            return response()->json([
                'avgHeartRateSession' => 0,
                'avgSpo2Session' => 0,
                'readingsToday' => 0,
                'sessionUptime' => '00:00:00',
            ]);
        }

        return response()->json([
            'avgHeartRateSession' => $latestSession->avg_heart_rate,
            'avgSpo2Session' => $latestSession->avg_spo2,
            'readingsToday' => $latestSession->readings_count,
            'sessionUptime' => $latestSession->duration,
        ]);
    }

    /**
     * Get complete dashboard data (all endpoints in one call)
     */
    public function getDashboardData(): JsonResponse
    {
        $patient = Patient::first();
        
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $currentVital = $patient->vitals()->latest()->first();
        $sessions = $patient->sessions()->orderBy('session_date', 'desc')->get();
        $latestSession = $sessions->first();

        return response()->json([
            'patient' => [
                'id' => $patient->patient_id,
                'name' => $patient->name,
                'age' => $patient->age,
                'institution' => $patient->institution,
            ],
            'currentVitals' => [
                'heartRate' => $currentVital?->heart_rate ?? 0,
                'spo2' => $currentVital?->spo2 ?? 0,
                'timestamp' => $currentVital?->created_at,
                'hasWarning' => $currentVital?->has_warning ?? false,
                'sensorStatus' => $currentVital?->sensor_status ?? 'Inactive',
            ],
            'history' => $sessions->map(function ($session) {
                return [
                    'id' => $session->id,
                    'name' => $session->name,
                    'date' => $session->session_date->format('M d, Y'),
                    'time' => $session->session_time->format('H:i A'),
                    'avgHeartRate' => $session->avg_heart_rate,
                    'avgSpo2' => $session->avg_spo2,
                    'readings' => $session->readings_count,
                    'duration' => $session->duration,
                ];
            }),
            'stats' => [
                'avgHeartRateSession' => $latestSession?->avg_heart_rate ?? 0,
                'avgSpo2Session' => $latestSession?->avg_spo2 ?? 0,
                'readingsToday' => $latestSession?->readings_count ?? 0,
                'sessionUptime' => $latestSession?->duration ?? '00:00:00',
            ],
        ]);
    }

    /**
     * Generate mock chart data
     */
    private function generateMockChartData()
    {
        $data = [];
        for ($i = 0; $i < 60; $i++) {
            $data[] = [
                'time' => sprintf('%02d:%02d', intdiv($i, 60), $i % 60),
                'heartRate' => rand(70, 110),
                'spo2' => rand(94, 99),
            ];
        }
        return $data;
    }
}
