<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Client;
use App\Models\Product;
use App\Models\Item;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class QuoteController extends UtilController
{
    private $title  = 'Cotação';
    private $dtInicial;
    private $dtFinal;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title. " listagem";

        $ids          = [];
        $quoteIds     = [];
        $name         = NULL;
        $responsavel  = NULL;
        $telefone     = NULL;
        $close        = NULL;
        $serial       = NULL;

        if(array_key_exists('filtro', $_GET))
        {
            $name        = $_GET['name'       ];
            $responsavel = $_GET['responsavel'];
            $telefone    = $_GET['telefone'   ];
            $close       = $_GET['close'      ];
            $serial      = $_GET['serial'     ];

            $this->dtInicial = strlen($_GET['dt_inicio']) > 2 ? $this->dataSql($_GET['dt_inicio']) : $this->dtInicial;
            $this->dtFinal   = strlen($_GET['dt_fim'   ]) > 2 ? $this->dataSql($_GET['dt_fim'   ]) : $this->dtFinal;

            $clients = Client::select('id')->where('name', 'like', '%' . $name . '%')
            ->where('active', true)
            ->where('responsavel', 'like', '%' . $responsavel . '%')
            ->where('telefone', 'like', '%' . rtrim($telefone) . '%')
            ->orderBy('name', 'asc')
            ->paginate(10);

            foreach($clients as $value):
                array_push($ids, $value->id);
            endforeach;

        }else{
            $clients = Client::select('id')->where('active', true)->orderBy('name', 'asc')->paginate(10);
            
            foreach($clients as $value):
                array_push($ids, $value->id);
            endforeach;
        }

        # Se for administrador
        if(Auth::user()->level > 1)
        {
            if(!empty($close))
            {
                $quotes = Quote::select('id')->whereIn('client_id', $ids)
                ->where('active', true)
                ->where('serial', 'like', '%' . rtrim($serial) . '%')
                ->where('close', $close == "yes" ? true : false)
                ->orderBy('id', 'desc')
                ->get();

                foreach($quotes as $value):
                    array_push($quoteIds, $value->id);
                endforeach;

            }else{
                $quotes = Quote::select('id')->whereIn('client_id', $ids)
                ->where('active', true)
                ->where('serial', 'like', '%' . rtrim($serial) . '%')
                ->orderBy('id', 'desc')
                ->get();

                foreach($quotes as $value):
                    array_push($quoteIds, $value->id);
                endforeach;
            }

        }else
        {
            # Se for usuário comum
            if(!empty($close))
            {
                $quotes = Quote::select('id')->whereIn('client_id', $ids)
                ->where('active', true)
                ->where('serial', 'like', '%' . rtrim($serial) . '%')
                ->where('close', $close == "yes" ? true : false)
                ->where('close', $close == "yes" ? true : false)
                ->where('user_id', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->get();

                foreach($quotes as $value):
                    array_push($quoteIds, $value->id);
                endforeach;

            }else{
                $quotes = Quote::select('id')->whereIn('client_id', $ids)
                ->where('active', true)
                ->where('serial', 'like', '%' . rtrim($serial) . '%')
                ->where('user_id', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->get();

                foreach($quotes as $value):
                    array_push($quoteIds, $value->id);
                endforeach;
            }
        }

        if(!empty($this->dtInicial) && !empty($this->dtFinal))
        {
            if($this->dtInicial > $this->dtFinal)
            {
                return redirect()->route('cotacoes.index')->with(
                    'quote_filter',
                    'A data Inicial não pode ser maior que a data Final!'
                );
            }else{
                $quotes = Quote::select('id')->whereIn('id', $quoteIds)
                ->where('active', true)
                ->where('created_at', '>=', $this->dtInicial.' 00:00:00')
                ->where('created_at', '<=', $this->dtFinal.' 23:59:59')
                ->orderBy('id', 'desc')
                ->get();
                
                $quoteIds = [];
                foreach($quotes as $value):
                    array_push($quoteIds, $value->id);
                endforeach;
            }
        }
            

        $quotes = Quote::whereIn('id', $quoteIds)
        ->orderBy('id', 'desc')
        ->paginate(100);
        
        return view('quotes.index', [
            'title' => $title,
            'quotes' => $quotes,
            'name' => $name,
            'responsavel' => $responsavel,
            'telefone' => $telefone,
            'close' => $close,
            'serial' => $serial,
            'dt_inicio' => !empty($this->dtInicial) ? $this->dataBr($this->dtInicial) : NULL,
            'dt_fim' => !empty($this->dtFinal     ) ? $this->dataBr($this->dtFinal  ) : NULL
        ]);
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

        $company = Company::where('active', true)->first();

        if(empty($company)){
            die('Nenhuma empresa encontrada!');
        }
        
        $id     = (int) $client;
        $client = Client::where('active', true)
                    ->where('id', $id)
                    ->firstOrFail();

        if(!empty($client)){

            $this->autoridadeCheck($client->user_id);
            $model = new Quote();
            $model->company_id  = $company->id;
            $model->user_id     = $client->user_id;
            $model->client_id   = $client->id;
            $model->fator       = "0.0";
            $model->total       = "0.00";
            $model->serial      = uniqid();

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
        $this->autoridadeCheck($quote->Client->user_id);

        $title = $this->title. " editar";

        $companies = Company::select('id','name')->where('active', true)->orderBy('name', 'asc')->get();
        $products  = Product::where('active', true)->orderBy('descricao', 'asc')->paginate(1000);

        return view('quotes.edit', [
            'title' => $title,
            'quote' => $quote,
            'products' => $products,
            'companies' => $companies,
            'fatorLista' => $this->fatorLista()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function export(Quote $quote)
    {
        $this->autoridadeCheck($quote->Client->user_id);

        $pdf = PDF::loadView('quotes.pdf.resume', ['quote' => $quote]);

        return $pdf->download('auth.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function close(Quote $quote)
    {
        $this->autoridadeCheck($quote->Client->user_id);

        if($quote->Items->count() < 1){
            return redirect()->route('cotacoes.edit', $quote->id)->with(
                'quote_close',
                'Não pode fechar cotação sem produtos!'
            );
        }

        $quote->close  = true;

        if($quote->save()){
            return redirect()->route('cotacoes.edit', ['quote' => $quote->id]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function clone(Quote $quote)
    {
        $this->autoridadeCheck($quote->Client->user_id);

        $quote->close  = false;

        $model = new Quote();
        $model->user_id     = $quote->user_id;
        $model->client_id   = $quote->client_id;
        $model->company_id  = $quote->company_id;
        $model->fator       = $quote->fator;
        $model->total       = $quote->total;
        $model->serial      = uniqid();

        if($model->save()){

            foreach($quote->Items as $value):
                $item = new Item();
                $item->quote_id   = $model->id;
                $item->product_id = $value->product_id;
                $item->quantidade = $value->quantidade;
                $item->save();
            endforeach;

            return redirect()->route('cotacoes.edit', ['quote' => $model->id]);
        }else{
            die('Erro ao clonar a cotação!');
        }

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
                'quote' => $quote,
                'fatorLista' => $this->fatorLista()
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
        if(Auth::user()->level <= 1)
        {
            $this->autoridadeCheck($quote->client->user_id);
        }
        
        if($quote->close){
            return redirect()->route('cotacoes.edit', ['quote' => $quote->id])->with(
                'quote_close',
                'Não é possível alterar uma cotação Fechada!'
            );
        }

        if(empty($request->total) || $request->total < 0){
            return redirect()->route('cotacoes.edit', ['quote' => $quote->id])->with(
                'quote_close',
                'O campo Total não pode ser menor que 0,00!'
            );
        }

        if(!empty($request->company_id)){
            $quote->company_id = (int) $request->company_id;
            $quote->total      = $request->total;
            $quote->percentual = $request->percentual;
            $quote->frete      = $request->frete;

            if(Auth::user()->level > 1)
            {
                $quote->aprovado = $request->aprovado;
            }

            if($quote->save())
            {
                return redirect()->route('cotacoes.edit', ['quote' => $quote->id]);
            }
            
        }else{
            return redirect()->route('cotacoes.edit', ['quote' => $quote->id])->with(
                'quote_close',
                'Selecione uma empresa!'
            );
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function updateFator(Request $request, Quote $quote)
    {
        if(Auth::user()->level <= 1)
        {
            $this->autoridadeCheck($quote->client->user_id);
        }

        if($request->fator < 0 || $request->fator > 9){
            return redirect()->route('cotacoes.edit', ['quote' => $quote->id])->with(
                'quote_close',
                'O campo Fator precisa ser um número entre 0.0 e 0.9!'
            );
        }

        $quote->fator = ($request->fator == 0) ? 0.0 : "0.$request->fator";
        
        if($quote->save()){

            foreach($quote->items as $value):
                $value->fator = $quote->fator;
                $value->save();
            endforeach;

            return redirect()->route('cotacoes.edit', ['quote' => $quote->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        $this->autoridadeCheck($quote->Client->user_id);

        if($quote->close){
            return redirect()->route('cotacoes.edit', $quote->id)->with(
                'quote_close',
                'Cotações fechadas não podem ser excluídas!'
            );
        }

        if($quote->delete()){
            return redirect()->route('cotacoes.index');
        }

    }
}
