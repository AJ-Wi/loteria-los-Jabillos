<?php
date_default_timezone_set ('America/La_Paz');
	include('conexion/tickets.php');	
	$Estados = chequear_Limites(date('Y-m-d'));
	$Limites = limites_Generales();
	$Ticket = isset($_GET['tic'])? $_GET['tic'] : null;
	$Sor = isset($_GET['sor'])? unserialize($_GET['sor']) : null;
	$dinero = isset($_GET['mon'])? $_GET['mon'] : null;
	$Mensaje = isset($_GET['msg'])? $_GET['msg'] : null;
	$Janterior = isset($_GET['Mante'])? $_GET['Mante'] : null;
	$Total = 0;	
	$Jugadas = '';
	$x = 1;
	$HoraCompra = date('d-m-Y h:i:s');
	
	if ($Ticket != null) {	
		$Jugadas = buscar_Ticket($Ticket);
		while ($Jugada = mysqli_fetch_row($Jugadas)){
			$F = explode('-', $Jugada[5]);
			$FechaP = $F[2]."-".$F[1]."-".$F[0];
			$HoraCompra = $FechaP.' '.$Jugada[6];
		}
		mysqli_data_seek($Jugadas, 0);
	}	
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Loteria Los Jabillos</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimun-scale=1">
		<meta name="author" content="Grupo CVCELL">
		<meta name="description" content="Página pribada, solo para Voceros autorizados">
		<meta property="og:title" content="Loteria Los Jabillos" />
        <meta property="og:description" content="Página pribada, solo para Voceros autorizados" />
    	<link rel="shortcut icon" href="img/icon/jabillo.ico">
		<link rel="stylesheet" href="css/estilos.css">
		<link rel="stylesheet" href="css/principal.css">
		<link rel="stylesheet" href="css/modal.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/checked.js"></script>
	</head>
	<body onLoad="cargar()" onKeyUp="imprimir(event)">
		<input id="mensajes" type="hidden" value="<?php echo $Mensaje; ?>">
        <main>
			<div class="principal">
				<div class="cabecera">
					<button id="atras" type="submit" onclick="window.location='conexion/configurar.php';" ><img src="img/config.png" alt="config"></button>
					<h1>Agencia de Loteria Los Jabillos</h1>
				</div>				
				<div class="cuerpo">
					<form id="F1" method="post" action="conexion/agregar_jugada.php" onsubmit="return chequearLimite()">
						<div class="sorteos">
							<ul id="Lsorteos">
								<li><label class="L an" id="LL9"  for="L9" ><input id="L9"  class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="L9"  <?php echo $Sor['L9'];  ?>> LottoActivo9AM</label></li>
								<li><label class="G an" id="LG9"  for="G9" ><input id="G9"  class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="G9"  <?php echo $Sor['G9'];  ?>> LaGranjita9AM</label></li>
								<li><label class="L an" id="LL10" for="L10"><input id="L10" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="L10" <?php echo $Sor['L10']; ?>> LottoActivo10AM</label><li>
								<li><label class="G an" id="LG10" for="G10"><input id="G10" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="G10" <?php echo $Sor['G10']; ?>> LaGranjita10AM</label><li>
								<li><label class="P pa" id="LP10" for="P10"><input id="P10" class="Pai" onchange="activarLista()" type="checkbox" name="sorteos[]" value="P10" <?php echo $Sor['P10']; ?>> LosPaises10AM</label><li>
								<li><label class="L an" id="LL11" for="L11"><input id="L11" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="L11" <?php echo $Sor['L11']; ?>> LottoActivo11AM</label><li>
								<li><label class="G an" id="LG11" for="G11"><input id="G11" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="G11" <?php echo $Sor['G11']; ?>> LaGranjita11AM</label><li>
								<li><label class="P pa" id="LP11" for="P11"><input id="P11" class="Pai" onchange="activarLista()" type="checkbox" name="sorteos[]" value="P11" <?php echo $Sor['P11']; ?>> LosPaises11AM</label><li>
								<li><label class="L an" id="LL12" for="L12"><input id="L12" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="L12" <?php echo $Sor['L12']; ?>> LottoActivo12AM</label><li>
								<li><label class="G an" id="LG12" for="G12"><input id="G12" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="G12" <?php echo $Sor['G12']; ?>> LaGranjita12AM</label><li>
								<li><label class="P pa" id="LP12" for="P12"><input id="P12" class="Pai" onchange="activarLista()" type="checkbox" name="sorteos[]" value="P12" <?php echo $Sor['P12']; ?>> LosPaises12AM</label><li>
								<li><label class="L an" id="LL13" for="L13"><input id="L13" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="L13" <?php echo $Sor['L13']; ?>> LottoActivo1PM</label><li>
								<li><label class="G an" id="LG13" for="G13"><input id="G13" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="G13" <?php echo $Sor['G13']; ?>> LaGranjita1PM</label><li>
								<li><label class="P pa" id="LP13" for="P13"><input id="P13" class="Pai" onchange="activarLista()" type="checkbox" name="sorteos[]" value="P13" <?php echo $Sor['P13']; ?>> LosPaises1PM</label><li>
								<li><label class="G an" id="LG14" for="G14"><input id="G14" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="G14" <?php echo $Sor['G14']; ?>> LaGranjita2PM</label><li>
								<li><label class="P pa" id="LP14" for="P14"><input id="P14" class="Pai" onchange="activarLista()" type="checkbox" name="sorteos[]" value="P14" <?php echo $Sor['P14']; ?>> LosPaises2PM</label><li>
								<li><label class="L an" id="LL15" for="L15"><input id="L15" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="L15" <?php echo $Sor['L15']; ?>> LottoActivo3PM</label><li>
								<li><label class="G an" id="LG15" for="G15"><input id="G15" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="G15" <?php echo $Sor['G15']; ?>> LaGranjita3PM</label><li>
								<li><label class="P pa" id="LP15" for="P15"><input id="P15" class="Pai" onchange="activarLista()" type="checkbox" name="sorteos[]" value="P15" <?php echo $Sor['P15']; ?>> LosPaises3PM</label><li>
								<li><label class="L an" id="LL16" for="L16"><input id="L16" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="L16" <?php echo $Sor['L16']; ?>> LottoActivo4PM</label><li>
								<li><label class="G an" id="LG16" for="G16"><input id="G16" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="G16" <?php echo $Sor['G16']; ?>> LaGranjita4PM</label><li>
								<li><label class="P pa" id="LP16" for="P16"><input id="P16" class="Pai" onchange="activarLista()" type="checkbox" name="sorteos[]" value="P16" <?php echo $Sor['P16']; ?>> LosPaises4PM</label><li>
								<li><label class="L an" id="LL17" for="L17"><input id="L17" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="L17" <?php echo $Sor['L17']; ?>> LottoActivo5PM</label><li>
								<li><label class="G an" id="LG17" for="G17"><input id="G17" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="G17" <?php echo $Sor['G17']; ?>> LaGranjita5PM</label><li>
								<li><label class="P pa" id="LP17" for="P17"><input id="P17" class="Pai" onchange="activarLista()" type="checkbox" name="sorteos[]" value="P17" <?php echo $Sor['P17']; ?>> LosPaises5PM</label><li>
								<li><label class="L an" id="LL18" for="L18"><input id="L18" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="L18" <?php echo $Sor['L18']; ?>> LottoActivo6PM</label><li>
								<li><label class="G an" id="LG18" for="G18"><input id="G18" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="G18" <?php echo $Sor['G18']; ?>> LaGranjita6PM</label><li>
								<li><label class="P pa" id="LP18" for="P18"><input id="P18" class="Pai" onchange="activarLista()" type="checkbox" name="sorteos[]" value="P18" <?php echo $Sor['P18']; ?>> LosPaises6PM</label><li>
								<li><label class="L an" id="LL19" for="L19"><input id="L19" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="L19" <?php echo $Sor['L19']; ?>> LottoActivo7PM</label><li>	
								<li><label class="G an" id="LG19" for="G19"><input id="G19" class="Ani" onchange="activarLista()" type="checkbox" name="sorteos[]" value="G19" <?php echo $Sor['G19']; ?>> LaGranjita7PM</label><li>
								<li><label class="P pa" id="LP19" for="P19"><input id="P19" class="Pai" onchange="activarLista()" type="checkbox" name="sorteos[]" value="P19" <?php echo $Sor['P19']; ?>> LosPaises7PM</label><li>
							</ul>
							<input type="button" class="menuboton" value="Pagar Ticket" onclick="window.location='conexion/pagar.php';" >
							<input type="button" class="menuboton" value="Resultados" onclick="window.location='conexion/resultados.php';" >
							<div class="eliminar">
								<input id="eliminarT" onKeyUp="saltar(event, 'A')" class="texto" type="text" autocomplete="on" placeholder="Ingrese Ticket..." name="eliminarticket" >
							</div>
							<input id="btnAnular" type="button" class="menuboton" value="Anular Ticket" onclick="eliminar_T()" >		
							<input type="button" class="menuboton" value="Cuentas" onclick="window.location='conexion/cuentas.php';" >
						</div>
						<div class="animalitos">
							<ul id="Lanimalitos">
								<li><label class="G A" for="00"><input id="00" type="checkbox" name="animalitos[]" value="00" > 00 - Ballena</label></li>							
								<li><label class="G A" for="0"><input  id="0"  type="checkbox" name="animalitos[]" value="0"  >&nbsp;&nbsp; 0 - Delfín</label></li>
								<li><label class="L A" for="1"><input  id="1"  type="checkbox" name="animalitos[]" value="1"  > 01 - Carnero</label></li>
								<li><label class="A"   for="2"><input  id="2"  type="checkbox" name="animalitos[]" value="2"  > 02 - Toro</label></li>
								<li><label class="L A" for="3"><input  id="3"  type="checkbox" name="animalitos[]" value="3"  > 03 - CienPies</label></li>
								<li><label class="A"   for="4"><input  id="4"  type="checkbox" name="animalitos[]" value="4"  > 04 - Alacran</label></li>
								<li><label class="L A" for="5"><input  id="5"  type="checkbox" name="animalitos[]" value="5"  > 05 - León</label></li>
								<li><label class="A"   for="6"><input  id="6"  type="checkbox" name="animalitos[]" value="6"  > 06 - Rana</label></li>
								<li><label class="L A" for="7"><input  id="7"  type="checkbox" name="animalitos[]" value="7"  > 07 - Perico</label></li>
								<li><label class="A"   for="8"><input  id="8"  type="checkbox" name="animalitos[]" value="8"  > 08 - Raton</label></li>
								<li><label class="L A" for="9"><input  id="9"  type="checkbox" name="animalitos[]" value="9"  > 09 - Aguila</label></li>
								<li><label class="A"   for="10"><input id="10" type="checkbox" name="animalitos[]" value="10" > 10 - Tigre</label></li>
								<li><label class="A"   for="11"><input id="11" type="checkbox" name="animalitos[]" value="11" > 11 - Gato</label></li>
								<li><label class="L A" for="12"><input id="12" type="checkbox" name="animalitos[]" value="12" > 12 - Caballo</label></li>
								<li><label class="A"   for="13"><input id="13" type="checkbox" name="animalitos[]" value="13" > 13 - Mono</label></li>
								<li><label class="L A" for="14"><input id="14" type="checkbox" name="animalitos[]" value="14" > 14 - Paloma</label></li>
								<li><label class="A"   for="15"><input id="15" type="checkbox" name="animalitos[]" value="15" > 15 - Zorro</label></li>
								<li><label class="L A" for="16"><input id="16" type="checkbox" name="animalitos[]" value="16" > 16 - Oso</label></li>
								<li><label class="A"   for="17"><input id="17" type="checkbox" name="animalitos[]" value="17" > 17 - Pavo</label></li>
								<li><label class="L A" for="18"><input id="18" type="checkbox" name="animalitos[]" value="18" > 18 - Burro</label></li>
								<li><label class="L A" for="19"><input id="19" type="checkbox" name="animalitos[]" value="19" > 19 - Chivo</label></li>							
								<li><label class="A"   for="20"><input id="20" type="checkbox" name="animalitos[]" value="20" > 20 - Cochino</label></li>
								<li><label class="L A" for="21"><input id="21" type="checkbox" name="animalitos[]" value="21" > 21 - Gallo</label></li>
								<li><label class="A"   for="22"><input id="22" type="checkbox" name="animalitos[]" value="22" > 22 - Camello</label></li>
								<li><label class="L A" for="23"><input id="23" type="checkbox" name="animalitos[]" value="23" > 23 - Cebra</label></li>
								<li><label class="A"   for="24"><input id="24" type="checkbox" name="animalitos[]" value="24" > 24 - Iguana</label></li>
								<li><label class="L A" for="25"><input id="25" type="checkbox" name="animalitos[]" value="25" > 25 - Gallina</label></li>
								<li><label class="A"   for="26"><input id="26" type="checkbox" name="animalitos[]" value="26" > 26 - Vaca</label></li>
								<li><label class="L A" for="27"><input id="27" type="checkbox" name="animalitos[]" value="27" > 27 - Perro</label></li>
								<li><label class="A"   for="28"><input id="28" type="checkbox" name="animalitos[]" value="28" > 28 - Zamuro</label></li>
								<li><label class="A"   for="29"><input id="29" type="checkbox" name="animalitos[]" value="29" > 29 - Elefante</label></li>
								<li><label class="L A" for="30"><input id="30" type="checkbox" name="animalitos[]" value="30" > 30 - Caimán</label></li>
								<li><label class="A"   for="31"><input id="31" type="checkbox" name="animalitos[]" value="31" > 31 - Lapa</label></li>
								<li><label class="L A" for="32"><input id="32" type="checkbox" name="animalitos[]" value="32" > 32 - Ardilla</label></li>
								<li><label class="A"   for="33"><input id="33" type="checkbox" name="animalitos[]" value="33" > 33 - Pescado</label></li>
								<li><label class="L A" for="34"><input id="34" type="checkbox" name="animalitos[]" value="34" > 34 - Venado</label></li>
								<li><label class="A"   for="35"><input id="35" type="checkbox" name="animalitos[]" value="35" > 35 - Jirafa</label></li>
								<li><label class="L A" for="36"><input id="36" type="checkbox" name="animalitos[]" value="36" > 36 - Culebra</label></li>
							</ul>
						</div>
						<div class="animalitos">
							<ul id="Lanimalitos">								
								<li><label class="P PA" for="Pa1" ><input id="Pa1"  type="checkbox" name="paises[]" value="1"  > 01 - Venezuela	</label></li>
								<li><label class="P PA" for="Pa2" ><input id="Pa2"  type="checkbox" name="paises[]" value="2"  > 02 - China		</label></li>
								<li><label class="P PA" for="Pa3" ><input id="Pa3"  type="checkbox" name="paises[]" value="3"  > 03 - USA		</label></li>
								<li><label class="P PA" for="Pa4" ><input id="Pa4"  type="checkbox" name="paises[]" value="4"  > 04 - Arabia	</label></li>
								<li><label class="P PA" for="Pa5" ><input id="Pa5"  type="checkbox" name="paises[]" value="5"  > 05 - Brasil	</label></li>
								<li><label class="P PA" for="Pa6" ><input id="Pa6"  type="checkbox" name="paises[]" value="6"  > 06 - Colombia	</label></li>
								<li><label class="P PA" for="Pa7" ><input id="Pa7"  type="checkbox" name="paises[]" value="7"  > 07 - Japon		</label></li>
								<li><label class="P PA" for="Pa8" ><input id="Pa8"  type="checkbox" name="paises[]" value="8"  > 08 - Alemania	</label></li>
								<li><label class="P PA" for="Pa9" ><input id="Pa9"  type="checkbox" name="paises[]" value="9"  > 09 - Bolivia	</label></li>
								<li><label class="P PA" for="Pa10"><input id="Pa10" type="checkbox" name="paises[]" value="10" > 10 - Cuba		</label></li>
								<li><label class="P PA" for="Pa11"><input id="Pa11" type="checkbox" name="paises[]" value="11" > 11 - Chile		</label></li>
								<li><label class="P PA" for="Pa12"><input id="Pa12" type="checkbox" name="paises[]" value="12" > 12 - Corea		</label></li>
								<li><label class="P PA" for="Pa13"><input id="Pa13" type="checkbox" name="paises[]" value="13" > 13 - Italia	</label></li>
								<li><label class="P PA" for="Pa14"><input id="Pa14" type="checkbox" name="paises[]" value="14" > 14 - Africa	</label></li>
								<li><label class="P PA" for="Pa15"><input id="Pa15" type="checkbox" name="paises[]" value="15" > 15 - España	</label></li>
								<li><label class="P PA" for="Pa16"><input id="Pa16" type="checkbox" name="paises[]" value="16" > 16 - Mexico	</label></li>
								<li><label class="P PA" for="Pa17"><input id="Pa17" type="checkbox" name="paises[]" value="17" > 17 - Jamaica	</label></li>
								<li><label class="P PA" for="Pa18"><input id="Pa18" type="checkbox" name="paises[]" value="18" > 18 - Francia	</label></li>
								<li><label class="P PA" for="Pa19"><input id="Pa19" type="checkbox" name="paises[]" value="19" > 19 - Egipto	</label></li>							
								<li><label class="P PA" for="Pa20"><input id="Pa20" type="checkbox" name="paises[]" value="20" > 20 - Suecia	</label></li>
								<li><label class="P PA" for="Pa21"><input id="Pa21" type="checkbox" name="paises[]" value="21" > 21 - Peru		</label></li>
								<li><label class="P PA" for="Pa22"><input id="Pa22" type="checkbox" name="paises[]" value="22" > 22 - Filipina	</label></li>
								<li><label class="P PA" for="Pa23"><input id="Pa23" type="checkbox" name="paises[]" value="23" > 23 - Rusia		</label></li>
								<li><label class="P PA" for="Pa24"><input id="Pa24" type="checkbox" name="paises[]" value="24" > 24 - Grecia	</label></li>
								<li><label class="P PA" for="Pa25"><input id="Pa25" type="checkbox" name="paises[]" value="25" > 25 - Inglaterra</label></li>
								<li><label class="P PA" for="Pa26"><input id="Pa26" type="checkbox" name="paises[]" value="26" > 26 - Uruguay	</label></li>
								<li><label class="P PA" for="Pa27"><input id="Pa27" type="checkbox" name="paises[]" value="27" > 27 - Turquia	</label></li>
								<li><label class="P PA" for="Pa28"><input id="Pa28" type="checkbox" name="paises[]" value="28" > 28 - Canada	</label></li>
								<li><label class="P PA" for="Pa29"><input id="Pa29" type="checkbox" name="paises[]" value="29" > 29 - India		</label></li>
								<li><label class="P PA" for="Pa30"><input id="Pa30" type="checkbox" name="paises[]" value="30" > 30 - Ecuador	</label></li>
								<li><label class="P PA" for="Pa31"><input id="Pa31" type="checkbox" name="paises[]" value="31" > 31 - Marrueco	</label></li>
								<li><label class="P PA" for="Pa32"><input id="Pa32" type="checkbox" name="paises[]" value="32" > 32 - Argentina	</label></li>
								<li><label class="P PA" for="Pa33"><input id="Pa33" type="checkbox" name="paises[]" value="33" > 33 - Portugal	</label></li>
								<li><label class="P PA" for="Pa34"><input id="Pa34" type="checkbox" name="paises[]" value="34" > 34 - Dominicana</label></li>
								<li><label class="P PA" for="Pa35"><input id="Pa35" type="checkbox" name="paises[]" value="35" > 35 - Holanda	</label></li>
								<li><label class="P PA" for="Pa36"><input id="Pa36" type="checkbox" name="paises[]" value="36" > 36 - Panama	</label></li>
								<li><label class="P PA" for="Pa37"><input id="Pa37" type="checkbox" name="paises[]" value="37" > 37 - Puerto Rico</label></li>							
								<li><label class="P PA" for="Pa38"><input id="Pa38" type="checkbox" name="paises[]" value="38" > 38 - Hawuaii	</label></li>
							</ul>
						</div>
						<div class="jugada">
							<div class="agregar">
								<div class="apuesta">
									<div class="monto">
										<h4>Númeo: </h4>
										<input id="num" type="text" onKeyUp="saltar(event,'mon')" name="item" value="">
									</div>
									<div class="monto">
										<h4>Monto anterior: <?php echo $Janterior; ?></h4>
									</div>
									<div class="monto">
										<h4>Monto: </h4>
										<input id="mon" type="text" onKeyUp="saltar(event,'num')" name="apuesta" value="<?php echo $dinero; ?>" required>
									</div>
								</div>
							</div>
							<div class="Jugadas">
								<div class="opciones">									
									<input id="Ticket" type="hidden" name="Ticket" value="<?php echo $Ticket; ?>">
									<div class="listajugada">	
										<ul>
											<?php while ($Dat = mysqli_fetch_row($Jugadas)){
												$Total += $Dat[1]; 
												$ID = $Dat[4].$Dat[2].$Dat[0].$Dat[1];
												$sorteo = $x.') '.ajustar_Sorteo($Dat[4]).ajustar_Hora($Dat[2]);
												$x++;
												$Largo = strlen($sorteo);
												if($Largo < 13){
													$a = 14-$Largo;	
													if ($a == 1){$sorteo .= '&nbsp;';}
													if ($a == 2){$sorteo .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}	
													if ($a == 3){$sorteo .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}													
												}else{
													$sorteo .= '&nbsp;&nbsp;';
												}
												$sorteo = '&nbsp;'.$sorteo;
												$Jugada = $sorteo.'-&nbsp;&nbsp;'.$Dat[0].'&nbsp;&nbsp;-&nbsp;&nbsp;'.$Dat[1].' BsF.'?>												
													<li><label for="<?php echo $ID; ?>"><input id="<?php echo $ID; ?>" type="checkbox" name="jugada[]" value="<?php echo $Dat[3].','.$Dat[0].','.$Dat[4].$Dat[2].','.$Dat[1]; ?>" > <?php echo $Jugada; ?></label></li>														
											<?php }	
											mysqli_data_seek($Jugadas, 0); ?>
										</ul>
									</div>
									<input id="btnEliminar" type="button" class="boton" name="eliminar" value="Eliminar" onclick="eliminar_jugada()" >
									<input id="btnModificar" type="button" class="boton" name="modificar" value="Modificar" onclick="modificar_jugada()" >
									<input id="Nval" onKeyUp="saltar(event, 'M')" type="text" name="nuevovalor" value="">									
								</div>
								<div class="imprimir">
									<div class="previo">
										<div class="ticket">
											<h4>Agencia Los Jabillos</h4>
											<h4>Ticket: <?php echo $Ticket; ?></h4>
											<h4>Fecha: <?php echo $HoraCompra; ?></h4>
											<h4>------------------------------------</h4>
											<?php 
												if ($Jugadas != false){	
													$Juego = '';
													$c = 8;
													$j = 0;
													$S = '';
													while ($Jugada = mysqli_fetch_row($Jugadas)){
														if ($c < $Jugada[2]) {
															$HoraA = ajustar_Hora($Jugada[2]);
															$S = $Jugada[4];
															if ($j == 1) { ?>
																<h4><?php echo $Juego; ?></h4>
											<?php				$Juego = '';
																$j = 0;
															} ?>
															<h4>*** <?php echo ajustar_Sorteo($Jugada[4]).$HoraA; ?> ***</h4>
											<?php			$c = $Jugada[2];
														}	
														if ($Jugada[4] == $S){
															if ($j == 0) {
																$Juego = $Jugada[0].'&nbsp;'.$Jugada[1];
																$j = 1;
																continue;
															}
															if ($j == 1) {
																$Juego .= '&nbsp;&nbsp;&nbsp;'.$Jugada[0].'&nbsp;'.$Jugada[1]; ?>
																<h4><?php echo $Juego; ?></h4>
											<?php				$Juego = '';
																$j = 0;
															}
														}else{
															$HoraA = ajustar_Hora($Jugada[2]);
															$S = $Jugada[4];
															if ($j == 1) { ?>
																<h4><?php echo $Juego; ?></h4>
											<?php				$Juego = '';
																$j = 0;
															} ?>
															<h4>*** <?php echo ajustar_Sorteo($Jugada[4]).$HoraA; ?> ***</h4>
											<?php			if ($j == 0) {
																$Juego = $Jugada[0].'&nbsp;'.$Jugada[1];
																$j = 1;
																continue;
															}
														}
													}
													if ($Juego != ''){ ?>
														<h4><?php echo $Juego; ?></h4>
											<?php	}
												} 
											?>
											<h4>------------------------------------</h4>
											<h4>Total Venta: <?php echo number_format($Total, 0, ',', '.'); ?></h4>
											<h4>SIN TICKET NO COBRA</h4>
											<h4>CADUCA A LOS 3 DIAS</h4>
										</div>
									</div>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input id="btnRepetir" type="button" class="boton" name="repetir" value="Repetir Ticket" onclick="repetir_ticket()" >
									<input id="repetir" onKeyUp="saltar(event, 'R')" type="text" class="textoR" name="repetirTicket" autocomplete="on" placeholder="Ingrese Ticket..." value="">
								</div>
							</div>
						</div>
					</form>	
				</div>
				<input id="Est" type="hidden" value="<?php echo $Estados; ?>">
				<input id="Lim" type="hidden" value="<?php echo $Limites; ?>">
			</div>
        </main>
		<div id="imprimir">
			<form method="post" action="conexion/imprimir1.php">
				<input id="cliente" name="cliente" type="text" autocomplete="on" placeholder="Nombre del Cliente...">
				<input type="hidden" name="Ticket" value="<?php echo $Ticket; ?>">
				<input type="hidden" name="Total" value="<?php echo $Total; ?>">
				<div id="B">
				<input id="guardarT" type="submit" class="botones" name="btnImprimir" value="Guardar Ticket">
				<input id="imrpimnirT" type="submit" class="botones" name="btnImprimir" value="Imprimir Ticket">
				</div>
			</form>
		</div>
	</body>
</html>