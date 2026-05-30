<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MobileFavoriController extends Controller
{
    private function apiUrl(): string
    {
        return env('VITE_API_URL', 'http://10.0.2.2:8000/api');
    }

    public function index($id)
    {
        $url   = $this->apiUrl();
        $token = session('auth_token');

        try {
            $response = Http::withToken($token)->timeout(4)->get("{$url}/student/{$id}/favoris");
            $data     = $response->successful() ? $response->json()['data'] : null;
        } catch (\Exception $e) {
            \Log::error("Favoris SSR Error: " . $e->getMessage());
            $data = null;
        }

        return view('student.favoris.index', [
            'ssrData'   => $data,
            'studentId' => $id,
            'apiUrl'    => $url,
            'token'     => $token,
        ]);
    }
}
