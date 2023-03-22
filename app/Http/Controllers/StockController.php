<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends UtilController
{
    private $title  = 'Estoque';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::where('deleted_at', NULL)->orderBy('id', 'desc')->paginate(20);

        return view('stocks.index', [
            'title' => $this->title,
            'stocks' => $stocks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('active', true)->orderBy('descricao', 'asc')->get();

        return view('stocks.add', [
            'title' => $this->title,
            'produtos' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->levelCheck();
        $model = new Stock();
        $model->user_id    = Auth::id();
        $model->product_id = $request->produto_id;
        $model->quantidade = $request->quantidade;
        $model->dt_lancamento = $request->dt_lancamento;

        if($model->save()){
            return redirect()->route('estoques.index');
        }else{
            echo 'Erro ao adicionar produto ao estoque!';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        $this->levelCheck();
        if($stock->delete()){


            # Subtrai a quantidade do produto
            $produto = Product::findOrFail($stock->product_id);
            $produto->quantidade = $produto->quantidade - $stock->quantidade;
            $produto->save();

            return redirect()->route('estoques.index');
        }else{
            die('Erro ao excluir o Lançamento');
        }
    }
}
