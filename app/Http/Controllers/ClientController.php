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
        $this->levelCheck();
        $title = $this->title. " listagem";
        $clients = Client::where('active', true)->orderBy('name', 'asc')->paginate(100);
        return view('clients.index', ['title' => $title, 'users' => $clients]);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
