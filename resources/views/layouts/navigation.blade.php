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
				</ul>
                @endif
			</div>

			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Proposta</span></a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="{{route('clientes.index')}}">CLIENTES</a>
					<li>
				</ul>
			</div>

		</div>
