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
                                {{$header}}
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
                                                        <input id="title" placeholder="title" type="text" name="title" value="{{$title}}" class="input-block-level">
                                                    </div>
                                                </div>
										    </div>
                                        </th>
                                        <th>
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <select name="type" id="type" class='input-block-level'>
                                                            <option value="">Type</option>
                                                            @foreach($types as $key => $value)
                                                                <option value="{{$key}}" {{$type == $key ? 'selected':''}}>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th colspan="3">
                                            #
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
                                        <th>Usuário</th>
                                        <th>Título</th>
                                        <th>Corpo</th>
                                        <th>created_at</th>
                                        <th>Executado</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($messages as $value)
                                    <tr>
                                        <td>{{$value->actions->user->name}}</td>
                                        <td>{{$value->title}}</td>
                                        <td>{{$types[$value->type]}}</td>
                                        <td>{{$value->created_at}}</td>
                                        <td>{{$value->actions->executed}}</td>
                                        <td>
                                            @if(!$value->actions->executed && $value->type == "email")
                                            <a href="{{route('message.mail', $value->id)}}" class="btn" rel="tooltip" title="" data-original-title="Executar">
                                                <i class="icon-bolt"></i>
                                            </a>
                                            @else
                                            <a href="javascript:void(0)" class="btn" rel="tooltip" title="" data-original-title="Executar" disabled>
                                                <i class="icon-bolt"></i>
                                            </a>
                                            @endif
                                            <a href="{{route('message.show', $value->id)}}" class="btn" rel="tooltip" title="" data-original-title="Visualizar">
                                                <i class="icon-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $messages->links('layouts.pagination') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
