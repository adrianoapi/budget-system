<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $title  = 'Dashboard';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard.index', [
            'title' => $this->title,
        ]);
    }
}
