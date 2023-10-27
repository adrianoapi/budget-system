<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>FLAT Email Template</title>
	<style type="text/css">
		/* Based on The MailChimp Reset INLINE: Yes. */  
		/* Client-specific Styles */
		#outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
		body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;} 
		/* Prevent Webkit and Windows Mobile platforms from changing default font sizes.*/ 
		.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */  
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		/* Forces Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */ 
		#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
		/* End reset */

		/* Some sensible defaults for images
		Bring inline: Yes. */
		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;} 
		a img {border:none;} 
		.image_fix {display:block;}

		/* Yahoo paragraph fix
		Bring inline: Yes. */
		p {margin: 1em 0;}

		/* Hotmail header color reset
		Bring inline: Yes. */
		h1, h2, h3, h4, h5, h6 {color: black !important;}

		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}

		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
		color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
		}

		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
		color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
		}

		/* Outlook 07, 10 Padding issue fix
		Bring inline: No.*/
		table td {border-collapse: collapse;}

		/* Remove spacing around Outlook 07, 10 tables
		Bring inline: Yes */
		table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }


		/***************************************************
		****************************************************
		MOBILE TARGETING
		****************************************************
		***************************************************/
		@media only screen and (max-device-width: 480px) {
			/* Part one of controlling phone number linking for mobile. */
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: blue; /* or whatever your want */
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: orange !important;
						pointer-events: auto;
						cursor: default;
					}

		}

		/* More Specific Targeting */

		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
		/* You guessed it, ipad (tablets, smaller screens, etc) */
			/* repeating for the ipad */
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: blue; /* or whatever your want */
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: orange !important;
						pointer-events: auto;
						cursor: default;
					}
		}
	</style>

	<!-- Targeting Windows Mobile -->
	<!--[if IEMobile 7]>
	<style type="text/css">
	
	</style>
	<![endif]-->   

	<!-- ***********************************************
	****************************************************
	END MOBILE TARGETING
	****************************************************
	************************************************ -->

	<!--[if gte mso 9]>
		<style>
		/* Target Outlook 2007 and 2010 */
		</style>
	<![endif]-->
