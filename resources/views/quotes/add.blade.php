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
                        <h3>
                            <i class="icon-money"></i>
                            Cotação
                        </h3>
                    </div>
                    <div class="box-content">
                        <div class="invoice-info">
                            <div class="invoice-from">
                                <span>De</span>
                                <strong>Company Name</strong>
                                <address>
                                    Street Address <br>
                                    City, ST ZIP Code <br>
                                    <abbr title="Phone">Phone:</abbr> (125) 358123-581 <br>
                                    <abbr title="Fax">Fax:</abbr> (125) 251656-222 
                                </address>
                            </div>
                            <div class="invoice-to">
                                <span>Para</span>
                                <strong>{{$client->name}}</strong>
                                <address>
                                    {{$client->endereco}}, {{$client->numero}} <br>
                                    {{$client->bairro}}, {{$client->cidade}}/{{$client->estado}}, {{$client->cep}} <br>
                                    <abbr title="Telefone">Phone:</abbr>
                                    @if(!empty($client->telefone))
                                    {{$client->telefone}} |
                                    @endif
                                    @if(!empty($client->telefone_com))
                                        {{$client->telefone_com}} |
                                    @endif
                                    @if(!empty($client->celular))
                                        {{$client->celular}}
                                    @endif<br>
                                    <abbr title="E-mail">E-mail:</abbr> {{$client->celular}}
                                </address>
                            </div>
                            <div class="invoice-infos">
                                <table>
                                    <tbody><tr>
                                        <th>Date:</th>
                                        <td>Aug 06, 2012</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice #:</th>
                                        <td>0001752188s</td>
                                    </tr>
                                    <tr>
                                        <th>Product:</th>
                                        <td>Service Hotline</td>
                                    </tr>
                                </tbody></table>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span12">
                                <div class="basic-margin" style="float:right;">
                                    <a href="#new-task" data-toggle="modal" class="btn btn-blue"><i class="icon-plus-sign"></i> Adicionar Produto</a>
                                </div>
                            </div>
                        </div>
                        
                        <table class="table table-striped table-invoice">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="tr">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="name">Lorem ipsum in eu quis</td>
                                    <td class="price">$30.00</td>
                                    <td class="qty">3</td>
                                    <td class="total">$90.00</td>
                                </tr>
                                <tr>
                                    <td class="name">Lorem ipsum in eu quis</td>
                                    <td class="price">$30.00</td>
                                    <td class="qty">3</td>
                                    <td class="total">$90.00</td>
                                </tr>
                                <tr>
                                    <td class="name">Lorem ipsum in eu quis</td>
                                    <td class="price">$30.00</td>
                                    <td class="qty">3</td>
                                    <td class="total">$90.00</td>
                                </tr>
                                <tr>
                                    <td class="name">Lorem ipsum in eu quis</td>
                                    <td class="price">$30.00</td>
                                    <td class="qty">3</td>
                                    <td class="total">$90.00</td>
                                </tr>
                                <tr>
                                    <td class="name">Lorem ipsum in eu quis</td>
                                    <td class="price">$30.00</td>
                                    <td class="qty">3</td>
                                    <td class="total">$90.00</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="taxes">
                                        <p>
                                            <span class="light">Subtotal</span>
                                            <span>$450.00</span>
                                        </p>
                                        <p>
                                            <span class="light">Tax(10%)</span>
                                            <span>$45.00</span>
                                        </p>
                                        <p>
                                            <span class="light">Total</span>
                                            <span class="totalprice">
                                                $495.00
                                            </span>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="invoice-payment">
                            <span>Payment methods</span>
                            <ul>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--Modal-->
        <div id="new-task" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Adicionando Produto</h3>
            </div>
            <form action="#" class='new-task-form form-horizontal form-bordered'>
                <div class="">
                    <div class="control-group">
                        <label for="tasktitel" class="control-label">Icon</label>
                        <div class="controls">
                            <div class="input-xlarge">
                                <select name="select" id="select-product" onselect="showDynamic(this.id)" class='chosen-select'>
                                    <option value="">Selecione...</option>
                                    @foreach($products as $value)
                                    <option value="{{$value->id}}">{{$value->codigo}} - {{$value->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="task-name" class="control-label">Task</label>
                        <div class="controls">
                            <input type="text" name="task-name">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="tasktitel" class="control-label"></label>
                        <div class="controls">
                            <label class="checkbox"><input type="checkbox" name="task-bookmarked" value="yep"> Mark as important</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Adicionar">
                </div>
            </form>
    
        </div>
                    

        </div>
    </div>

</div>

<script type="text/javascript">

$('#select-product').on('change', function () {
  //console.log('Changed option value ' + this.value);
  //console.log('Changed option text ' + $(this).find('option').filter(':selected').text());

  $.ajax({
    url: "{{route('produtos.show')}}",
    type: "GET",
    data: {
        "_token": "{{csrf_token()}}",
        "id": this.value
    },
    dataType: 'json',
        success: function(data){
            console.log(data);
        }
    });
});

    
    </script>

    
@endsection
