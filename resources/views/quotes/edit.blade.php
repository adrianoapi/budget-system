@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@if($quote->close)
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({iconsPath : '{!! asset('nicEdit/nicEditorIcons.gif') !!}'}).panelInstance('observacao');
});
</script>
@endif

<div class="container-fluid" id="content">

    @include('layouts.navigation')

    <div id="main">
        <div class="container-fluid">

        <div class="row-fluid">

            <div class="span12">
                <div class="box box-bordered box-color">
                    <div class="box-title">
                        <h3>
                            <i class="icon-reorder"></i>
                            Cotação
                            @if($quote->close)
                            FECHADA
                            @endif
                        </h3>
                    </div>
                    <div class="box-content nopadding">
                        <div class="tabs-container">
                            <ul class="tabs tabs-inline tabs-top">
                                <li class='active'>
                                    <a href="#first11" data-toggle='tab'><i class="icon-list-alt"></i> Resumo</a>
                                </li>
                                <li>
                                    <a href="#second22" data-toggle='tab'><i class="icon-edit"></i> Editar</a>
                                </li>
                                <li>
                                    <a href="#third" data-toggle='tab'><i class="glyphicon-flag"></i> Fator</a>
                                </li>
                                <li>
                                    <a href="#forth" data-toggle='tab'><i class="icon-fire"></i> ICMS</a>
                                </li>
                                <li>
                                    <a href="#five" data-toggle='tab'><i class="icon-fire"></i> IPI</a>
                                </li>
                                @if($quote->aprovado)
                                <li>
                                    <a href="#six" data-toggle='tab'><i class="glyphicon-barcode"></i> Nota Fiscal</a>
                                </li>
                                @endif
                                <li>
                                    <a href="#seven" data-toggle='tab'><i class="icon-download-alt"></i> Arquivos</a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="tab-content padding tab-content-inline tab-content-bottom">
                            
                            <div class="tab-pane active" id="first11">
                                <div class="invoice-info">
        
                                    @if(session('quote_close'))
                                        <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            {!!session('quote_close')!!}
                                        </div>
                                    @endif
        
                                    <div class="invoice-from">
                                        <span>De</span>
                                        <strong>{{$quote->company->name}}</strong>
                                        <address>
                                            {{$quote->company->endereco}}, {{$quote->company->numero}}, {{$quote->company->complemento}}<br>
                                            {{$quote->company->bairro}}, {{$quote->company->cidade}} - {{$quote->company->estado}},  {{$quote->company->cep}} <br>
                                            <abbr title="Telefone">Telefone:</abbr> {{$quote->company->telefone}} -
                                            <abbr title="Comercial">Comercial:</abbr> {{$quote->company->telefone_com}} <br>
                                            <abbr title="Celular">Celular:</abbr> {{$quote->company->celular}}
                                        </address>
                                    </div>
                                    <div class="invoice-to">
                                        <span>Para</span>
                                        <strong>{{$quote->client->name}}</strong>
                                        <address>
                                            {{$quote->client->endereco}}, {{$quote->client->numero}} <br>
                                            {{$quote->client->bairro}}, {{$quote->client->cidade}}/{{$quote->client->estado}}, {{$quote->client->cep}} <br>
                                            <abbr title="Telefone">Phone:</abbr>
                                            @if(!empty($quote->client->telefone))
                                            {{$quote->client->telefone}} |
                                            @endif
                                            @if(!empty($quote->client->telefone_com))
                                                {{$quote->client->telefone_com}} |
                                            @endif
                                            @if(!empty($quote->client->celular))
                                                {{$quote->client->celular}}
                                            @endif<br>
                                            <abbr title="E-mail">E-mail:</abbr> {{$quote->client->celular}}
                                        </address>
                                    </div>
                                    <div class="invoice-infos">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th>Serial #:</th>
                                                    <td>
                                                        {{$quote->serial}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="basic-margin">
                                            Nome do Projeto: <strong>{{$quote->name}}</strong>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="basic-margin" style="float:right;">
                                            @if(!$quote->close)
                                            <a href="#new-task" data-toggle="modal" class="btn btn-primary"><i class="icon-plus-sign"></i> Adicionar Produto</a>
                                            @else
                                            <a href="javascript:void(0)" class="btn btn-default" disabled="disabled"><i class="icon-plus-sign"></i> Adicionar Produto</a>
                                            <a href="{{route('cotacoes.export', $quote->id)}}" class="btn btn-lightred" style=""><i class="icon-file-alt"></i> Exportar PDF</a>
                                                @if(!$quote->aprovado)
                                                    <a href="{{route('cotacoes.approve', $quote->id)}}" class="btn btn-satgreen" style=""  onclick="return confirm('Deseja aprovar este orçamento?')"><i class="glyphicon-unchecked"></i> Aprovar</a>
                                                @else
                                                    <a href="{{ Auth::user()->level > 1 ? route('cotacoes.approve', $quote->id) : 'javascript:void(0)'}}" class="btn btn-satgreen" {{ Auth::user()->level > 1 ? '': 'disabled'}}><i class="glyphicon-check"></i> Aprovado</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="dinamic-table">Carregando...</div>
                                @if(!$quote->close)
                                <div class="invoice-payment">
                                    {{ Form::open(['route' => ['cotacoes.close', $quote->id],  'method' => 'POST']) }}
                                    {!! Form::button('<i class="icon-folder-close-alt"></i> Fechar Cotação', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                    {{ Form::close() }}
                                </div>
                                @else 
                                <div class="invoice-payment">
                                    {{ Form::open(['route' => ['cotacoes.back.edit', $quote->id],  'method' => 'POST']) }}
                                    {!! Form::button('<i class="icon-copy"></i> '.$quote->aprovado > 0 ? 'Clonar Cotação' : 'Editar Cotação', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                                    {{ Form::close() }}
                                </div>
                                @endif

                                @if($quote->close)
                                <!--Form comercail begin-->
                                <div class="row-fluid">
                                    <div class="box box-bordered">
                                        <div class="box-title">
                                            <h3><i class="icon-th-list"></i> Condições comerciais</h3>
                                        </div>
                                        <div class="box-content nopadding">
                                            {{ Form::open(['route' => ['cotacoes.update.comercial', $quote->id],  'method' => 'POST', 'class' =>'form-horizontal form-bordered']) }}
                                                @method('PUT')
                                                <!--Se administrador-->
                                                @if(Auth::user()->level > 1)
                                                <div class="control-group">
                                                    <label for="user_id" class="control-label">Representante Responsável</label>
                                                    <div class="controls">
                                                        <select name="user_id" id="user_id" class='input-block-level'>
                                                            <option value="">Representante</option>
                                                            @foreach($users as $value)
                                                                <option value="{{$value->id}}" {{$quote->user_id == $value->id ? "selected" : NULL}}>{{$value->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="user_client_id" class="control-label">Representante Cliente</label>
                                                    <div class="controls">
                                                        <select name="user_client_id" id="user_client_id" class='input-block-level'>
                                                            <option value="">Cliente</option>
                                                            @foreach($clients as $value)
                                                                @if($value->user_id == $quote->user_id)
                                                                    <option value="{{$value->id}}" {{$quote->client_id == $value->id ? "selected" : NULL}}>{{$value->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="control-group">
                                                    <label for="representante" class="control-label">Representante</label>
                                                    <div class="controls">
                                                        <input type="text" name="representante" id="representante" value="{{!empty($quote->representante) ? $quote->representante : 'usuario' }}" placeholder="representante..." class="input-xlarge">
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="pagamento" class="control-label">Pagamento</label>
                                                    <div class="controls">
                                                        <input type="text" name="pagamento" id="pagamento" value="{{$quote->pagamento}}" placeholder="pagamento..." class="input-xlarge">
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="prazo" class="control-label">Prazo</label>
                                                    <div class="controls">
                                                        <input type="text" name="prazo" id="prazo" value="{{$quote->prazo}}" placeholder="prazo..." class="input-xlarge">
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="transportadora" class="control-label">Transportadora</label>
                                                    <div class="controls">
                                                        <input type="text" name="transportadora" id="transportadora" value="{{$quote->transportadora}}" placeholder="transportadora..." class="input-xlarge">
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="observacao" class="control-label">Observação:</label>
                                                    <div class="controls">
                                                        <textarea name="observacao" id="observacao" class="input-block-level" rows="5">{{$quote->observacao}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                                </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                                <!--Form comercail end-->
                                @endif
                            
                            </div><!--tab 1-->

                            <div class="tab-pane" id="second22">
                                {{ Form::open(['route' => ['cotacoes.update', $quote->id], 'class' => 'form-vertical']) }}    
                                    @csrf 
                                    @method('PUT')
    
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group">
                                                <label for="name" class="control-label">Nome do Projeto</label>
                                                <div class="controls">
                                                    <input type="text" name="name" id="name" value="{{$quote->name}}" placeholder="Insira um nome" class="input-block-level">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label for="multa" class="control-label">Empesa</label>
                                                <div class="controls controls-row">
                                                    <select name="company_id" id="company_id" class='input-block-level'>
                                                        <option value="">Empesa</option>
                                                        @foreach($companies as $value)
                                                            <option value="{{$value->id}}" {{$quote->company_id == $value->id ? "selected" : NULL}}>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label for="multa" class="control-label">Cliente</label>
                                                <div class="controls controls-row">
                                                    <select name="client_id" id="client_id" class='input-block-level'>
                                                        <option value="">Cliente</option>
                                                        @foreach($clients as $value)
                                                            <option value="{{$value->id}}" {{$quote->client_id == $value->id ? "selected" : NULL}}>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                {{Form::label('total', 'Total (0,00)', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <span class="add-on">R$</span>
                                                        {{Form::text('total', $quote->total, [
                                                            'id' => 'total',
                                                            'placeholder' => '0.00', 
                                                            'class' => 'money input-medium', 
                                                            'required' => true,
                                                            'disabled' => $quote->close > 0 ? true : false
                                                            ]
                                                            )}}
                                                        @error('total')
                                                        <div class="alert-danger input-xlarge">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <label for="multa" class="control-label">Aprovado</label>
                                                <div class="controls controls-row">
                                                    <select name="aprovado" id="aprovado" class='input-block-level'>
                                                        <option value="1" {{$quote->aprovado == true ? "selected" : NULL}}>Sim</option>
                                                        <option value="0" {{$quote->aprovado != true ? "selected" : NULL}}>Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                {{Form::label('percentual', 'Desconto Percentual (0,00)', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <span class="add-on">%</span>
                                                        {{Form::text('percentual', $quote->percentual, [
                                                            'id' => 'percentual',
                                                            'placeholder' => '0.00', 
                                                            'class' => 'money input-medium', 
                                                            'required' => true,
                                                            'disabled' => $quote->close > 0 ? true : false
                                                            ]
                                                            )}}
                                                        @error('percentual')
                                                        <div class="alert-danger input-xlarge">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                {{Form::label('frete', 'Frete (0,00)', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <span class="add-on">R$</span>
                                                        {{Form::text('frete', $quote->frete, [
                                                            'id' => 'frete',
                                                            'placeholder' => '0.00', 
                                                            'class' => 'money input-medium', 
                                                            'required' => true,
                                                            'disabled' => $quote->close > 0 ? true : false
                                                            ]
                                                            )}}
                                                        @error('frete')
                                                        <div class="alert-danger input-xlarge">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            {{Form::button('Salvar', [
                                                    'type' => 'submit',
                                                    'class'=> 'btn btn-primary',
                                                    'disabled' => $quote->close > 0 ? true : false
                                            ])}}
                                        </div>
                                    </div>
                                </form>
                            </div><!--Tab 2-->
                            <div class="tab-pane" id="third">
                                {{ Form::open(['route' => ['cotacoes.update.fator', $quote->id], 'class' => 'form']) }}    
                                    @csrf 
                                    @method('PUT')
    
                                    <div class="row-fluid">
                                        <div class="span2">
                                            <div class="control-group">
                                                {{Form::label('fator', 'Fator', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    {{Form::text('fator', $quote->fator,
                                                    [
                                                        'id' => 'fator',
                                                        'class' => 'fator input-small',
                                                        'style' => 'margin-bottom:0',
                                                        'disabled' => $quote->close > 0 ? true : false
                                                    ])}}
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
    
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            {{Form::button('Salvar', [
                                                    'type' => 'submit',
                                                    'class'=> 'btn btn-primary',
                                                    'disabled' => $quote->close > 0 ? true : false
                                            ])}}
                                        </div>
                                    </div>
                                </form>
                            </div><!--Tab 3-->
                            <div class="tab-pane" id="forth">
                                {{ Form::open(['route' => ['cotacoes.update.icms', $quote->id], 'class' => 'form']) }}    
                                    @csrf 
                                    @method('PUT')
    
                                    <div class="row-fluid">
                                        <div class="span2">
                                            <div class="control-group">
                                                {{Form::label('icms', 'ICMS', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    <select name="icms" id="icms" class='input-small'>
                                                        @foreach($icmsLista as $keyIcms => $icmsValue)
                                                            <option value="{{$keyIcms}}" {{$keyIcms == $quote->icms ? "selected" : NULL}}>{{$icmsValue}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
    
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            {{Form::button('Salvar', [
                                                    'type' => 'submit',
                                                    'class'=> 'btn btn-primary',
                                                    'disabled' => $quote->close > 0 ? true : false
                                            ])}}
                                        </div>
                                    </div>
                                </form>
                            </div><!--Tab 4-->
                            <div class="tab-pane" id="five">
                                {{ Form::open(['route' => ['cotacoes.update.ipi', $quote->id], 'class' => 'form']) }}    
                                    @csrf 
                                    @method('PUT')
    
                                    <div class="row-fluid">
                                        <div class="span2">
                                            <div class="control-group">
                                                {{Form::label('ipi', 'IPI', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    <select name="ipi" id="ipi" class='input-small'>
                                                        @foreach($ipiLista as $keyIpi => $valueIpi)
                                                            <option value="{{$keyIpi}}" {{$keyIpi == $quote->ipi ? "selected" : NULL}}>{{$valueIpi}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
    
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            {{Form::button('Salvar', [
                                                    'type' => 'submit',
                                                    'class'=> 'btn btn-primary',
                                                    'disabled' => $quote->close > 0 ? true : false
                                            ])}}
                                        </div>
                                    </div>
                                </form>
                            </div><!--Tab 5-->
                            @if($quote->aprovado)
                            <div class="tab-pane" id="six">

                                @if(empty($quote->numero_nf))
                                <div class="row-fluid margin-top">
                                    <div class="span12">
                                        <div class="alert alert-waning">
                                            Atenção: Será abatida do estoque as respectivas quantidades de produtos constantes no orçamento ao registrar o número da Nota Fiscal!
                                        </div>
                                    </div>
                                </div>
                                @endif

                                {{ Form::open(['route' => ['cotacoes.update.nf', $quote->id], 'class' => 'form']) }}    
                                    @csrf 
                                    @method('PUT')
    
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                {{Form::label('numero_nf', 'Número da Nota Fiscal', array('class' => 'control-label'))}}
                                                <div class="controls">
                                                    {{Form::text('numero_nf', $quote->numero_nf,
                                                    [
                                                        'id' => 'numero_nf',
                                                        'class' => 'input-large',
                                                        'style' => 'margin-bottom:0',
                                                        'required' => true
                                                    ])}}
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
    
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            {{Form::button('Salvar', [
                                                    'type' => 'submit',
                                                    'class'=> 'btn btn-primary',
                                            ])}}
                                        </div>
                                    </div>
                                </form>
                            </div><!--Tab 6-->
                            @endif
                            <div class="tab-pane" id="seven">
                                @if(Auth::user()->level > 1)
                                    <form action="{{route('arquivos.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif
                                        @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        @if ($message = Session::get('success_file'))
                                        <div class="alert alert-success">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif
                                        
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input" id="chooseFile">
                                            <label class="custom-file-label" for="chooseFile">Selecione um arquivo!</label>
                                            <input type="hidden" name="quote_id" value="{{$quote->id}}">
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                                            Subir arquivo!
                                        </button>
                                    </form>
                                  @endif
                                  <table class="table">
                                    <thead>
                                        <th>Arquivo</th>
                                        <th>Ttamanho</th>
                                        <th>Tipo</th>
                                        <th>Ação</th>
                                    </thead>
                                    @foreach($quote->files as $value)
                                    <tr>
                                        <td>{{$value->name}}</td>
                                        <td>{{$value->size}}</td>
                                        <td>{{$value->type}}</td>
                                        <td>
                                            {{ Form::open(['route' => ['arquivos.destroy', $value->id],  'method' => 'POST', "onSubmit" => "return confirm('Deseja excluir?');", 'style' => 'margin: 0;padding:0;']) }}
                                                @csrf
                                                @method('delete')
                                             
                                                <a href="{{route('arquivos.show', $value->id)}}" class="btn" rel="tooltip" title="" data-original-title="Download">
                                                    <i class="icon-download"></i>
                                                </a>

                                                @if(Auth::user()->level > 1)
                                                <button type="submit" class="btn" rel="tooltip" title="" data-original-title="Excluir">
                                                    <i class="icon-trash"></i>
                                                </button>
                                                @endif

                                            {{ Form::close() }}

                                        </td>
                                    </tr>
                                    @endforeach
                                  </table>

                            </div><!--Arquivos/Files-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal Adicionar-->
        <div id="new-task" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Adicionando Produto</h3>
            </div>
            <form action="#" onsubmit="return false;" name="addItem" id="addItem" class='new-task-form form-horizontal form-bordered'>
                <div class="">
                    <div class="control-group">
                        {{Form::label('codigo', 'Código*', array('class' => 'control-label'))}}
                        <div class="controls">
                            <div class="input-xlarge">
                                <select name="produto" id="select-product" class='chosen-select' required="true">
                                    <option value="">Selecione...</option>
                                    @foreach($products as $value)
                                    <option value="{{$value->id}}">{{$value->codigo}} - {{$value->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('quantidade', 'Quantidade', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('quantidade', '', ['id' => 'quantidade','placeholder' => '0', 'class' => 'input-medium', 'required' => true])}}
                            Quantidade em estoque:<span id="quantidade_estoque"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('espessura', 'Espessura', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('espessura', '', ['id' => 'espessura','placeholder' => '0', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('cobre', 'Cobre', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('cobre', '', ['id' => 'cobre','placeholder' => '0', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('aco', 'Aço', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('aco', '', ['id' => 'aco','placeholder' => '0', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('valor', 'Valor', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('valor', '', ['id' => 'valor','placeholder' => '0.00', 'class' => 'money input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('linha', 'Linha', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('linha', '', ['id' => 'linha','placeholder' => '...', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('caixa', 'Caixa', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('caixa', '', ['id' => 'caixa','placeholder' => '...', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('unidade', 'Unidade', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('unidade', '', ['id' => 'unidade','placeholder' => '...', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Adicionar">
                </div>
            </form>
    
        </div>

        <!--Modal Editar-->
        <div id="produto-edit" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Editando Produto</h3>
            </div>
            <form action="#" onsubmit="return false;" name="upItem" id="upItem" class='new-task-form form-horizontal form-bordered'>
                <div class="">
                    <div class="control-group">
                        {{Form::label('codigo', 'Código*', array('class' => 'control-label'))}}
                        <div class="controls">
                            <div class="input-xlarge">
                                <select name="edit-produto" id="edit-select-product" class='chosen-select' required="true">
                                    <option value="">Selecione...</option>
                                    @foreach($products as $value)
                                    <option value="{{$value->id}}">{{$value->codigo}} - {{$value->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('edit-quantidade', 'Quantidade', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('edit-quantidade', '', ['id' => 'edit-quantidade','placeholder' => '0', 'class' => 'input-medium', 'required' => true])}}
                            Quantidade em estoque:<span id="edit-quantidade_estoque"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('edit-espessura', 'Espessura', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('edit-espessura', '', ['id' => 'edit-espessura','placeholder' => '0', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('edit-cobre', 'Cobre', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('edit-cobre', '', ['id' => 'edit-cobre','placeholder' => '0', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('edit-aco', 'Aço', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('edit-aco', '', ['id' => 'edit-aco','placeholder' => '0', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('edit-valor', 'Valor', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('edit-valor', '', ['id' => 'edit-valor','placeholder' => '0.00', 'class' => 'money input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('edit-linha', 'Linha', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('edit-linha', '', ['id' => 'edit-linha','placeholder' => '...', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('edit-caixa', 'Caixa', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('edit-caixa', '', ['id' => 'edit-caixa','placeholder' => '...', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                    <div class="control-group">
                        {{Form::label('edit-unidade', 'Unidade', array('class' => 'control-label'))}}
                        <div class="controls">
                            {{Form::text('edit-unidade', '', ['id' => 'edit-unidade','placeholder' => '...', 'class' => 'input-medium', 'disabled' => true])}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::hidden('edit-item-id', '', ['id' => 'edit-item-id'])}}
                    <input type="submit" class="btn btn-primary" value="Salvar Alteração">
                </div>
            </form>
    
        </div>
                    

        </div>
    </div>

</div>

<script type="text/javascript">

function notification(color, content)
{
    new jBox('Notice', {
        animation: 'flip',
        color: color,
        content: content,
        delayOnHover: true,
        showCountdown: true
    });
}

(function( $ ) {
    $(function() {
        $('.money').mask('#.##0,00', {reverse: true});
        $('.fator').mask('#,##', {reverse: true});
    });
})(jQuery);

//Atributos dos inputs que serão trabalhados
const attributes = ['espessura', 'cobre', 'aco', 'valor', 'linha', 'caixa', 'unidade', 'quantidade_estoque'];

function editModal(produto, item, quantidade)
{
    //Limpa o formulário
    clear("edit");

    //Abre o modal
    $('#produto-edit').modal('show');

    //Busca dados do produto
    $("#edit-select-product").val(produto).change();

    //Atualiza a api de select
    $('#edit-select-product').trigger("liszt:updated");
    //Atualiza a api de select

    $('#edit-quantidade').val(quantidade);

    //Adiciona o id que será editado
    $('#edit-item-id').val(item);
}

$('#user_id').on('change', function () {
    getAttributesClients(this);
});

$('#select-product').on('change', function () {
    getAttributesProdutos(this, '');
});

$('#edit-select-product').on('change', function () {
    getAttributesProdutos(this, 'edit');
});


function getAttributesClients(_this)
{
    //console.log('Changed option value ' + _this.value);
    $('#user_client_id').empty();

    $.ajax({
    url: "{{route('usuarios.clients.list')}}",
    type: "GET",
    data: {
        "_token": "{{csrf_token()}}",
        "id": _this.value
    },
    dataType: 'json',
        success: function(data)
        {
            var $select = $('#user_client_id');

            for(var i = 0; i < data.length; i++)
            {
                $select.append($('<option />', { value: data[i].id, text: data[i].name }));
            }
        }
    });
}

function getAttributesProdutos(_this, _action)
{
    //console.log('Changed option value ' + this.value);
    //console.log('Changed option text ' + $(this).find('option').filter(':selected').text());
    clear(_action);

    $.ajax({
    url: "{{route('produtos.show')}}",
    type: "GET",
    data: {
        "_token": "{{csrf_token()}}",
        "id": _this.value
    },
    dataType: 'json',
        success: function(data)
        {
            for(var i = 0; i < attributes.length; i++)
            {
                if(_action == 'edit')
                {
                    // Precisa saber sé é uma div ou um input
                    if(attributes[i] == 'quantidade_estoque'){
                        $("#edit-"+attributes[i]).html(data[attributes[i]]);
                    }else{
                        $("#edit-"+attributes[i]).val(data[attributes[i]]);
                    }
                }else{
                    // Precisa saber sé é uma div ou um input
                    if(attributes[i] == 'quantidade_estoque'){
                        $("#"+attributes[i]).html(data[attributes[i]]);
                    }else{
                        $("#"+attributes[i]).val(data[attributes[i]]);
                    }
                }
            }
        }
    });
}

function clear(_action)
{
    for(var i = 0; i < attributes.length; i++)
    {
        if(_action == 'edit')
        {
            $("#edit-"+attributes[i]).val("");
        }else{
            $("#"+attributes[i]).val("");
        }
    }
}

$("#addItem").submit(function() {
    const obj = {
        produto: $("#select-product").val(),
        quantidade: $("#quantidade").val(),
        cotacao: {{$quote->id}}
    };

    $.ajax({
        url: "{{route('itens.store')}}",
        type: "POST",
        cache: false,
        datatype: "JSON",
        data: {
            "_token": "{{csrf_token()}}",
            "data": JSON.stringify(obj)
        },
        dataType: 'json',
        success: function(data)
        {
            getTable("green", "Produto adicionado!");
        }
    });
});

$("#upItem").submit(function()
{
    const obj = {
        produto: $("#edit-select-product").val(),
        quantidade: $("#edit-quantidade").val(),
        cotacao: {{$quote->id}},
        quoteItem: $("#edit-item-id").val()
    };

    $.ajax({
        url: "{{route('itens.change')}}",
        type: "POST",
        cache: false,
        datatype: "JSON",
        data: {
            "_token": "{{csrf_token()}}",
            "data": JSON.stringify(obj)
        },
        dataType: 'json',
        success: function(data)
        {
            getTable("green", "Produto alterado!");
            //Fecha o modal
            $('#produto-edit').modal('toggle');
        }
    });
});

$("#tb-cotacao").on("click", "#delete", function() {
   $(this).closest("tr").remove();
});

function excluir(id) {

    $.ajax({
        url: "{{route('itens.destroy')}}",
        type: "POST",
        cache: false,
        datatype: "JSON",
        data: {
            "_token": "{{csrf_token()}}",
            "id": id
        },
        dataType: 'json',
        success: function(data)
        {
            getTable("green", "Produto excluído!");
        }
    });
}

function update(id) {

    @if(Auth::user()->level <= 1)
    var fator = $("#table_fator_"+id).val();
    fator = fator.replace(",",".");
    if(fator < 0.6){
        notification("red", 'Apenas o Administrador poderá aplicar FATOR menor que 0,60!');
        return false;
    }
    @endif

    $.ajax({
        url: "{{route('itens.update')}}",
        type: "POST",
        cache: false,
        datatype: "JSON",
        data: {
            "_token": "{{csrf_token()}}",
            "quantidade": $("#table_quantidade_"+id).val(),
            "fator": $("#table_fator_"+id).val(),
            "icms": $("#table_icms_"+id).val(),
            "ipi": $("#table_ipi_"+id).val(),
            "id": id
        },
        dataType: 'json',
        success: function(data)
        {
            getTable("green", "Produto atualizado!");
        }
    });
}

function order(id, ordem) {

    $.ajax({
        url: "{{route('itens.order')}}",
        type: "POST",
        cache: false,
        datatype: "JSON",
        data: {
            "_token": "{{csrf_token()}}",
            "ordem": ordem,
            "id": id
        },
        dataType: 'json',
        success: function(data)
        {
            getTable("","");
        }
    });
}

function getTable(color, message)
{
    $.ajax({
    url: "{{route('cotacoes.items', $quote->id)}}",
    type: "GET",
    data: {
        "_token": "{{csrf_token()}}",
    },
    dataType: 'json',
        success: function(data)
        {
            $("#dinamic-table").html(data['table']);
            if(message != '')
            {
                notification(color, message);
            }
        }
    });
}

getTable("", "");
</script>

    
@endsection
