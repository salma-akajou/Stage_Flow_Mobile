<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MobileCandidatureController extends Controller
{
    public function index($etudiantId)
    {
        return view('student.candidatures.index', compact('etudiantId'));
    }
}
