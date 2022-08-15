<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends UtilController
{
    private $title  = 'Emporesa';

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

            $companies = Company::where('name', 'like', '%' . $name . '%')
            ->where('active', true)
            ->where('responsavel', 'like', '%' . $responsavel . '%')
            ->where('telefone', 'like', '%' . rtrim($telefone) . '%')
            ->orderBy('name', 'asc')
            ->paginate(10);

        }else{
            $companies = Company::where('active', true)->orderBy('name', 'asc')->paginate(10);
        }

        return view('companies.index', [
            'title' => $title,
            'companies' => $companies,
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

        return view('companies.add', ['title' => $title, 'estados' => $this->getEstados()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Company();
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
            return redirect()->route('empresas.index');
        }else{
            echo 'Erro ao cadastrar o cliente!';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $this->autoridadeCheck($company->user_id);
        $title = $this->title. " alterar";
        return view('companies.edit', ['title' => $title, 'company' => $company, 'estados' => $this->getEstados()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $company->updated_user_id = Auth::id();

        $company->name          = $request->name;
        $company->responsavel   = $request->responsavel;
        $company->cpf_cnpj      = $request->cpf_cnpj;
        $company->ie            = $request->ie;
        $company->telefone      = $request->telefone;
        $company->telefone_com  = $request->telefone_com;
        $company->celular       = $request->celular;
        $company->email         = $request->email;
        $company->cep           = $request->cep;
        $company->endereco      = $request->endereco;
        $company->numero        = $request->numero;
        $company->complemento   = $request->complemento;
        $company->bairro        = $request->bairro;
        $company->cidade        = $request->cidade;
        $company->estado        = $request->estado;
        $company->active        = true;
        
        if($company->save()){
            return redirect()->route('empresas.index');
        }else{
            echo 'Erro ao atualizar o cliente!';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->active = false;
        $company->deactivate_user_id = Auth::id();

        if($company->save()){
            return redirect()->route('empresas.index');
        }else{
            die('Erro ao excluir o Cliente');
        }
    }
}
