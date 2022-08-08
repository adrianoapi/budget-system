@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid" id="content">

    @include('layouts.navigation')

    <div id="main">
        <div class="container-fluid">

            <div class="row-fluid">
                <div class="span12">
                    <div class="box box-bordered">
                        <div class="box-title">
                            <h3>
                                <i class="icon-reorder"></i>
                                {{$title}}
                            </h3>
                            <span class="tabs">
                                <a href="{{route('clientes.create')}}" class="btn btn-primary">
                                <i class="icon-reorder"></i> Novo</a>
                            </span>
                        </div>

                        <div class="box-content nopadding">
                            <table class="table table-hover table-nomargin table-colored-header">
                                <thead>
                                    <tr>
                                        <th>
                                            <form action="" method="GET" class="span12" style="margin: 0;padding:0;">
                                            <input type="hidden" name="filtro" id="filtro" value="pesquisa">
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <input id="name" placeholder="Nome" type="text" name="name" value="{{$name}}" class="input-block-level">
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <input id="responsavel" placeholder="Responsável" type="text" name="responsavel" value="{{$responsavel}}" class="input-block-level">
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <input id="telefone" placeholder="Telefone" type="text" name="telefone" value="{{$telefone}}" class="input-block-level">
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <span class="input-group-append">
                                                            <button type="submit" class="btn btn-sm" style="margin-top:-10px;">Pesquisar</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Responsável</th>
                                        <th>Telefone</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $value)
                                    <tr>
                                        <td>{{$value->name}}</td>
                                        <td>{{$value->responsavel}}</td>
                                        <td>
                                            @if(!empty($value->telefone))
                                                {{$value->telefone}} |
                                            @endif
                                            @if(!empty($value->telefone_com))
                                                {{$value->telefone_com}} |
                                            @endif
                                            @if(!empty($value->celular))
                                                {{$value->celular}}
                                            @endif
                                        </td>
                                        <td class='hidden-1024'>
                                            {{ Form::open(['route' => ['clientes.destroy', $value->id],  'method' => 'POST', "onSubmit" => "return confirm('Deseja excluir?');", 'style' => 'margin: 0;padding:0;']) }}
                                                @csrf
                                                @method('delete')
                                                <a href="{{route('cotacoes.create', $value->id)}}" class="btn btn-info" rel="tooltip" title="" data-original-title="Nova Cotação">
                                                    <i class="glyphicon-new_window"></i>
                                                </a>
                                                <a href="{{route('clientes.edit', $value->id)}}" class="btn" rel="tooltip" title="" data-original-title="Editar">
                                                    <i class="icon-edit"></i>
                                                </a>
                                                <button type="submit" class="btn" rel="tooltip" title="" data-original-title="Excluir">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
