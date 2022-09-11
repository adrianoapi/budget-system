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
                            {{ Form::open(array('route' => 'produtos.store',  'method' => 'post', 'class' => 'form-horizontal form-bordered')) }}
                            @csrf
                                <div class="control-group">
                                    {{Form::label('descricao', 'Descrição*', array('class' => 'control-label'))}}
                                    <div class="controls">
                                        {{Form::text('descricao', '', ['id' => 'descricao','placeholder' => 'Insira o responsável', 'class' => 'input-block-level', 'required' => true])}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    {{Form::label('codigo', 'Código*', array('class' => 'control-label'))}}
                                    <div class="controls">
                                        {{Form::text('codigo', '', ['id' => 'codigo','placeholder' => '00000', 'class' => 'input-medium', 'required' => true])}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    {{Form::label('espessura', 'Espessura', array('class' => 'control-label'))}}
                                    <div class="controls">
                                        {{Form::text('espessura', '', ['id' => 'espessura','placeholder' => '0', 'class' => 'input-medium', 'required' => true])}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    {{Form::label('cobre', 'Cobre', array('class' => 'control-label'))}}
                                    <div class="controls">
                                        {{Form::text('cobre', '', ['id' => 'cobre','placeholder' => '0', 'class' => 'input-medium', 'required' => true])}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    {{Form::label('aco', 'Aço', array('class' => 'control-label'))}}
                                    <div class="controls">
                                        {{Form::text('aco', '', ['id' => 'aco','placeholder' => '0', 'class' => 'input-medium', 'required' => true])}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    {{Form::label('valor', 'Valor', array('class' => 'control-label'))}}
                                    <div class="controls">
                                        {{Form::text('valor', '', ['id' => 'valor','placeholder' => '0.00', 'class' => 'money input-medium', 'required' => true])}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    {{Form::label('linha', 'Linha', array('class' => 'control-label'))}}
                                    <div class="controls">
                                        {{Form::text('linha', '', ['id' => 'linha','placeholder' => '...', 'class' => 'input-medium', 'required' => true])}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    {{Form::label('caixa', 'Caixa', array('class' => 'control-label'))}}
                                    <div class="controls">
                                        {{Form::text('caixa', '', ['id' => 'caixa','placeholder' => '...', 'class' => 'input-medium', 'required' => true])}}
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                    <a href="{{route('usuarios.index')}}" class="btn">Cancelar</a>
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

</script>

@endsection
