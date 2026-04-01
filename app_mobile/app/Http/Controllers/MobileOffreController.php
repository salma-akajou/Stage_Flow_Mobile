<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MobileOffreController extends Controller
{
    public function index()
    {
        $url = env('VITE_API_URL', 'http://10.0.2.2:8000/api');
        $response = Http::get("{$url}/offres");
        $data = $response->json();
        $offres = (isset($data['data'])) ? $data['data'] : [];

        return view('student.offres.index', compact('offres'));
    }

    public function show($id)
    {
        $url = env('VITE_API_URL', 'http://10.0.2.2:8000/api');
        $response = Http::get("{$url}/offres/{$id}");
        $data = $response->json();
        $offre = (isset($data['data'])) ? $data['data'] : null;

        return view('student.offres.show', compact('offre'));
    }
}
