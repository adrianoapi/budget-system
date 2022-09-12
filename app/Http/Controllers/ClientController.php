<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends UtilController
{
    private $title  = 'Cliente';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title. " listagem";

        $ids          = [];
        $name         = NULL;
        $responsavel  = NULL;
        $telefone     = NULL;

        if(array_key_exists('filtro',$_GET))
        {
            $name        = $_GET['name'       ];
            $responsavel = $_GET['responsavel'];
            $telefone    = $_GET['telefone'   ];

            $clients = Client::select('id')->where('name', 'like', '%' . $name . '%')
            ->where('active', true)
            ->where('responsavel', 'like', '%' . $responsavel . '%')
            ->where('telefone', 'like', '%' . rtrim($telefone) . '%')
            ->orderBy('name', 'asc')
            ->get();

            foreach($clients as $value):
                array_push($ids, $value->id);
            endforeach;

        }else{
            $clients = Client::select('id')->where('active', true)->orderBy('name', 'asc')->get();
            
            foreach($clients as $value):
                array_push($ids, $value->id);
            endforeach;
        }

        if(Auth::user()->level > 1)
        {
            $clients = Client::whereIn('id', $ids)
            ->where('active', true)
            ->orderBy('name', 'asc')
            ->paginate(20);
        }else{
            $clients = Client::whereIn('id', $ids)
            ->where('active', true)
            ->orderBy('name', 'asc')
            ->where('user_id', Auth::user()->id)
            ->paginate(20);
        }
        
        return view('clients.index', [
            'title' => $title,
            'clients' => $clients,
            'name' => $name,
            'responsavel' => $responsavel,
            'telefone' => $telefone
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title. " cadastar";

        return view('clients.add', ['title' => $title, 'estados' => $this->getEstados()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Client();
        $model->user_id       = Auth::id();
        $model->name          = $request->name;
        $model->responsavel   = $request->responsavel;
        $model->cpf_cnpj      = $request->cpf_cnpj;
        $model->ie            = $request->ie;
        $model->telefone      = $request->telefone;
        $model->telefone_com  = $request->telefone_com;
        $model->celular       = $request->celular;
        $model->email         = $request->email;
        $model->cep           = $request->cep;
        $model->endereco      = $request->endereco;
        $model->numero        = $request->numero;
        $model->complemento   = $request->complemento;
        $model->bairro        = $request->bairro;
        $model->cidade        = $request->cidade;
        $model->estado        = $request->estado;
        $model->active        = true;
        
        if($model->save()){
            return redirect()->route('clientes.index');
        }else{
            echo 'Erro ao cadastrar o cliente!';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $this->autoridadeCheck($client->user_id);
        $title = $this->title. " alterar";
        return view('clients.edit', ['title' => $title, 'client' => $client, 'estados' => $this->getEstados()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $client->updated_user_id = Auth::id();

        $client->name          = $request->name;
        $client->responsavel   = $request->responsavel;
        $client->cpf_cnpj      = $request->cpf_cnpj;
        $client->ie            = $request->ie;
        $client->telefone      = $request->telefone;
        $client->telefone_com  = $request->telefone_com;
        $client->celular       = $request->celular;
        $client->email         = $request->email;
        $client->cep           = $request->cep;
        $client->endereco      = $request->endereco;
        $client->numero        = $request->numero;
        $client->complemento   = $request->complemento;
        $client->bairro        = $request->bairro;
        $client->cidade        = $request->cidade;
        $client->estado        = $request->estado;
        $client->active        = true;
        
        if($client->save()){
            return redirect()->route('clientes.index');
        }else{
            echo 'Erro ao atualizar o cliente!';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->active = false;
        $client->deactivate_user_id = Auth::id();
        if($client->save()){
            return redirect()->route('clientes.index');
        }else{
            die('Erro ao excluir o Cliente');
        }
    }
}
