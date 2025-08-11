<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccessControlController extends Controller
{
    public function index()
    {
        $title = 'Owner Access Control';

         return view('owner.pages.access-control.index', compact(
            'title',
        ));
    }
}
