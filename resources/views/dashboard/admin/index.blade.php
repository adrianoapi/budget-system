@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid" id="content">

    @include('layouts.navigation')

    <div id="main">
        <div class="container-fluid">

            <div class="span12">

                
                <div class="page-header">
                    <div class="pull-left">
                        <h1>{{$title}}</h1>
                    </div>
                </div>


                <div class="box box-color box-bordered">
                    <div class="box-title">
                        <h3>
                            <i class="icon-th-large"></i>
                            Resumo total
                        </h3>
                    </div>
                    <div class="box-content">

                        <ul class="stats">
                            <li class="teal">
                                <i class="icon-user"></i>
                                <div class="details">
                                    <span class="big">{{$total['users']}}</span>
                                    <span>Usuários</span>
                                </div>
                            </li>
                            <li class="blue">
                                <i class="icon-tags"></i>
                                <div class="details">
                                    <span class="big">{{$total['products']}}</span>
                                    <span>Produtos</span>
                                </div>
                            </li>
                            <li class="lime">
                                <i class="icon-shopping-cart"></i>
                                <div class="details">
                                    <span class="big">{{$total['quotes']}}</span>
                                    <span>Cotações</span>
                                </div>
                            </li>
                            <li class="orange">
                                <i class="icon-briefcase"></i>
                                <div class="details">
                                    <span class="big">{{$total['clients']}}</span>
                                    <span>Clientes</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span6">
                        <div class="box box-color box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-bar-chart"></i>
                                    Cotações
                                </h3>
                            </div>
                            <div class="box-content">
                                <div class="statistic-big">
                                   <div id="ajax-cart"></div>
                                </div>
                            </div>
                        </div>
                    </div><!--span4-->

                    <div class="span6">
                        <div class="box box-color box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="glyphicon-pie_chart"></i>
                                    Armazenamento de Arquivos
                                </h3>
                            </div>
                            <div class="box-content">
                                <div class="statistic-big">
                                   <div id="quote-file"></div>
                                </div>
                            </div>
                        </div>
                    </div><!--span4-->
                </div><!--row-fluid-->

                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-color box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-tags"></i>
                                    Menor Quantidade
                                </h3>
                            </div>
                            <div class="box-content">
                                <div class="statistic-big">
                                   <div id="stock-rank"></div>
                                </div>
                            </div>
                        </div>
                    </div><!--span4-->
                </div><!--row-fluid-->

            </div>




        </div>
    </div>
</div>

<script>
    function showCart()
    {
        $.ajax({
            url: "{{route('quotes.dash')}}",
            type: "GET",
            data: {
                "_token": "{{csrf_token()}}"
            },
            dataType: 'json',
                success: function(data){
                    $("#ajax-cart").html(data['cart']);
                }
        });
    }

    function stockRank()
    {
        $.ajax({
            url: "{{route('estoques.rank')}}",
            type: "GET",
            data: {
                "_token": "{{csrf_token()}}"
            },
            dataType: 'json',
                success: function(data){
                    console.log(data);
                    $("#stock-rank").html(data['rank']);
                    quoteFile();
                }
        });
    }

    function quoteFile()
    {
        $.ajax({
            url: "{{route('quotes.files')}}",
            type: "GET",
            data: {
                "_token": "{{csrf_token()}}"
            },
            dataType: 'json',
                success: function(data){
                    console.log(data);
                    $("#quote-file").html(data['rank']);
                }
        });
    }

    showCart();
    stockRank();
  </script>

@endsection
