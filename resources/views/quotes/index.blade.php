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
                                        <th>Nome</th>
                                        <th>Responsável</th>
                                        <th>Telefone</th>
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
                                        <td>{{$value->created_at}}</td>
                                        <td class='hidden-1024'>
                                            {{ Form::open(['route' => ['cotacoes.destroy', $value->id],  'method' => 'POST', "onSubmit" => "return confirm('Deseja excluir?');", 'style' => 'margin: 0;padding:0;']) }}
                                                @csrf
                                                @method('delete')
                                                <a href="{{route('cotacoes.edit', $value->id)}}" class="btn" rel="tooltip" title="" data-original-title="Editar">
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
                            {{ $quotes->links('layouts.pagination') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
