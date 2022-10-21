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
                        <div class="box-content">
                            {{ Form::open(array('route' => 'clientes.store',  'method' => 'post', 'class' => 'form-vertical')) }}
                            @csrf
                                <div class="row-fluid">
                                    <div class="span3">
                                        <div class="control-group">
                                            {{Form::label('name', 'Nome/Razão Social*', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('name', '', ['id' => 'name','placeholder' => 'Insira o nome', 'class' => 'input-block-level', 'required' => true])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            {{Form::label('responsavel', 'Responsável*', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('responsavel', '', ['id' => 'responsavel','placeholder' => 'Insira o responsável', 'class' => 'input-block-level', 'required' => true])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            {{Form::label('cpf_cnpj', 'CNPJ*', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('cpf_cnpj', '', ['id' => 'cpf_cnpj','placeholder' => '00.000.000/0000-00', 'class' => 'input-block-level', 'required' => true])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            {{Form::label('ie', 'I.E*', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('ie', '', ['id' => 'ie','placeholder' => '000.000.000.000', 'class' => 'input-block-level', 'required' => true])}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span3">
                                        <div class="control-group">
                                            {{Form::label('telefone', 'Telefone*', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('telefone', '', ['id' => 'telefone','placeholder' => '(00) 0000-0000', 'class' => 'input-block-level', 'required' => true])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            {{Form::label('telefone_com', 'Telefone comercial', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('telefone_com', '', ['id' => 'telefone_com','placeholder' => '(00) 0000-0000', 'class' => 'input-block-level'])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            {{Form::label('celular', 'Telefone celular', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('celular', '', ['id' => 'celular','placeholder' => '(00) 00000-0000', 'class' => 'input-block-level'])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            {{Form::label('email', 'E-mail', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('email', '', ['id' => 'email','placeholder' => 'name@provider.domain', 'class' => 'input-block-level'])}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row-fluid">
                                    <div class="span2">
                                        <div class="control-group">
                                            {{Form::label('ecepmail', 'CEP*', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('cep', '', ['id' => 'cep','placeholder' => '00000000', 'class' => 'input-block-level', 'required' => true, 'max' => '9' ])}}
                                                @error('cep')
                                                <div class="alert-danger input-xlarge">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span8">
                                        <div class="control-group">
                                            <label for="endereco" class="control-label">Endereço* <samll><b><a href="javascript:void(0)" onClick="consultaCep()" id="a_cep">Auto completar</a></b></small></label>
                                            <div class="controls controls-row">
                                                {{Form::text('endereco', '', ['id' => 'endereco','placeholder' => 'Insira o endereço', 'class' => 'input-block-level', 'required' => true])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="control-group">
                                            {{Form::label('numero', 'Número*', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('numero', '', ['id' => 'numero','placeholder' => '123', 'class' => 'input-block-level', 'required' => true])}}
                                                @error('numero')
                                                <div class="alert-danger input-xlarge">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span2">
                                        <div class="control-group">
                                            {{Form::label('complemento', 'Complemento', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('complemento', '', ['id' => 'complemento','placeholder' => '...', 'class' => 'input-block-level'])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
                                            {{Form::label('bairro', 'Bairro*', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('bairro', '', ['id' => 'bairro','placeholder' => 'Insira o bairro', 'class' => 'input-block-level', 'required' => true])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
                                            {{Form::label('cidade', 'Cidade*', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::text('cidade', '', ['id' => 'cidade','placeholder' => 'Insira a cidade', 'class' => 'input-block-level', 'required' => true])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="control-group">
                                            {{Form::label('estado', 'Estado*', array('class' => 'control-label'))}}
                                            <div class="controls controls-row">
                                                {{Form::select('estado', $estados, '', ['class' => 'select2-me input-block-level'])}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                    <a href="{{route('clientes.index')}}" class="btn">Cancelar</a>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

    
@include('clients.cep')
    
@endsection
