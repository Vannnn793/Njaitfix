<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        $layout = Auth::check() ? 'layouts.cust' : 'layouts.app';
        return view('welcome', compact('layout'));
    }
}
