<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MobileLandingController extends Controller
{
    public function index()
    {
        $url = env('VITE_API_URL', 'http://10.0.2.2:8000/api');
        $response = Http::get("{$url}/landing");
        $data = $response->successful() ? $response->json()['data'] : ['stats' => [], 'feedbacks' => []];

        return view('landing', compact('data'));
    }
}
