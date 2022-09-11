<div id="left">

			<div class="subnav">
                @if(Auth::user()->level > 1)
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Administração</span></a>
				</div>
				<ul class="subnav-menu">
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
				</ul>
                @endif
			</div>

			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Operacional</span></a>
				</div>
				<ul class="subnav-menu">
					@if(Auth::user()->level <= 1)
					<li>
						<a href="{{route('dashboard.index')}}"><i class="icon-desktop"></i> DASHBOARD</a>
					</li>
					@endif
					<li>
						<a href="{{route('clientes.index')}}"><i class="glyphicon-bookmark"></i> CLIENTES</a>
					<li>
					<li>
						<a href="{{route('cotacoes.index')}}"><i class="glyphicon-shopping_bag"></i> COTAÇÕES</a>
					<li>
					<li>
						<a href="{{route('relatorios.index')}}"><i class="glyphicon-stats"></i></i> RELATÓRIOS</a>
					<li>
				</ul>
			</div>


		</div>
