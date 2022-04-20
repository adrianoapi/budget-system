<div id="left">

			<div class="subnav">
                @if(Auth::user()->level > 1)
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Administração</span></a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="{{route('usuarios.index')}}">USUÁRIOS</a>
					</li>
					<li>
						<a href="{{route('produtos.index')}}">PRODUTOS</a>
					</li>
				</ul>
                @endif
			</div>

			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Operacional</span></a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="{{route('clientes.index')}}">CLIENTES</a>
					<li>
					<li>
						<a href="{{route('cotacoes.index')}}">COTAÇÕES</a>
					<li>
				</ul>
			</div>

			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Calendar</span></a>
				</div>
				<div class="subnav-content less">
					<div class="jq-datepicker"></div>
				</div>
			</div>

		</div>
