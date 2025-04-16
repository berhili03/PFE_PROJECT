<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;

class CommercantController extends Controller
{
    public function index()
    {
        return view('commercant.dashboard');
    }
}
