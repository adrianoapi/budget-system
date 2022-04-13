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
        $title = $this->title. " listagem";
        $products = Product::where('active', true)->orderBy('descricao', 'asc')->paginate(10);
        return view('products.index', ['title' => $title, 'products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $model = new Product();
        $model->user_id   = Auth::id();
        $model->descricao = $request->descricao;
        $model->codigo    = $request->codigo;
        $model->espessura = $request->espessura;
        $model->cobre     = $request->cobre;
        $model->arco      = $request->arco;
        $model->valor     = str_replace(',', '.', str_replace('.', '', $request->valor));
        $model->icms      = str_replace(',', '.', $request->icms);
        $model->ipi       = str_replace(',', '.', $request->ipi);
        $model->active    = true;
        
        if($model->save()){
            return redirect()->route('produtos.index');
        }else{
            echo 'Erro ao cadastrar o cliente!';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function show(Request $request)
    {
        $product = Product::where('active', true)->firstOrFail();
        if(!empty($product))
        {
            return response()->json([
                'product' => $product
            ]);
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
        $product->updated_user_id = Auth::id();

        $product->descricao = $request->descricao;
        $product->codigo    = $request->codigo;
        $product->espessura = $request->espessura;
        $product->cobre     = $request->cobre;
        $product->arco      = $request->arco;
        $product->valor     = str_replace(',', '.', str_replace('.', '', $request->valor));
        $product->icms      = str_replace(',', '.', $request->icms);
        $product->ipi       = str_replace(',', '.', $request->ipi);
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
        $product->active = false;
        $product->deactivate_user_id = Auth::id();
        if($product->save()){
            return redirect()->route('clientes.index');
        }else{
            die('Erro ao excluir o Cliente');
        }
    }
}
