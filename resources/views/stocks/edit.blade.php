@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid" id="content">

    @include('layouts.navigation')

    <div id="main">
        <div class="container-fluid">

            <div class="row-fluid">
                <div class="span12">
                    <div class="box box-bordered box-color">
                        <div class="box-title">
                            <h3><i class="icon-th-list"></i> {{$title}}</h3>
                        </div>
                        <div class="box-content nopadding">
                            {{ Form::open(array('route' => ['estoques.update', $stock->id],  'method' => 'put', 'class' => 'form-horizontal form-bordered')) }}
                            @csrf
                                <div class="control-group">
                                    <label for="level" class="control-label">Produto</label>
                                    <div class="controls">
                                        <select name="produto_id" id="produto_id" class='select2-me input-block-level' disabled>
                                            @foreach($produtos as $value)
                                            <option value="{{$value->id}}" {{$value->id == $stock->product_id ? 'selected' : NULL}}>{{$value->codigo}} - {{$value->descricao}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    {{Form::label('quantidade', 'Quantidade', array('class' => 'control-label'))}}
                                    <div class="controls">
                                        {{Form::text('quantidade', $stock->quantidade, ['id' => 'quantidade','placeholder' => '0', 'class' => 'input-medium', 'disabled' => true])}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    {{Form::label('cobre', 'Lançamento', array('class' => 'control-label'))}}
                                    <div class="controls">
                                        {{Form::text('dt_lancamento', date('d/m/Y'), ['id' => 'dt_lancamento','placeholder' => "00/00/0000", 'class' => 'input-medium datepick', 'disabled' => true])}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    {{Form::label('nota_fiscal', 'Nota Fiscal', array('class' => 'control-label'))}}
                                    <div class="controls controls-row">
                                        {{Form::text('nota_fiscal', $stock->nota_fiscal, ['id' => 'nota_fiscal','placeholder' => 'Insira uma nota ou descrição', 'class' => 'input-block-level', 'required' => false])}}
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                    <a href="{{route('estoques.index')}}" class="btn">Cancelar</a>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>

(function( $ ) {
    $(function() {
        $('.money').mask('#.##0,00', {reverse: true});
        $('.decimal').mask('##########.##', {reverse: true});
    });
})(jQuery);

$('.datepick').datepicker({
    format: 'dd/mm/yyyy',
    language: 'pt-BR'
});

</script>

@endsection
