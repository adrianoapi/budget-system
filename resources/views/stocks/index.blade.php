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
                                <a href="{{route('estoques.create')}}" class="btn btn-primary">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <select name="inserido" id="inserido" class='input-block-level'>
                                                            <option value="todos" {{$inserido == 'todos' ? 'selected':''}}>Lançado?</option>
                                                            <option value="sim" {{($inserido == 'sim')  ? 'selected':''}}>Sim</option>
                                                            <option value="nao" {{($inserido == 'nao') ? 'selected':''}}>Não</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
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
                                        <th>Descrição</th>
                                        <th>Quantidade</th>
                                        <th>Lançado</th>
                                        <th class='hidden-350'>Lançamento</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($stocks as $key => $value)
                                    <tr>
                                        <td>{{$value->produto->descricao}}</td>
                                        <td>{{$value->quantidade}}</td>
                                        <td>
                                            @if($value->inserido)
                                                SIM
                                            @else
                                                NAO
                                            @endif
                                        </td>
                                        <td>{{$value->dt_lancamento}}</td>
                                        <td class='hidden-1024'>
                                            {{ Form::open(['route' => ['estoques.destroy', $value->id], 
                                            'method' => 'POST',
                                            "onSubmit" => "return confirm('Deseja excluir?');",
                                            "style" => 'margin: 0;padding:0;']) }}
                                                @csrf
                                                @method('delete')
                                              
                                                <button type="submit" class="btn" rel="tooltip" title="" data-original-title="Excluir">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $stocks->links('layouts.pagination') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
