<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsommateurController extends Controller
{
    public function index()
    {
        return view('consommateur.dashboard');
    }
}
