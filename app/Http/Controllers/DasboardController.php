<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DasboardController extends Controller
{
    public function index()
    {
        return view('admin.pages.dashboard');
    }
}
