<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MobileOffreController extends Controller
{
    private function apiUrl(): string
    {
        return env('VITE_API_URL', 'http://10.0.2.2:8000/api');
    }

    public function index()
    {
        $url = $this->apiUrl();
        $response = Http::get("{$url}/offres");
        $data = $response->json();
        $offres = (isset($data['data'])) ? $data['data'] : [];

        return view('student.offres.index', compact('offres'));
    }

    public function show($id)
    {
        $url = $this->apiUrl();
        $response = Http::get("{$url}/offres/{$id}");
        $data = $response->json();
        $offre = (isset($data['data'])) ? $data['data'] : null;

        return view('student.offres.show', compact('offre'));
    }
}
