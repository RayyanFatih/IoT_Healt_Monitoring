<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Vital;
use App\Models\Session;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create patient
        $patient = Patient::create([
            'patient_id' => 'EXH-2026-01',
            'name' => 'Ahmad Farhan',
            'age' => 21,
            'institution' => 'University IoT Prototype Exhibition',
        ]);

        // Create current vital with warning
        Vital::create([
            'patient_id' => $patient->id,
            'heart_rate' => 108,
            'spo2' => 96,
            'has_warning' => true,
            'sensor_status' => 'Inactive',
            'created_at' => now(),
        ]);

        // Create sessions with chart data
        $sessions = [
            [
                'name' => 'Morning Check-up',
                'session_date' => now()->subDays(1)->format('Y-m-d'),
                'session_time' => '08:00:00',
                'avg_heart_rate' => 75,
                'avg_spo2' => 97,
                'readings_count' => 14,
                'duration' => '00:11:01',
            ],
            [
                'name' => 'Afternoon Session',
                'session_date' => now()->subDays(2)->format('Y-m-d'),
                'session_time' => '14:30:00',
                'avg_heart_rate' => 82,
                'avg_spo2' => 95,
                'readings_count' => 20,
                'duration' => '00:15:30',
            ],
            [
                'name' => 'Evening Monitoring',
                'session_date' => now()->subDays(2)->format('Y-m-d'),
                'session_time' => '18:00:00',
                'avg_heart_rate' => 78,
                'avg_spo2' => 96,
                'readings_count' => 18,
                'duration' => '00:12:45',
            ],
        ];

        foreach ($sessions as $sessionData) {
            // Generate chart data
            $chartData = [];
            for ($i = 0; $i < 60; $i++) {
                $chartData[] = [
                    'time' => sprintf('%02d:%02d', intdiv($i, 60), $i % 60),
                    'heartRate' => $sessionData['avg_heart_rate'] + rand(-10, 10),
                    'spo2' => $sessionData['avg_spo2'] + rand(-2, 2),
                ];
            }

            Session::create([
                'patient_id' => $patient->id,
                'name' => $sessionData['name'],
                'session_date' => $sessionData['session_date'],
                'session_time' => $sessionData['session_time'],
                'avg_heart_rate' => $sessionData['avg_heart_rate'],
                'avg_spo2' => $sessionData['avg_spo2'],
                'readings_count' => $sessionData['readings_count'],
                'duration' => $sessionData['duration'],
                'chart_data' => $chartData,
            ]);
        }
    }
}
