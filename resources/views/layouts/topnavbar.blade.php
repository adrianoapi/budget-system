<div id="navigation">
    <div class="container-fluid">
    <a href="{{route('dashboard.index')}}" id="brand">DRY AIR TEC</a>
        <a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i class="icon-reorder"></i></a>

        <ul class='main-nav'>
            @if(Auth::user()->level > 1)
                <li>
                    <a href="{{route('dashboard.index')}}"><i class="icon-desktop"></i> DASHBOARD</a>
                </li>
                <li>
                    <a href="{{route('usuarios.index')}}"><i class="icon-user"></i> USUÁRIOS</a>
                </li>
                <li>
                    <a href="{{route('produtos.index')}}"><i class="icon-tags"></i> PRODUTOS</a>
                </li>
                <li>
                    <a href="{{route('empresas.index')}}"><i class="glyphicon-building"></i> EMPRESAS</a>
                </li>
                <li>
                    <a href="{{route('cotacoes.index')}}"><i class="icon-shopping-cart"></i> COTAÇÕES</a>
                </li>
                <li>
                    <a href="{{route('relatorios.index')}}"><i class="glyphicon-stats"></i></i> RELATÓRIOS</a>
                </li>
            @else
                <li>
                    <a href="{{route('dashboard.index')}}"><i class="icon-desktop"></i> DASHBOARD</a>
                </li>
                <li>
                    <a href="{{route('clientes.index')}}"><i class="icon-briefcase"></i> CLIENTES</a>
                <li>
                <li>
                    <a href="{{route('cotacoes.index')}}"><i class="icon-shopping-cart"></i> COTAÇÕES</a>
                <li>
                <li>
                    <a href="{{route('relatorios.index')}}"><i class="glyphicon-stats"></i></i> RELATÓRIOS</a>
                <li>
            @endif
        </ul>
        <div class="user">
            <ul class="icon-nav">

                <li class="dropdown sett">
                    <a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-cog"></i></a>
                    <ul class="dropdown-menu pull-right theme-settings">
                        <li>
                            <span>Layout-width</span>
                            <div class="version-toggle">
                                <a href="#" class='set-fixed'>Fixed</a>
                                <a href="#" class="active set-fluid">Fluid</a>
                            </div>
                        </li>
                        <li>
                            <span>Topbar</span>
                            <div class="topbar-toggle">
                                <a href="#" class='set-topbar-fixed'>Fixed</a>
                                <a href="#" class="active set-topbar-default">Default</a>
                            </div>
                        </li>
                        <li>
                            <span>Sidebar</span>
                            <div class="sidebar-toggle">
                                <a href="#" class='set-sidebar-fixed'>Fixed</a>
                                <a href="#" class="active set-sidebar-default">Default</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class='dropdown colo'>
                    <a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-tint"></i></a>
                    <ul class="dropdown-menu pull-right theme-colors">
                        <li class="subtitle">
                            Predefined colors
                        </li>
                        <li>
                            <span class='red'></span>
                            <span class='orange'></span>
                            <span class='green'></span>
                            <span class="brown"></span>
                            <span class="blue"></span>
                            <span class='lime'></span>
                            <span class="teal"></span>
                            <span class="purple"></span>
                            <span class="pink"></span>
                            <span class="magenta"></span>
                            <span class="grey"></span>
                            <span class="darkblue"></span>
                            <span class="lightred"></span>
                            <span class="lightgrey"></span>
                            <span class="satblue"></span>
                            <span class="satgreen"></span>
                        </li>
                    </ul>
                </li>

            </ul>
            <div class="dropdown">
                <a href="#" class='dropdown-toggle' data-toggle="dropdown">{{Auth::user()->name}}</a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="{{route('usuarios.profile')}}"><i class="icon-user"></i> Perfil</a>
                    </li>
                    <li>
                        <a href="{{route('login.logout')}}"><i class="icon-off"></i> Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
