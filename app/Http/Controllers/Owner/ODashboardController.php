<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ODashboardController extends Controller
{
    public function index()
    {
        $title = 'Owner Dashboard';

         return view('owner.pages.dashboard.index', compact(
            'title',
        ));
    }
}
