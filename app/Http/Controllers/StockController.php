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
        $ids = [];
        $inserido = 'todos';

        if(array_key_exists('filtro',$_GET))
        {
            if(strlen($_GET['inserido']))
            {
                $inserido = $_GET['inserido'];

                if($inserido == 'sim')
                {
                    $stoks = Stock::where('deleted_at', NULL)
                    ->where('inserido', true)
                    ->get();
                }elseif($inserido == 'nao'){
                    $stoks = Stock::where('deleted_at', NULL)->where('inserido', false)->get();
                }else{
                    $stoks = Stock::where('deleted_at', NULL)->get();
                }
                

                $ids = [];
                foreach($stoks as $value):
                    array_push($ids, $value->id);
                endforeach;
            }

            $stocks = Stock::whereIn('id', $ids)
            ->where('deleted_at', NULL)
            ->orderBy('dt_lancamento', 'desc')->paginate(20);

        }else
        {
            $stocks = Stock::where('deleted_at', NULL)->orderBy('dt_lancamento', 'desc')->paginate(20);
        }


        return view('stocks.index', [
            'title' => $this->title,
            'stocks' => $stocks,
            'inserido' => $inserido,
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
        $model->user_id       = Auth::id();
        $model->product_id    = $request->produto_id;
        $model->quantidade    = $request->quantidade;
        $model->dt_lancamento = $request->dt_lancamento;
        $model->nota_fiscal   = $request->nota_fiscal;

        if($model->save())
        {
            $atual = date('Y-m-d');

            $date = str_replace('/', '-', $request->dt_lancamento);
            $dtLanca = date("Y-m-d", strtotime($date));

            $dtAtual = strtotime($atual);
            $dtLanca = strtotime($dtLanca);

            if($dtLanca <= $dtAtual)
            {
                $produto = Product::findOrFail($model->product_id);
                $produto->quantidade = $produto->quantidade + $model->quantidade;

                if($produto->save())
                {
                    # Marca como estoque inserido
                    $model->inserido = true;
                    $model->save();
                }
            }

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
        $this->levelCheck();
        $products = Product::
        #where('active', true)
        orderBy('descricao', 'asc')->get();
        $title = $this->title. " alterar";
        return view('stocks.edit', ['title' => $title, 'stock' => $stock, 'produtos' => $products]);
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
        $this->levelCheck();
        $stock->nota_fiscal = $request->nota_fiscal;

        if($stock->save()){
            return redirect()->route('estoques.index');
        }else{
            echo 'Erro ao atualizar o produto!';
        }
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

            if($stock->inserido)
            {
                # Subtrai a quantidade do produto
                $produto = Product::findOrFail($stock->product_id);
                $produto->quantidade = $produto->quantidade - $stock->quantidade;
                $produto->save();
            }

            return redirect()->route('estoques.index');
        }else{
            die('Erro ao excluir o Lançamento');
        }
    }
}
