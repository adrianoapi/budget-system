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
                                <a href="{{route('produtos.export')}}" class="btn btn-primary">
                                    <i class="icon-reorder"></i> Exportar</a>
                                <a href="{{route('produtos.create')}}" class="btn btn-primary">
                                <i class="icon-reorder"></i> Novo</a>
                            </span>
                        </div>

                        <div class="box-content nopadding">
                            <table class="table table-hover table-nomargin table-colored-header">
                                <thead>
                                    <tr>
                                        <th>
                                        </th>
                                        <th>
                                            <form action="" method="GET" class="span12" style="margin: 0;padding:0;">
                                            <input type="hidden" name="filtro" id="filtro" value="pesquisa">
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <input id="descricao" placeholder="Descrição" type="text" name="descricao" value="{{$descricao}}" class="input-block-level">
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th colspan="2">
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <input id="codigo" placeholder="Código" type="text" name="codigo" value="{{$codigo}}" class="input-block-level">
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
                                        <th>Quantidade</th>
                                        <th>Descrição</th>
                                        <th>Código</th>
                                        <th class='hidden-350'>Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($products as $value)
                                    <tr>
                                        <td>{{$value->quantidade}}</td>
                                        <td>
                                            {{$value->descricao}}
                                            <?php

                                            $stockProds = \App\Models\Stock::where('deleted_at', NULL)
                                                            ->where('product_id', $value->id)
                                                            ->where('inserido', false)
                                                            ->orderBy('dt_lancamento', 'asc')
                                                            ->limit(5)
                                                            ->get();
                                    
                                              foreach($stockProds as $stock):
                                                  echo "<li>Previsão de mais <strong>{$stock->quantidade}</strong> produtos no estoque em <strong>{$stock->dt_lancamento}</strong></li>";
                                              endforeach;
                                            ?>
                                        </td>
                                        <td>{{$value->codigo}}</td>
                                        <td>{{$value->valor}}</td>
                                        <td class='hidden-1024'>
                                            {{ Form::open(['route' => ['produtos.destroy', $value->id], 
                                            'method' => 'POST',
                                            "onSubmit" => "return confirm('Deseja excluir?');",
                                            "style" => 'margin: 0;padding:0;']) }}
                                                @csrf
                                                @method('delete')
                                                <a href="{{route('produtos.edit', $value->id)}}" class="btn" rel="tooltip" title="" data-original-title="Editar">
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
                            {{ $products->links('layouts.pagination') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
