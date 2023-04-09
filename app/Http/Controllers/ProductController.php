<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends UtilController
{
    private $title  = 'Produto';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->levelCheck();

        $descricao  = NULL;
        $codigo     = NULL;

        if(array_key_exists('filtro',$_GET))
        {
            # Pega todos os id de estudantes onde
            # algum dos campos atenda ao menos
            # uma coluna abaixo.
            $descricao  = $_GET['descricao' ];
            $codigo     = $_GET['codigo'];

            $products = Product::where('descricao', 'like', '%' . $descricao . '%')
            ->where('active', true)
            ->where('codigo', 'like', '%' . $codigo . '%')
            ->orderBy('descricao', 'asc')
            ->paginate(20);

        }else{
            $products = Product::where('active', true)->orderBy('descricao', 'asc')->paginate(20);
        }

        $title = $this->title. " listagem";
        return view('products.index', [
            'title' => $title,
            'products' => $products,
            'descricao' => $descricao,
            'codigo' => $codigo
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->levelCheck();
        $title = $this->title. " cadastar";

        return view('products.add', ['title' => $title]);
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
        $model = new Product();
        $model->user_id   = Auth::id();
        $model->descricao = $request->descricao;
        $model->codigo    = $request->codigo;
        $model->espessura = $request->espessura;
        $model->cobre     = $request->cobre;
        $model->aco       = $request->aco;
        $model->valor     = str_replace(',', '.', str_replace('.', '', $request->valor));
        $model->linha     = $request->linha;
        $model->caixa     = $request->caixa;
        $model->unidade   = $request->unidade;
        $model->active    = true;
        
        if($model->save()){
            return redirect()->route('produtos.index');
        }else{
            echo 'Erro ao cadastrar o cliente!';
        }
    }

    public function export()
    {
        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=produtos_".time().".xls");
        header("Pragma: no-cache");

        $products = Product::where('active', true)->orderBy('descricao', 'asc')->get();

        return view('products.excel.prod', ['products' => $products]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function show(Request $request)
    {
        $product = Product::where('active', true)->where('id', $request->id)->firstOrFail();
        $product->quantidade_estoque = $product->quantidade;
        if(!empty($product))
        {
            return response()->json($product);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->levelCheck();
        $title = $this->title. " alterar";
        return view('products.edit', ['title' => $title, 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->levelCheck();
        $product->updated_user_id = Auth::id();

        $product->descricao = $request->descricao;
        $product->codigo    = $request->codigo;
        $product->espessura = $request->espessura;
        $product->cobre     = $request->cobre;
        $product->aco       = $request->aco;
        $product->valor     = str_replace(',', '.', str_replace('.', '', $request->valor));
        $product->linha     = $request->linha;
        $product->caixa     = $request->caixa;
        $product->unidade   = $request->unidade;
        $product->active    = true;

        if($product->save()){
            return redirect()->route('produtos.index');
        }else{
            echo 'Erro ao atualizar o produto!';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->levelCheck();
        $product->active = false;
        $product->deactivate_user_id = Auth::id();
        if($product->save()){
            return redirect()->route('clientes.index');
        }else{
            die('Erro ao excluir o Cliente');
        }
    }
}
