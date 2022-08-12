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
                                                        <select name="close" id="close" class='input-block-level'>
                                                            <option value="">Fechada?</option>
                                                            <option value="yes" {{$close == "yes" ? 'selected':''}}>Sim</option>
                                                            <option value="no"  {{$close == "no"  ? 'selected':''}}>Não</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <input id="created_at" placeholder="Data" type="text" name="created_at" value="" class="input-block-level">
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
                                        <th>Fechada</th>
                                        <th>Data</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($quotes as $value)
                                    <tr>
                                        <td>{{$value->Client->name}}</td>
                                        <td>{{$value->Client->responsavel}}</td>
                                        <td>
                                            @if(!empty($value->Client->telefone))
                                                {{$value->Client->telefone}} |
                                            @endif
                                            @if(!empty($value->Client->telefone_com))
                                                {{$value->Client->telefone_com}} |
                                            @endif
                                            @if(!empty($value->Client->celular))
                                                {{$value->Client->celular}}
                                            @endif
                                        </td>
                                        <td>{{$value->close}}</td>
                                        <td>{{$value->created_at}}</td>
                                        <td class='hidden-1024'>
                                            {{ Form::open(['route' => ['cotacoes.destroy', $value->id],  'method' => 'POST', "onSubmit" => "return confirm('Deseja excluir?');", 'style' => 'margin: 0;padding:0;']) }}
                                                @csrf
                                                @method('delete')
                                                
                                                @if($value->close)
                                                <a href="{{route('cotacoes.edit', $value->id)}}" class="btn" rel="tooltip" title="" data-original-title="Visualizar">
                                                    <i class="icon-eye-open"></i>
                                                </a>
                                                @else
                                                <a href="{{route('cotacoes.edit', $value->id)}}" class="btn" rel="tooltip" title="" data-original-title="Editar">
                                                    <i class="icon-edit"></i>
                                                </a>
                                                @endif

                                                @if($value->close)
                                                <button type="button" class="btn" rel="tooltip" title="" data-original-title="Excluir" disabled="disabled">
                                                    <i class="icon-trash"></i>
                                                </button>
                                                @else
                                                <button type="submit" class="btn" rel="tooltip" title="" data-original-title="Excluir">
                                                    <i class="icon-trash"></i>
                                                </button>
                                                @endif
                                                
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $quotes->links('layouts.pagination') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
