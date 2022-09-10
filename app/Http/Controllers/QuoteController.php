<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Client;
use App\Models\Product;
use App\Models\Item;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecoverMail;
use App\Mail\SendQuote;
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
        $aprovado     = NULL;
        $serial       = NULL;

        if(array_key_exists('filtro', $_GET))
        {
            $name        = $_GET['name'       ];
            $responsavel = $_GET['responsavel'];
            $telefone    = $_GET['telefone'   ];
            $close       = $_GET['close'      ];
            $aprovado    = $_GET['aprovado'   ];
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

        if(!empty($aprovado))
        {
            $quotes = Quote::select('id')->whereIn('id', $quoteIds)
            ->where('aprovado', $aprovado == "yes" ? true : false)
            ->orderBy('id', 'desc')
            ->get();

            $quoteIds = [];
            foreach($quotes as $value):
                array_push($quoteIds, $value->id);
            endforeach;

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
            'title'       => $title,
            'quotes'      => $quotes,
            'name'        => $name,
            'responsavel' => $responsavel,
            'telefone'    => $telefone,
            'close'       => $close,
            'aprovado'    => $aprovado,
            'serial'      => $serial,
            'dt_inicio'   => !empty($this->dtInicial) ? $this->dataBr($this->dtInicial) : NULL,
            'dt_fim'      => !empty($this->dtFinal  ) ? $this->dataBr($this->dtFinal  ) : NULL
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
            $model->fator       = "0.00";
            $model->total       = "0.00";
            $model->percentual  = "0.00";
            $model->frete       = "0.00";
            $model->serial      = uniqid();

            if($model->save()){

                # Update serial
                $model->serial = $this->nameGenerate(
                    $model->Company->name,
                    $model->Client->estado,
                    $model->id,
                    $model->Client->name
                );
                $model->save();

                return redirect()->route('cotacoes.edit', ['quote' => $model->id]);
            }

        }else{
            die('Cliente não encontrado!');
        }
    }

    public function nameGenerate($companyName, $clientUF, $quoteID, $clientName)
    {
       $arrClient  = explode(" ", $clientName);
       $clientName = NULL;
       $i=0;
       foreach($arrClient as $value):
        
        $i++;
        $clientName .= "{$value} ";

        if($i >= 3){
            break;
        }
       endforeach;

       $companyName = substr($companyName, 0, 3);
       return "{$companyName} - {$clientUF} - {$quoteID} - {$clientName}";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function check(Request $request)
    {
        if(Auth::user()->level <= 1)
        {
            $client = Client::where('active', true)->where('user_id', Auth::user()->id)->first();

            if(!empty($client)){
                return redirect()->route('cotacoes.create', ['client' => $client->id]);
            }else{
                return redirect()->route('cotacoes.index')->with(
                    'quote_index',
                    'Seu usuário não possui clientes cadastrados!'
                );
            }
        }else{
            $client = Client::where('active', true)->first();

            if(!empty($client)){
                return redirect()->route('cotacoes.create', ['client' => $client->id]);
            }else{
                return redirect()->route('cotacoes.index')->with(
                    'quote_index',
                    'Não existem clientes cadastrados!'
                );
            }
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
        $clients   = Client::select('id','name')->where('active', true)->where('user_id', Auth::user()->id)->orderBy('name', 'asc')->get();
        $products  = Product::where('active', true)->orderBy('descricao', 'asc')->paginate(1000);

        return view('quotes.edit', [
            'title'      => $title,
            'quote'      => $quote,
            'products'   => $products,
            'companies'  => $companies,
            'clients'    => $clients,
            'fatorLista' => $this->fatorLista(),
            'icmsLista'  => $this->icmsLista(),
            'ipiLista'   => $this->ipiLista()
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

        $pdf = PDF::loadView('quotes.pdf.resume', [
            'quote' => $quote,
            'quote' => $quote,
            'icmsLista' => $this->icmsLista(),
            'ipiLista' => $this->ipiLista()
        ]);
            #->setPaper('a4', 'landscape')
        $fileName = $quote->serial."_".time().".pdf";

        if (Mail::failures()) {
            die('Erro no envio de e-mail');
        }

        return $pdf->download($fileName);
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
        $model->user_id        = $quote->user_id;
        $model->client_id      = $quote->client_id;
        $model->company_id     = $quote->company_id;
        $model->name           = $quote->name;
        $model->ipi            = $quote->ipi;
        $model->icms           = $quote->icms;
        $model->fator          = $quote->fator;
        $model->total          = $quote->total;
        $model->pagamento      = $quote->pagamento;
        $model->prazo          = $quote->prazo;
        $model->transportadora = $quote->transportadora;
        $model->representante  = $quote->representante;
        $model->percentual     = $quote->percentual;
        $model->serial         = uniqid();

        if($model->save()){

            foreach($quote->Items as $value):
                $item = new Item();
                $item->quote_id   = $model->id;
                $item->product_id = $value->product_id;
                $item->quantidade = $value->quantidade;
                $item->fator      = $value->fator;
                $item->icms       = $value->icms;
                $item->ipi        = $value->ipi;
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
    public function approve(Quote $quote)
    {
        if(Auth::user()->level <= 1)
        {
            $this->autoridadeCheck($quote->Client->user_id);

            if($quote->aprovado == true)
            {
                return redirect()->route('cotacoes.edit', ['quote' => $quote->id])->with(
                    'quote_close',
                    'Apenas o Administrador pode desaprovar o orçamento!'
                );
            }
        }

        $quote->aprovado  = $quote->aprovado == true ? false : true;

        if($quote->save()){

            #Após salvar envia mensagem
            if($quote->aprovado == true)
            {
                $users = \App\Models\User::where('level', 2)
                    ->where('active', true)
                    ->orderBy('name', 'asc')
                    ->get();

                # Alerta
                $message = new \App\Models\Message();
                $message->title = "Nova Aprovação";
                $message->type  = "alert";
                $message->body  = "Novo orçamento aprovado com sucesso!";
                if($message->save())
                {
                    foreach($users as $user):
                        $action = new \App\Models\Action();
                        $action->user_id = $user->id;
                        $action->message_id = $message->id;
                        $action->save();
                    endforeach;
                }


                # E-mail
                $message = new \App\Models\Message();
                $message->title = "Nova Aprovação";
                $message->type  = "email";
                $message->body  = view('quotes.pdf.resume', [
                                        'quote' => $quote,
                                        'icmsLista' => $this->icmsLista(),
                                        'ipiLista' => $this->ipiLista()
                                    ])
                                    ->render();
                if($message->save())
                {
                    foreach($users as $user):
                        $action = new \App\Models\Action();
                        $action->user_id    = $user->id;
                        $action->message_id = $message->id;
                        $action->save();
                    endforeach;
                }
            }
                
            return redirect()->route('cotacoes.edit', ['quote' => $quote->id]);
        }else{
            die('Erro ao aprovar a cotação!');
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
                'fatorLista' => $this->fatorLista(),
                'icmsLista' => $this->icmsLista(),
                'ipiLista' => $this->ipiLista()
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

        if(empty($request->company_id)){
            return redirect()->route('cotacoes.edit', ['quote' => $quote->id])->with(
                'quote_close',
                'É necessário selecionar uma Empresa!'
            );
        }

        if(empty($request->client_id)){
            return redirect()->route('cotacoes.edit', ['quote' => $quote->id])->with(
                'quote_close',
                'É necessário selecionar um Cliente!'
            );
        }

        if(!empty($request->company_id)){
            $quote->company_id = (int) $request->company_id;
            $quote->client_id  = (int) $request->client_id;
            $quote->name       = $request->name;
            $quote->total      = $request->total;
            $quote->percentual = $request->percentual;
            $quote->frete      = $request->frete;

            if(Auth::user()->level > 1)
            {
                $quote->aprovado = $request->aprovado;
            }

            if($quote->save())
            {
                # Update serial
                $quote->serial = $this->nameGenerate(
                    $quote->Company->name,
                    $quote->Client->estado,
                    $quote->id,
                    $quote->Client->name
                );
                $quote->save();

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

        /*if($request->fator < 0 || $request->fator > 9){
            return redirect()->route('cotacoes.edit', ['quote' => $quote->id])->with(
                'quote_close',
                'O campo Fator precisa ser um número entre 0.0 e 0.9!'
            );
        }*/

        $quote->fator = $request->fator;
        
        if($quote->save()){

            foreach($quote->items as $value):
                $value->fator = $quote->fator;
                $value->save();
            endforeach;

            return redirect()->route('cotacoes.edit', ['quote' => $quote->id]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function updateIcms(Request $request, Quote $quote)
    {
        if(Auth::user()->level <= 1)
        {
            $this->autoridadeCheck($quote->client->user_id);
        }

        if(empty($request->icms)){
            return redirect()->route('cotacoes.edit', ['quote' => $quote->id])->with(
                'quote_close',
                'O campo <strong>ICMS</strong> precisa ser preenchido!'
            );
        }

        $quote->icms = $request->icms;
        
        if($quote->save()){

            foreach($quote->items as $value):
                $value->icms = $quote->icms;
                $value->save();
            endforeach;

            return redirect()->route('cotacoes.edit', ['quote' => $quote->id]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function updateIpi(Request $request, Quote $quote)
    {
        if(Auth::user()->level <= 1)
        {
            $this->autoridadeCheck($quote->client->user_id);
        }

        if(empty($request->ipi)){
            return redirect()->route('cotacoes.edit', ['quote' => $quote->id])->with(
                'quote_close',
                'O campo <strong>IPI</strong> precisa ser preenchido!'
            );
        }

        $quote->ipi = $request->ipi;
        
        if($quote->save()){

            foreach($quote->items as $value):
                $value->ipi = $quote->ipi;
                $value->save();
            endforeach;

            return redirect()->route('cotacoes.edit', ['quote' => $quote->id]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function updateComercial(Request $request, Quote $quote)
    {
        if(Auth::user()->level <= 1)
        {
            $this->autoridadeCheck($quote->client->user_id);
        }

        $quote->pagamento      = $request->pagamento;
        $quote->prazo          = $request->prazo;
        $quote->transportadora = $request->transportadora;
        $quote->representante  = $request->representante;
        
        if($quote->save())
        {
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

    private function sendMail()
    {

    }
}
