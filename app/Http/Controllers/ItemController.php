<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends UtilController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = json_decode($request->data);

        $last  = Item::where('quote_id', $attributes->cotacao)->orderBy('ordem', 'asc')->first();
        $quote = Quote::find($attributes->cotacao);

        if(!empty($quote))
        {
            $model = new Item();
            $model->quote_id   = (int) $attributes->cotacao;
            $model->product_id = (int) $attributes->produto;
            $model->quantidade = (int) $attributes->quantidade;
            $model->ordem      = !empty($last) ? --$last->ordem : 1;
            $model->fator      = !empty($quote->fator) ? $quote->fator : '0.00';
            $model->icms       = !empty($quote->icms ) ? $quote->icms  : 'inclusivo';
            $model->ipi        = !empty($quote->ipi  ) ? $quote->ipi   : 'inclusivo';

            if($model->save()){
                return true;
            } 
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $item = Item::find($request->id);
        $item->quantidade = (int) $request->quantidade;
        $item->fator      =  str_replace(",", ".", $request->fator);
        $item->icms       =  $request->icms;
        $item->ipi        =  $request->ipi;
        
        if(Auth::user()->level <= 1)
        {
            $this->autoridadeCheck($item->quote->client->user_id);
            
            if((float) $item->fator < 0.6){
                return response()->json('Apenas o Administrador poderá aplicar FATOR menor que 0,60!', 403);
            }
        }

        return $item->save();
    }

    public function order(Request $request)
    {
        $item = Item::find($request->id);

        if($request->ordem == "up"){
            $item->ordem =  ++$item->ordem;
            $old = Item::where('ordem', $item->ordem)->first();
            if(!empty($old)){
                $old->ordem = --$old->ordem;
                $old->save();
            }
        }else{
            $item->ordem = --$item->ordem;
            $old = Item::where('ordem', $item->ordem)->first();
            if(!empty($old)){
                $old->ordem = ++$old->ordem;
                $old->save();
            }
        }
        return $item->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function destroy(request $request)
    {
        $item = Item::where('id', $request->id)->firstOrFail();

        $this->autoridadeCheck($item->Quote->user_id);

        $ordem = $item->ordem;

        if($item->delete()){

            $updete = Item::where('quote_id', $item->quote_id)
            ->where('ordem', '>', $item->ordem)
            ->get();

            foreach($updete as $up):
                $up->ordem = --$up->ordem;
                $up->save();
            endforeach;

            return true;
        }
    }
}
