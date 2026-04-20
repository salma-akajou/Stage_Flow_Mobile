<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MobileEtudiantController extends Controller
{
    public function dashboard($id)
    {
        $url = env('VITE_API_URL', 'http://10.0.2.2:8000/api');
        $data = null;
        $apiErrorMsg = null;
        
        try {
            $response = Http::timeout(4)->get("{$url}/student/{$id}/dashboard");
            if ($response->successful() && isset($response->json()['data'])) {
                $data = $response->json()['data'];
            }
        } catch (\Exception $e) {
            \Log::error("Dashboard SSR Error: " . $e->getMessage());
        }
        
        return view('student.dashboard', [
            'ssrData' => $data,
            'studentId' => $id,
            'apiUrl' => $url
        ]);
    }

    public function profile($id)
    {
        $url = env('VITE_API_URL', 'http://10.0.2.2:8000/api');
        $response = Http::get("{$url}/student/{$id}/profile");
        $etudiant = $response->successful() ? $response->json()['data'] : null;

        return view('student.profile', compact('etudiant'));
    }
}
