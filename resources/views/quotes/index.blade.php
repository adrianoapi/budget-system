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
                                <a href="{{route('cotacoes.check')}}" class="btn btn-primary">
                                <i class="icon-reorder"></i> Novo</a>
                            </span>
                        </div>

                        <div class="box-content nopadding">

                            @if(session('quote_filter'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {!!session('quote_filter')!!}
                                </div>
                            @endif
                            
                            <table class="table table-hover table-nomargin table-colored-header">
                                <thead>
                                    <tr>
                                        <th class="span2">
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
                                        <th  class="span2" class="hidden-1024">
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <input id="numero_nf" placeholder="Nota Fiscal" type="text" name="numero_nf" value="{{$numero_nf}}" class="input-block-level">
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th  class="span2">
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <input id="serial" placeholder="Serial" type="text" name="serial" value="{{$serial}}" class="input-block-level">
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th  class="span2">
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
                                        <th  class="span2">
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <select name="aprovado" id="aprovado" class='input-block-level'>
                                                            <option value="">Aprovado?</option>
                                                            <option value="yes" {{$aprovado == "yes" ? 'selected':''}}>Sim</option>
                                                            <option value="no"  {{$aprovado == "no"  ? 'selected':''}}>Não</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th  class="span2" class="hidden-1024">
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <input id="dt_inicio" placeholder="{{date('01/m/Y')}}" type="text" name="dt_inicio" value="{{$dt_inicio}}" class="input-block-level datepick" require>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th  class="span2" class="hidden-1024">
                                            <div class="span12">
                                                <div class="control-group">
                                                    <div class="controls controls-row">
                                                        <input id="dt_fim" placeholder="{{date('t/m/Y')}}" type="text" name="dt_fim" value="{{$dt_fim}}" class="input-block-level datepick" require>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th  class="span2">
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
                                        <th class="hidden-1024">NF</th>
                                        <th>Serial</th>
                                        <th>Fechada</th>
                                        <th>Aprovado</th>
                                        <th class="hidden-1024">Data</th>
                                        <th>Total</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($quotes as $value)
                                    <tr>
                                        <td>{{$value->Client->name}}</td>
                                        <td class="hidden-1024">{{$value->numero_nf}}</td>
                                        <td>{{$value->serial}}</td>
                                        <td>
                                            @if($value->close)
                                                <span class="btn btn-primary">Sim</span>
                                            @else
                                                <span class="btn btn-default">Não</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($value->aprovado)
                                                <span class="btn btn-primary">Sim</span>
                                            @else
                                                <span class="btn btn-default">Não</span>
                                            @endif
                                        </td>
                                        <td class="hidden-1024">{{substr($value->created_at, 0, 10)}}</td>
                                        <td><strong>{{number_format($value->total_report, 2, ".", ",")}}</strong></td>
                                        <td class=''>
                                            {{ Form::open(['route' => ['cotacoes.destroy', $value->id],  'method' => 'POST', "onSubmit" => "return confirm('Deseja excluir?');", 'style' => 'margin: 0;padding:0;']) }}
                                                @csrf
                                                @method('delete')
                                                
                                                @if($value->close)
                                                <a href="{{route('cotacoes.edit', $value->id)}}" class="btn" rel="tooltip" title="" data-original-title="Visualizar">
                                                    <i class="icon-eye-open"></i>
                                                </a>
                                                <a href="{{route('cotacoes.copy', $value->id)}}" class="btn" rel="tooltip" title="" data-original-title="Copiar" onclick="return confirm('Deseja realmente fazer uma cópia deste orçamento?')">
                                                    <i class="icon-copy"></i>
                                                </a>
                                                @else
                                                <a href="{{route('cotacoes.edit', $value->id)}}" class="btn" rel="tooltip" title="" data-original-title="Editar">
                                                    <i class="icon-edit"></i>
                                                </a>
                                                @endif

                                                @if($value->aprovado)
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


<script>

// Mascaras formulario
(function( $ ) {
$(function() {
    $('.date').mask('00/00/0000');
});
})(jQuery);



$(document).ready(function () {
    $(document).on('focus', '.datepick', function () {
        $(this).datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR'
        });
    });
});

$('.datepick').datepicker({
    format: 'dd/mm/yyyy',
    language: 'pt-BR'
});

</script>
@endsection
