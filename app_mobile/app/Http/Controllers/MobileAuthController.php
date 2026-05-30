<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MobileAuthController extends Controller
{
    private function apiUrl(): string
    {
        return env('VITE_API_URL', 'http://10.0.2.2:8000/api');
    }

    public function showLogin()
    {
        if (session('auth_token')) {
            return redirect()->route('student.dashboard', ['id' => session('student_id')]);
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (session('auth_token')) {
            return redirect()->route('student.dashboard', ['id' => session('student_id')]);
        }

        $villes = [];
        try {
            $response = Http::timeout(5)->get($this->apiUrl() . '/villes');
            if ($response->successful()) {
                $villes = $response->json()['data'] ?? [];
            }
        } catch (\Exception $e) {
            \Log::error('Fetch villes failed: ' . $e->getMessage());
        }

        return view('auth.register', compact('villes'));
    }

    public function register(Request $request)
    {
        if (empty($request->all()) && !empty($request->getContent())) {
            parse_str($request->getContent(), $parsed);
            $request->merge($parsed);
        }

        $request->validate([
            'prenom'        => 'required|string|max:255',
            'nom'           => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'password'      => 'required|min:6|confirmed',
            'ville_id'      => 'required|integer',
            'etablissement' => 'required|string',
            'filiere'       => 'required|string|max:255',
            'niveau_etude'  => 'required|string',
            'bio'           => 'nullable|string',
            'github'        => 'nullable|string',
            'linkedin'      => 'nullable|string',
        ]);

        try {
            $postData = $request->except(['_token']);
            $response = Http::timeout(10)->post($this->apiUrl() . '/auth/register', $postData);

            if ($response->successful()) {
                $data = $response->json()['data'];

                session([
                    'auth_token' => $data['token'],
                    'student_id' => $data['student']['user_id'],
                    'user_name'  => $data['student']['prenom'] . ' ' . $data['student']['nom'],
                    'user_email' => $data['student']['email'],
                ]);

                return redirect()->route('student.dashboard', ['id' => $data['student']['user_id']]);
            }

            $msg = $response->json()['message'] ?? 'Erreur lors de l\'inscription.';
            return back()->withErrors(['email' => $msg])->withInput();

        } catch (\Exception $e) {
            \Log::error('Mobile Register Error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Impossible de joindre le serveur. Réessayez.'])->withInput();
        }
    }



    public function login(Request $request)
    {
        if (empty($request->all()) && !empty($request->getContent())) {
            parse_str($request->getContent(), $parsed);
            $request->merge($parsed);
        }

        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        try {
            $response = Http::timeout(8)->post($this->apiUrl() . '/auth/login', [
                'email'    => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json()['data'];

                session([
                    'auth_token' => $data['token'],
                    'student_id' => $data['student']['user_id'],
                    'user_name'  => $data['student']['prenom'] . ' ' . $data['student']['nom'],
                    'user_email' => $data['student']['email'],
                ]);

                return redirect()->route('student.dashboard', ['id' => $data['student']['user_id']]);
            }
            
            return back()->withErrors(['email' => 'Identifiants incorrects.'])->withInput($request->only('email'));

        } catch (\Exception $e) {
            \Log::error('Mobile Login Error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Impossible de joindre le serveur. Réessayez.'])->withInput($request->only('email'));
        }
    }

    public function logout(Request $request)
    {
        $token = session('auth_token');

        if ($token) {
            try {
                Http::withToken($token)->timeout(5)->post($this->apiUrl() . '/auth/logout');
            } catch (\Exception $e) {
            }
        }

        session()->flush();

        return redirect()->route('login');
    }
}
