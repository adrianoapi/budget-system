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
                            <form action="{{route('clientes.store')}}" method="POST" class='form-vertical'>
                            @csrf
                            <div class="row-fluid">
                                <div class="span3">
                                    <div class="control-group">
                                        <label for="name" class="control-label">Nome/Razão Social*</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="name" id="name" placeholder="Insira o nome" class="input-block-level" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <label for="responsavel" class="control-label">Responsável*</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="responsavel" id="responsavel" placeholder="Insira o responsável" class="input-block-level" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <label for="cpf_cnpj" class="control-label">CNPJ*</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="cpf_cnpj" id="cpf_cnpj" placeholder="00.000.000/0000-00" class="input-block-level" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <label for="ie" class="control-label">I.E*</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="ie" id="ie" placeholder="000.000.000.000" class="input-block-level" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span3">
                                    <div class="control-group">
                                        <label for="telefone" class="control-label">Telefone*</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="telefone" id="telefone" placeholder="(00) 0000-0000" class="input-block-level" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <label for="telefone_com" class="control-label">Telefone comercial</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="telefone_com" id="telefone_com" placeholder="(00) 0000-0000" class="input-block-level">
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <label for="celular" class="control-label">Telefone celular</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="celular" id="celular" placeholder="(00) 00000-0000" class="input-block-level">
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <label for="email" class="control-label">E-mail</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="email" id="email" placeholder="name@provider.domain" class="input-block-level">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row-fluid">
                                <div class="span2">
                                    <div class="control-group">
                                        <label for="cep" class="control-label">CEP*</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="cep" id="cep" placeholder="00000000" max="9" class="input-block-level" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="span8">
                                    <div class="control-group">
                                        <label for="endereco" class="control-label">Endereço* <samll><b><a href="javascript:void(0)" onClick="consultaCep()" id="a_cep">Auto completar</a></b></small></label>
                                        <div class="controls controls-row">
                                            <input type="text" name="endereco" id="endereco" placeholder="Insira o endereço" class="input-block-level" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                        <label for="numero" class="control-label">Número*</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="numero" id="numero" placeholder="123" class="input-block-level" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span2">
                                    <div class="control-group">
                                        <label for="complemento" class="control-label">Complemento</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="complemento" id="complemento" placeholder="..." class="input-block-level">
                                        </div>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="control-group">
                                        <label for="bairro" class="control-label">Bairro*</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="bairro" id="bairro" placeholder="Insira o bairro" class="input-block-level" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="control-group">
                                        <label for="cidade" class="control-label">Cidade*</label>
                                        <div class="controls controls-row">
                                            <input type="text" name="cidade" id="cidade" placeholder="Insira a cidade" class="input-block-level" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                        <label for="estado" class="control-label">Estado*</label>
                                        <div class="controls controls-row">
                                            <select name="estado" id="estado" class='select2-me input-block-level'>
                                                @foreach($estados as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                    <a href="{{route('clientes.index')}}" class="btn">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

    
@include('clients.cep')
    
@endsection
