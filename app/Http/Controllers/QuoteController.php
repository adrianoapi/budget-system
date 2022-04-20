<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends UtilController
{
    private $title  = 'Cotação';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title. " listagem";

        if(Auth::user()->level > 1)
        {
            $products = Product::where('active', true)->orderBy('descricao', 'asc')->paginate(10);
            $quotes = Quote::where('active', true)->orderBy('id', 'desc')->paginate(100);
        }else{
            $quotes = Quote::where('active', true)->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(100);
        }
        
        return view('quotes.index', ['title' => $title, 'quotes' => $quotes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function create($client)
    {
        $title = $this->title. " cadastar";
        
        $id     = (int) $client;
        $client = Client::where('active', true)
                    ->where('id', $id)
                    ->firstOrFail();

        if(!empty($client)){

            $this->autoridadeCheck($client->user_id);

            $model = new Quote();
            $model->user_id     =  $client->user_id;
            $model->client_id   =  $client->id;

            if($model->save()){
                return redirect()->route('cotacoes.edit', ['quote' => $model->id]);
            }

        }else{
            die('Cliente não encontrado!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function edit(Quote $quote)
    {
        $title = $this->title. " editar";

        $products = Product::where('active', true)->orderBy('descricao', 'asc')->paginate(1000);
        return view('quotes.edit', [
            'title' => $title,
            'quote' => $quote,
            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function items(Quote $quote)
    {
        return response()->json([
            'table'   => view('quotes.itemsTable', [
                'items' => $quote->Items,
                'comissao' => $quote->Client->User->comissao
                ])->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        //
    }
}
