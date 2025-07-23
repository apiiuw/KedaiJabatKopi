<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignUpController extends Controller
{
    public function index()
    {
        $title = 'Sign Up';

        return view('auth.pages.sign-up.index', compact('title'));
    }
}
