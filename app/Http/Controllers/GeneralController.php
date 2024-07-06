<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    /**
     * Index - Login
     */
    public function index() {
        return view('pages.login');
    }

    /**
     * Index - Dashboard
     */
    public function dashboard() {
        return view('pages.admin.dashboard');
    }
}
