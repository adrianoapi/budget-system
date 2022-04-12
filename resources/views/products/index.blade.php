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
                                <a href="{{route('produtos.create')}}" class="btn btn-primary">
                                <i class="icon-reorder"></i> Novo</a>
                            </span>
                        </div>

                        <div class="box-content nopadding">
                            <table class="table table-hover table-nomargin table-colored-header">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Código</th>
                                        <th class='hidden-350'>Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($products as $value)
                                    <tr>
                                        <td>{{$value->descricao}}</td>
                                        <td>{{$value->codigo}}</td>
                                        <td>{{$value->valor}}</td>
                                        <td class='hidden-1024'>
                                            {{ Form::open(['route' => ['produtos.destroy', $value->id],  'method' => 'POST', "onSubmit" => "return confirm('Deseja excluir?');"]) }}
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
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
