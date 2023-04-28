<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Client;
use App\Models\File;
use App\Models\Product;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $title  = 'Dashboard';
    private $date_begin;
    private $date_end;

    public function __construct()
    {
        $this->middleware('auth');
        $this->date_begin = date('Y-m-d');
        $this->date_begin = date('Y-m-d', strtotime("$this->date_begin -30 days"));
        $this->date_end   = date('Y-m-d');
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

    public function getQuotes()
    {
        $date_begin = date('Y-m-d', strtotime("$this->date_begin -1 year"));

        # Se for administrador
        if(Auth::user()->level > 1)
        {
            $aprove = DB::table('quotes')
            ->select(DB::raw('count( quotes.id ) as total'), DB::raw("DATE_FORMAT(quotes.created_at, '%Y-%m') dt_lancamento"))
            ->where([
                ['quotes.active', true],
                ['quotes.aprovado', true],
                ['quotes.created_at', '>=', $date_begin],
                ['quotes.created_at', '<=', $this->date_end]
            ])
            ->groupBy('dt_lancamento')
            ->orderByDesc('dt_lancamento')
            ->get();

            $quote = DB::table('quotes')
            ->select(DB::raw('count( quotes.id ) as total'), DB::raw("DATE_FORMAT(quotes.created_at, '%Y-%m') dt_lancamento"))
            ->where([
                ['quotes.active', true],
                ['quotes.aprovado', false],
                ['quotes.created_at', '>=', $date_begin],
                ['quotes.created_at', '<=', $this->date_end]
            ])
            ->groupBy('dt_lancamento')
            ->orderByDesc('dt_lancamento')
            ->get();

        }else{
            
            $aprove = DB::table('quotes')
            ->select(DB::raw('count( quotes.id ) as total'), DB::raw("DATE_FORMAT(quotes.created_at, '%Y-%m') dt_lancamento"))
            ->where([
                ['quotes.user_id', Auth::user()->id],
                ['quotes.active', true],
                ['quotes.aprovado', true],
                ['quotes.created_at', '>=', $date_begin],
                ['quotes.created_at', '<=', $this->date_end]
            ])
            ->groupBy('dt_lancamento')
            ->orderByDesc('dt_lancamento')
            ->get();

            $quote = DB::table('quotes')
            ->select(DB::raw('count( quotes.id ) as total'), DB::raw("DATE_FORMAT(quotes.created_at, '%Y-%m') dt_lancamento"))
            ->where([
                ['quotes.user_id', Auth::user()->id],
                ['quotes.active', true],
                ['quotes.aprovado', false],
                ['quotes.created_at', '>=', $date_begin],
                ['quotes.created_at', '<=', $this->date_end]
            ])
            ->groupBy('dt_lancamento')
            ->orderByDesc('dt_lancamento')
            ->get();
        }
        
        return response()->json([
            'cart' => view('dashboard.chart.quote', [
                'aprove' => $aprove->reverse(),
                'quote' => $quote->reverse()
                ])->render(),
        ]);
    }

    public function getStockRank()
    {
        $products = Product::where('active', true)
        ->orderBy('quantidade', 'asc')
        ->limit(10)
        ->get();

        return response()->json([
            'rank' => view('dashboard.chart.stock', [
                'produtos' => $products,
                ])->render(),
        ]);
    }

    public function getFiles()
    {
        $file = File::count();
        $size = File::sum('size');

        return response()->json([
            'rank' => view('dashboard.chart.file', [
                'file' => $file,
                'size' => $size,
                ])->render(),
        ]);
    }
}
