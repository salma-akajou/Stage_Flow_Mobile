<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MobileEtudiantController extends Controller
{
    private function apiUrl(): string
    {
        return env('VITE_API_URL', 'http://10.0.2.2:8000/api');
    }

    public function dashboard($id)
    {
        $url = $this->apiUrl();
        $token = session('auth_token');
        $data = null;

        try {
            $response = Http::withToken($token)->timeout(4)->get("{$url}/student/{$id}/dashboard");
            \Log::info("Dashboard API Response: Status=" . $response->status() . " Body=" . $response->body());
            if ($response->successful() && isset($response->json()['data'])) {
                $data = $response->json()['data'];
            }
        } catch (\Exception $e) {
            \Log::error("Dashboard SSR Error: " . $e->getMessage());
        }

        return view('student.dashboard', [
            'ssrData'   => $data,
            'studentId' => $id,
            'apiUrl'    => $url,
            'token'     => $token,
        ]);
    }

    
    public function profile($id)
    {
        $url = $this->apiUrl();
        $token = session('auth_token');

        try {
            $response = Http::withToken($token)->timeout(4)->get("{$url}/student/{$id}/profile");
            $etudiant = $response->successful() ? $response->json()['data'] : null;
        } catch (\Exception $e) {
            \Log::error("Profile SSR Error: " . $e->getMessage());
            $etudiant = null;
        }

        return view('student.profile', [
            'etudiant' => $etudiant,
            'apiUrl'   => $url,
            'token'    => $token,
            'studentId' => $id
        ]);
    }
}
