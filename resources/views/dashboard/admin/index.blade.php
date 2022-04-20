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
                                    <span>Propostas</span>
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

            </div>


        </div>
    </div>

</div>

@endsection
