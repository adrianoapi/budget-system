<?php

namespace App\Http\Controllers\Api;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\UtilController;

class StockController extends UtilController
{
    private $title  = 'API Estoque';

    public function __construct()
    {
        $this->middleware('api', ['except' => ['estoque/atualizar']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function atualizar()
    {
        $stocks = Stock::where('deleted_at', NULL)
        ->where('dt_lancamento', '<=', date('Y/m/d'))
        ->orderBy('id', 'desc')->paginate(20);

        return response()->json($stocks);
    }

}
