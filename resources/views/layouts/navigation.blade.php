<div id="left">

			<div class="subnav">
                @if(Auth::user()->level > 1)
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Administração</span></a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="{{route('usuarios.index')}}">Usuarios</a>
					</li>
				</ul>
                @endif
			</div>

			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Cobrança</span></a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="{{route('dashboard.index')}}">CONTRATO - EVOLUTIME</a>
					</li>
					<li>
					</li>
					<li>
						<a href="#">GRAFICA - ENNT</a>
					</li>
					<li>
						<a href="#">RETORNO</a>
					</li>
				</ul>
			</div>

			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Financeiro</span></a>
				</div>
				<ul class="subnav-menu">
                    @if(Auth::user()->level > 1)
                    <li>
                        <a href="#">CAIXA</a>
                    </li>
                    @endif
				</ul>
			</div>

		</div>
