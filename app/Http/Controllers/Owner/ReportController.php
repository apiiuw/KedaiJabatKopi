<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $title = 'Owner Report';

         return view('owner.pages.report.index', compact(
            'title',
        ));
    }
}
