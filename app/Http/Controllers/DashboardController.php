<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;

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
        if(Auth::user()->level > 1)
        {
            return $this->dashboardAdmin();
        }else{
            return $this->dashboard();
        }
    }

    private function dashboardAdmin()
    {
        $quotes   = Quote::where('active', true)->get();
        $products = Product::where('active', true)->get();
        $clients  = Client::where('active', true)->get();
        $users    = User::where('active', true)->get();

        return view('dashboard.admin.index', [
            'title' => $this->title." Admin",
            'total' => [
                'quotes'   => $quotes->count(),
                'products' => $products->count(),
                'clients'  => $clients->count(),
                'users'    => $users->count()
            ]
        ]);
    }

    private function dashboard()
    {
        $products = Product::where('active', true)->get();
        $quotes   = Quote::  where('active', true)->where('user_id', Auth::user()->id)->get();
        $clients  = Client:: where('active', true)->where('user_id', Auth::user()->id)->get();

        return view('dashboard.index', [
            'title' => $this->title,
            'total' => [
                'quotes'   => $quotes->count(),
                'products' => $products->count(),
                'clients'  => $clients->count(),
            ]
        ]);
    }
}