</head>
<img src="{!! asset('flat-admin/img/lonhas_pdf.png') !!}" width="130px" alt=""
style="float:right;margin-top:-80px;margin-right:-45px;z-index:-1;" />
<body style="padding:0; margin:0;margin-top:-30px;" bgcolor="#ffffff">

	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td align="center">
				<center>
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td style="" >
                                <img src="{!! asset('flat-admin/img/logo.jpg') !!}" width="300px" alt="" style="display:block;" />
                            </td>
							<td style="">
                            </td>
							<td style="">
								&nbsp;
                            </td>
							<td style="">
								&nbsp;
                            </td>
							<td style="">
							{{$logo}}
								@if(!empty($logo))
								<?php 
								#$imgsrc = '@'.base64_encode(route('usuarios.image.show', ['logo' => $logo]));
								$path = route('usuarios.image.show', ['logo' => $logo]);
								$type = pathinfo($logo, PATHINFO_EXTENSION);
								$data = file_get_contents($path);
								$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
								echo $html = '<img src="'.$base64 .'" width="300" height="60" border="0" />';
								?>
								@else
									<a href="http://www.dryairtec.com.br" style="color:#333333 !important; font-size:16px; font-family: Arial, Verdana, sans-serif; padding-left:10px;">www.dryairtec.com.br</a>
								@endif
                            </td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
	<br/>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#368ee0">
		<tr>
			<td align="center">
				&nbsp;
			</td>
		</tr>
	</table>
	<table border="1" cellpadding="5" cellspacing="2" width="100%" bgcolor="#fff" style="border-style:dotted;font-size:12px; line-height:18px;">
		<tr>
			<td align="center">
				<center>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#fff" style="border-style:solid;font-family: Arial, Verdana, sans-serif;font-size:12px; line-height:18px;">
						<tr>
							<td>
								<span>De</span><br>
                                <strong>{{$quote->company->name}}</strong><br>
                                    {{$quote->company->endereco}}, {{$quote->company->numero}}, {{$quote->company->complemento}}<br>
                                    {{$quote->company->bairro}}, {{$quote->company->cidade}} - {{$quote->company->estado}},  {{$quote->company->cep}} <br>
                                    CNPJ: {{$quote->company->cpf_cnpj}}, IE: {{$quote->company->ie}}<br>
									<abbr title="Telefone">Telefone:</abbr> {{$quote->company->telefone}} -
                                    <abbr title="Comercial">Comercial:</abbr> {{$quote->company->telefone_com}} <br>
                                    <abbr title="Celular">Celular:</abbr> {{$quote->company->celular}}
                            </td>
							<td>
								<span>Para</span><br>
                                <strong>{{$quote->client->name}}</strong><br>
                                    {{$quote->client->endereco}}, {{$quote->client->numero}} <br>
                                    {{$quote->client->bairro}}, {{$quote->client->cidade}}/{{$quote->client->estado}}, {{$quote->client->cep}} <br>
                                    CNPJ: {{$quote->client->cpf_cnpj}}, IE: {{$quote->client->ie}}<br>
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
                                    Contato: {{$quote->client->responsavel}} <abbr title="E-mail">E-mail:</abbr> {{$quote->client->celular}}<br>
                            </td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
		<tr>
			<td>
				<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff">
					<tr>
						<td align="center">
							<center>
								<table border="0" width="500" cellpadding="0" cellspacing="0">
									<tr>
										<td style="color:#333333 !important; font-size:20px; font-family: Arial, Verdana, sans-serif; padding-left:10px;" height="40">
											<p style="font-size:12px; line-height:18px;">
												Projeto: <strong>{{$quote->name}}</strong><br />
												Serial/Versão: {{$quote->serial}}
											</p>
										</td>
										<td style="color:#333333 !important; font-size:20px; font-family: Arial, Verdana, sans-serif; padding-left:10px;" height="40">
											<p style="font-size:12px; line-height:18px;">
												Data: {{$date}}<br>
											</p>
										</td>
									</tr>
								</table>
							</center>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
    <table border="1" cellpadding="5" cellspacing="2" width="100%" bgcolor="#fff" style="border-style:dotted;font-size:12px; line-height:18px;">
        <thead>
            <tr style="background-color: #eeeeee; font-family: Arial, Verdana, sans-serif;">
                <th colspan="12">PRODUTOS</th>
            </tr>
            <tr style="background-color: #eeeeee; font-family: Arial, Verdana, sans-serif;">
                <th>#</th>
                <th>Esp.</th>
                <th>Cobre</th>
                <th>Aço</th>
                <th>Código</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Uni</th>
                <th>Qtd</th>
                <th>ICMS</th>
                <th>IPI</th>
                <th style="width:80px">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
				$total = 0;
				$ipi   = 0;
				$i     = 0;
			?>
			@foreach($quote->items as $value)
			<?php 
			$i++;

			# Se tiver fator > 0
			if($value->fator > 0){
				$total_produto = ($value->Product->valor * $value->fator) * $value->quantidade;
				$total = $total + $total_produto;
			}else{
				$total_produto = $value->Product->valor * $value->quantidade;
				$total = $total + $total_produto;
			}

			if($value->ipi == "6.5")
			{
				$percentual_total_produto = $total_produto;

				if($quote->percentual > 0)
				{
					$descontoPercentual       = ($total_produto * $quote->percentual / 100);
					$percentual_total_produto = $total_produto - $descontoPercentual;
				}
				$ipi = $ipi + (($percentual_total_produto * 6.5) / 100);
			}
			?>
            <tr style="background-color: {{($i % 2) == 0 ? '#f9f9f9' : '#fff'}}; font-family: Arial, Verdana, sans-serif;">
                <td class="">{{$i}}</td>
                <td class="">{{$value->Product->espessura}}</td>
                <td class="">{{$value->Product->cobre}}</td>
                <td class="">{{$value->Product->aco}}</td>
                <td class="">{{$value->Product->codigo}}</td>
                <td class="">{{$value->Product->descricao}}</td>
                <td class="" align="right">
					@if($value->fator > 0)
						{{number_format($value->Product->valor * $value->fator,2,',','.')}}
					@else
						{{number_format($value->Product->valor,2,',','.')}}
					@endif
                </td>
                <td class="">{{$value->Product->unidade}}</td>
                <td class="">{{$value->quantidade}}</td>
                <td class="">{{$icmsLista[$value->icms]}}</td>
                <td class="">{{$ipiLista[$value->ipi]}}</td>
                <td class="" align="right">
					@if($value->fator > 0)
					R$ {{number_format(($value->Product->valor * $value->fator) * $value->quantidade,2,',','.')}}
					@else
					R$ {{number_format($value->Product->valor * $value->quantidade,2,',','.')}}
					@endif
				</td>
            </tr>
            @endforeach
            <tr style="background-color: #fff; font-family: Arial, Verdana, sans-serif;">
				<td colspan="9"></td>
				<td colspan="3" class="taxes">
					<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#fff" style="border-style:dotted;font-size:12px; line-height:18px;">
						<tr>
							<td align="left" class="light">Subtotal</td>
							<td align="right">R$ {{number_format($total,2,',','.')}}</td>
						</tr>

						@if ($quote->percentual > 0)
						<tr>
							<td align="left" class="light">Desconto</td>
							<td align="right" class="totalprice">
								<?php
									$descontoPerccentual = ($total * $quote->percentual / 100);
									$total = $total - $descontoPerccentual;
								?>
								R$ {{number_format($descontoPerccentual, 2, ",",".")}}
							</td>
						</tr>
						@endif
		
						@if ($ipi > 0)
						<tr>
							<td align="left" class="light">IPI</td>
							<td align="right" class="totalprice">
								{{number_format($ipi, 2, ",",".")}}
							</td>
						</tr>
						@endif
		
						@if ($quote->total > 0)
						<tr>
							<td align="left" class="light">Desconto</td>
							<td align="right" class="totalprice">
								<?php $total = ($total + $quote->frete + $ipi) - $quote->total; ?>
								R$ {{number_format($total, 2, ",",".")}}
							</td>
						</tr>
						@endif
		
						@if ($quote->frete > 0)
						<tr>
							<td align="left" class="light">Frete</td>
							<td align="right" class="totalprice">
								R$ {{number_format($quote->frete, 2, ",",".")}}
							</td>
						</tr>
						@endif
		
						@if ($quote->total > 0)
						<tr>
							<td align="left" class="light">Total</td>
							<td align="right" class="totalprice">
								<?php 
									$total = $quote->total;
		
									if($quote->frete > 0){
										$total = $total + $quote->frete;
									}
		
									if($ipi > 0){
										$total = $total + $ipi;
									}
								?>
								R$ {{number_format($quote->total, 2, ",",".")}}
							</td>
						</tr>
						@else
						<tr>
							<td align="left" class="light">Total</td>
							<td align="right" class="totalprice">
								<?php 
									if($quote->frete > 0){
										$total = $total + $quote->frete;
									}
		
									if($ipi > 0){
										$total = $total + $ipi;
									}
								?>
								R$ {{number_format($total, 2, ",",".")}}
							</td>
						</tr>
						@endif
					
					</table>	
				</td>
			</tr>
        </tbody>
    </table>

	<table border="0" cellpadding="2" cellspacing="2" width="100%" bgcolor="#fff" style="font-family: Arial, Verdana, sans-serif; font-size:12px; line-height:18px;">
		<thead>
			<tr>
				<th style="width:130px;text-align: left;"><strong>Condições comerciais</strong></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr style="background-color: #fff">
				<td>Representante:</td>
				<td>{{$quote->representante}}</td>
			</tr>
			<tr style="background-color: #f9f9f9">
				<td>Prazo de Pagamento:</td>
				<td>{{$quote->pagamento}}</td>
			</tr>
			<tr style="background-color: #fff">
				<td>Prazo de entrega:</td>
				<td>{{$quote->prazo}}</td>
			</tr>
			<tr style="background-color: #f9f9f9">
				<td>Transportadora:</td>
				<td>{{$quote->transportadora}}</td>
			</tr>
			<tr style="background-color: #fff">
				<td valign="top">Observação:</td>
				<td>{!!$quote->observacao!!}</td>
			</tr>
		</tbody>
	</table>
	
	<p style="font-family: Arial, Verdana, sans-serif; font-size:12px; color:#000; line-height:18px;"><strong>Observações Gerais:</strong></p>
	<span style="font-family: Arial, Verdana, sans-serif; font-size:12px; color:#000; line-height:18px;">- Os serviços de mão de obra necessários para a montagem não estão incluídos nos preços acima.</span><br>
	<span style="font-family: Arial, Verdana, sans-serif; font-size:12px; color:#000; line-height:18px;">- VALIDADE: 5 DIAS</span><br>
	<span style="font-family: Arial, Verdana, sans-serif; font-size:12px; color:#000; line-height:18px;">- Mercadoria não configura uso em auto peças.</span><br>
	<span style="font-family: Arial, Verdana, sans-serif; font-size:12px; color:#000; line-height:18px;">- Diferencial de alíquota sera recolhido ao Estado de destino pelo comprador.</span><br>
	<span style="font-family: Arial, Verdana, sans-serif; font-size:12px; color:#000; line-height:18px;">- Valor sem ST, Se aplicável, será de responsabilidade do comprador d☺e acordo com as regras e legislação aplicável.</span><br>
<br>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#368ee0">
		<tr>
			<td align="center">
				<center>
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td style="text-align:center;color:#ffffff !important; font-size:20px; font-family: Arial, Verdana, sans-serif; padding-left:10px;" height="40">
								<center>
									<p style="font-size:12px; line-height:18px;">
                                        {{strtoupper($quote->company->name)}} &copy; {{date('Y')}}
								</p>
								</center>
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>

</body>

</html>