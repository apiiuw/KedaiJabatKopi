<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignInController extends Controller
{
    public function index()
    {
        $title = 'Sign In';

        return view('auth.pages.sign-in.index', compact('title'));
    }
}
