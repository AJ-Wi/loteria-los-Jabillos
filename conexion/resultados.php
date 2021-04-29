<?php
date_default_timezone_set ('America/La_Paz');
	include('../conexion/tickets.php');	
	$xml = new DomDocument(); 
	$user = 'cvcell';
	$pass = 'Job3142617516';
	$Animalito = isset($_POST['animalito'])? $_POST['animalito'] : null;
	$Pais = isset($_POST['pais'])? $_POST['pais'] : null;
	$Sorteos = isset($_POST['sorteo'])? $_POST['sorteo'] : null;
	$Fechas = isset($_POST['fechas'])? $_POST['fechas'] : null;
	$Hora = '';
	if ($Fechas != null){
		$Fecha = $Fechas;
	}else{
		$Fecha = date('Y-m-d');
	}
	
	if ($Pais != null){
		$Animalito = $Pais;
	}
	$P = explode('-', $Animalito);

	if ($Sorteos != null){
		$Horas = substr($Sorteos, 1);
		$Sorteo = substr($Sorteos, 0, 1);
		$consulta = "SELECT animalito FROM resultados WHERE fecha='".$Fecha."' AND hora='".$Horas."' AND sorteo='".$Sorteo."'";
		$resultado = mysqli_query(conexion(), $consulta);
		if (mysqli_num_rows($resultado) == 0){
            $sql = "INSERT INTO resultados (animalito, hora, fecha, sorteo) VALUES ('".$Animalito."', '".$Horas."', '".$Fecha."', '".$Sorteo."')";
			mysqli_query(conexion(), $sql);
			$sql1 = "UPDATE tickets SET premiado=true WHERE animalito='".$Animalito."' AND fecha='".$Fecha."' AND hora='".$Horas."' AND sorteo='".$Sorteo."'";
			mysqli_query(conexion(), $sql1);
			$xml->loadHTMLFile('http://cvcell.com.ve/conexion/registrar_resultado.php?usuario='.$user.'&clave='.$pass.'&id='.$P[0].'&sorteo='.$Sorteo.'&hora='.$Horas.'&fecha='.$Fecha.'&tipo=nuevo');
        }else{			
            $sql = "UPDATE resultados SET animalito='".$Animalito."' WHERE fecha='".$Fecha."' AND hora='".$Horas."' AND sorteo='".$Sorteo."'";
			mysqli_query(conexion(), $sql);			
			while ($Dato = mysqli_fetch_row($resultado)){
				$sql1 = "UPDATE tickets SET premiado=false WHERE animalito='".$Dato[0]."' AND fecha='".$Fecha."' AND hora='".$Horas."' AND sorteo='".$Sorteo."'";
				mysqli_query(conexion(), $sql1);
			}
			$sql2 = "UPDATE tickets SET premiado=true WHERE animalito='".$Animalito."' AND fecha='".$Fecha."' AND hora='".$Horas."' AND sorteo='".$Sorteo."'";
			mysqli_query(conexion(), $sql2);
			$xml->loadHTMLFile('http://cvcell.com.ve/conexion/registrar_resultado.php?usuario='.$user.'&clave='.$pass.'&id='.$P[0].'&sorteo='.$Sorteo.'&hora='.$Horas.'&fecha='.$Fecha.'&tipo=actualizar');
        }		
		$Sorteos = null;
	}
	
	$ResultadosL = resultados($Fecha, 'L');
	$ResultadosG = resultados($Fecha, 'G');
	$ResultadosP = resultados($Fecha, 'P');
	$MostrarP = buscar_todos_Premiado($Fecha);	
	$VentaH = venta_Horas($Fecha);
	$ResultL = array();
	$ResultG = array();
	$ResultP = array();
	$Venta =0;
	$VentaT = 0;
	$PagarT = 0;
	$GananciaT = 0;
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
    	<link rel="shortcut icon" href="/img/icon/jabillo.ico">
		<link rel="stylesheet" href="/css/estilos.css">
		<link rel="stylesheet" href="/css/resultados.css">
		<script src="/js/jquery.min.js"></script>
		<script src="/js/checked_resultados.js"></script>
	</head>
	<body onLoad="cargar()">
        <main>
			<div class="principal">
				<div class="cabecera">
					<button id="atras" type="submit" onclick="window.location='/';" ><img src="/img/atras.png" alt="atras"></button>
					<h1>Agencia de Loteria Los Jabillos</h1>
				</div>				
				<div class="cuerpo">
					<form name="f1" class="formulario" method="post" action="" >
						<div class="sorteos">
							<ul id="Lsorteos">
								<li><label class="L" id="LL9"  for="L9" ><input id="L9"  class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="L9" > LottoActivo9AM</label></li>
								<li><label class="G" id="LG9"  for="G9" ><input id="G9"  class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="G9" > LaGranjita9AM</label></li>
								<li><label class="L" id="LL10" for="L10"><input id="L10" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="L10"> LottoActivo10AM</label><li>
								<li><label class="G" id="LG10" for="G10"><input id="G10" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="G10"> LaGranjita10AM</label><li>
								<li><label class="P" id="LP10" for="P10"><input id="P10" class="Pai" onchange="activarLista()" type="radio" name="sorteo" value="P10"> LosPaises10AM</label><li>
								<li><label class="L" id="LL11" for="L11"><input id="L11" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="L11"> LottoActivo11AM</label><li>
								<li><label class="G" id="LG11" for="G11"><input id="G11" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="G11"> LaGranjita11AM</label><li>
								<li><label class="P" id="LP11" for="P11"><input id="P11" class="Pai" onchange="activarLista()" type="radio" name="sorteo" value="P11"> LosPaises11AM</label><li>
								<li><label class="L" id="LL12" for="L12"><input id="L12" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="L12"> LottoActivo12AM</label><li>
								<li><label class="G" id="LG12" for="G12"><input id="G12" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="G12"> LaGranjita12AM</label><li>
								<li><label class="P" id="LP12" for="P12"><input id="P12" class="Pai" onchange="activarLista()" type="radio" name="sorteo" value="P12"> LosPaises12AM</label><li>
								<li><label class="L" id="LL13" for="L13"><input id="L13" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="L13"> LottoActivo1PM</label><li>
								<li><label class="G" id="LG13" for="G13"><input id="G13" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="G13"> LaGranjita1PM</label><li>
								<li><label class="P" id="LP13" for="P13"><input id="P13" class="Pai" onchange="activarLista()" type="radio" name="sorteo" value="P13"> LosPaises1PM</label><li>
								<li><label class="G" id="LG14" for="G14"><input id="G14" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="G14"> LaGranjita2PM</label><li>
								<li><label class="P" id="LP14" for="P14"><input id="P14" class="Pai" onchange="activarLista()" type="radio" name="sorteo" value="P14"> LosPaises2PM</label><li>
								<li><label class="L" id="LL15" for="L15"><input id="L15" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="L15"> LottoActivo3PM</label><li>
								<li><label class="G" id="LG15" for="G15"><input id="G15" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="G15"> LaGranjita3PM</label><li>
								<li><label class="P" id="LP15" for="P15"><input id="P15" class="Pai" onchange="activarLista()" type="radio" name="sorteo" value="P15"> LosPaises3PM</label><li>
								<li><label class="L" id="LL16" for="L16"><input id="L16" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="L16"> LottoActivo4PM</label><li>
								<li><label class="G" id="LG16" for="G16"><input id="G16" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="G16"> LaGranjita4PM</label><li>
								<li><label class="P" id="LP16" for="P16"><input id="P16" class="Pai" onchange="activarLista()" type="radio" name="sorteo" value="P16"> LosPaises4PM</label><li>
								<li><label class="L" id="LL17" for="L17"><input id="L17" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="L17"> LottoActivo5PM</label><li>
								<li><label class="G" id="LG17" for="G17"><input id="G17" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="G17"> LaGranjita5PM</label><li>
								<li><label class="P" id="LP17" for="P17"><input id="P17" class="Pai" onchange="activarLista()" type="radio" name="sorteo" value="P17"> LosPaises5PM</label><li>
								<li><label class="L" id="LL18" for="L18"><input id="L18" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="L18"> LottoActivo6PM</label><li>
								<li><label class="G" id="LG18" for="G18"><input id="G18" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="G18"> LaGranjita6PM</label><li>
								<li><label class="P" id="LP18" for="P18"><input id="P18" class="Pai" onchange="activarLista()" type="radio" name="sorteo" value="P18"> LosPaises6PM</label><li>
								<li><label class="L" id="LL19" for="L19"><input id="L19" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="L19"> LottoActivo7PM</label><li>	
								<li><label class="G" id="LG19" for="G19"><input id="G19" class="Ani" onchange="activarLista()" type="radio" name="sorteo" value="G19"> LaGranjita7PM</label><li>
								<li><label class="P" id="LP19" for="P19"><input id="P19" class="Pai" onchange="activarLista()" type="radio" name="sorteo" value="P19"> LosPaises7PM</label><li>
							</ul>
							<input id="agregarR" type="submit" class="menuboton" value="Agregar Resultado" >
							<div class="cajaF">
								<input id="fecha"  type="date" name="fechas">
							</div>
							<input class="menuboton" type="submit" value="Buscar por Fecha">
							<input type="button" class="menuboton" value="ventas por paises" onclick="window.location='ventaspaises.php';" >
						</div>
						<div class="animalitos">
							<ul id="Lanimalitos">
								<li><label class="G A" for="00"><input id="00" type="radio" name="animalito" value="00-Bal" > 00 - Ballena</label></li>							
								<li><label class="G A" for="0"><input  id="0"  type="radio" name="animalito" value="0-Del"  >&nbsp;&nbsp; 0 - Delfín</label></li>
								<li><label class="L A" for="1"><input  id="1"  type="radio" name="animalito" value="1-Car"  > 01 - Carnero</label></li>
								<li><label class="A"   for="2"><input  id="2"  type="radio" name="animalito" value="2-Tor"  > 02 - Toro</label></li>
								<li><label class="L A" for="3"><input  id="3"  type="radio" name="animalito" value="3-Cie"  > 03 - CienPies</label></li>
								<li><label class="A"   for="4"><input  id="4"  type="radio" name="animalito" value="4-Ala"  > 04 - Alacran</label></li>
								<li><label class="L A" for="5"><input  id="5"  type="radio" name="animalito" value="5-Leo"  > 05 - León</label></li>
								<li><label class="A"   for="6"><input  id="6"  type="radio" name="animalito" value="6-Ran"  > 06 - Rana</label></li>
								<li><label class="L A" for="7"><input  id="7"  type="radio" name="animalito" value="7-Per"  > 07 - Perico</label></li>
								<li><label class="A"   for="8"><input  id="8"  type="radio" name="animalito" value="8-Rat"  > 08 - Raton</label></li>
								<li><label class="L A" for="9"><input  id="9"  type="radio" name="animalito" value="9-Agu"  > 09 - Aguila</label></li>
								<li><label class="A"   for="10"><input id="10" type="radio" name="animalito" value="10-Tig" > 10 - Tigre</label></li>
								<li><label class="A"   for="11"><input id="11" type="radio" name="animalito" value="11-Gat" > 11 - Gato</label></li>
								<li><label class="L A" for="12"><input id="12" type="radio" name="animalito" value="12-Cab" > 12 - Caballo</label></li>
								<li><label class="A"   for="13"><input id="13" type="radio" name="animalito" value="13-Mon" > 13 - Mono</label></li>
								<li><label class="L A" for="14"><input id="14" type="radio" name="animalito" value="14-Pal" > 14 - Paloma</label></li>
								<li><label class="A"   for="15"><input id="15" type="radio" name="animalito" value="15-Zor" > 15 - Zorro</label></li>
								<li><label class="L A" for="16"><input id="16" type="radio" name="animalito" value="16-Oso" > 16 - Oso</label></li>
								<li><label class="A"   for="17"><input id="17" type="radio" name="animalito" value="17-Pav" > 17 - Pavo</label></li>
								<li><label class="L A" for="18"><input id="18" type="radio" name="animalito" value="18-Bur" > 18 - Burro</label></li>
								<li><label class="L A" for="19"><input id="19" type="radio" name="animalito" value="19-Chi" > 19 - Chivo</label></li>							
								<li><label class="A"   for="20"><input id="20" type="radio" name="animalito" value="20-Coc" > 20 - Cochino</label></li>
								<li><label class="L A" for="21"><input id="21" type="radio" name="animalito" value="21-Gal" > 21 - Gallo</label></li>
								<li><label class="A"   for="22"><input id="22" type="radio" name="animalito" value="22-Cam" > 22 - Camello</label></li>
								<li><label class="L A" for="23"><input id="23" type="radio" name="animalito" value="23-Ceb" > 23 - Cebra</label></li>
								<li><label class="A"   for="24"><input id="24" type="radio" name="animalito" value="24-Igu" > 24 - Iguana</label></li>
								<li><label class="L A" for="25"><input id="25" type="radio" name="animalito" value="25-Gal" > 25 - Gallina</label></li>
								<li><label class="A"   for="26"><input id="26" type="radio" name="animalito" value="26-Vac" > 26 - Vaca</label></li>
								<li><label class="L A" for="27"><input id="27" type="radio" name="animalito" value="27-Per" > 27 - Perro</label></li>
								<li><label class="A"   for="28"><input id="28" type="radio" name="animalito" value="28-Zam" > 28 - Zamuro</label></li>
								<li><label class="A"   for="29"><input id="29" type="radio" name="animalito" value="29-Ele" > 29 - Elefante</label></li>
								<li><label class="L A" for="30"><input id="30" type="radio" name="animalito" value="30-Cai" > 30 - Caimán</label></li>
								<li><label class="A"   for="31"><input id="31" type="radio" name="animalito" value="31-Lap" > 31 - Lapa</label></li>
								<li><label class="L A" for="32"><input id="32" type="radio" name="animalito" value="32-Ard" > 32 - Ardilla</label></li>
								<li><label class="A"   for="33"><input id="33" type="radio" name="animalito" value="33-Pes" > 33 - Pescado</label></li>
								<li><label class="L A" for="34"><input id="34" type="radio" name="animalito" value="34-Ven" > 34 - Venado</label></li>
								<li><label class="A"   for="35"><input id="35" type="radio" name="animalito" value="35-Jir" > 35 - Jirafa</label></li>
								<li><label class="L A" for="36"><input id="36" type="radio" name="animalito" value="36-Cul" > 36 - Culebra</label></li>
							</ul>
						</div>
						<div class="animalitos">
							<ul id="Lanimalitos">								
								<li><label class="P PA" for="Pa1" ><input id="Pa1"  type="radio" name="pais" value="1-Ven"  > 01 - Venezuela</label></li>
								<li><label class="P PA" for="Pa2" ><input id="Pa2"  type="radio" name="pais" value="2-Chi"  > 02 - China</label></li>
								<li><label class="P PA" for="Pa3" ><input id="Pa3"  type="radio" name="pais" value="3-USA"  > 03 - USA</label></li>
								<li><label class="P PA" for="Pa4" ><input id="Pa4"  type="radio" name="pais" value="4-Ara"  > 04 - Arabia</label></li>
								<li><label class="P PA" for="Pa5" ><input id="Pa5"  type="radio" name="pais" value="5-Bra"  > 05 - Brasil</label></li>
								<li><label class="P PA" for="Pa6" ><input id="Pa6"  type="radio" name="pais" value="6-Col"  > 06 - Colombia</label></li>
								<li><label class="P PA" for="Pa7" ><input id="Pa7"  type="radio" name="pais" value="7-Jap"  > 07 - Japon</label></li>
								<li><label class="P PA" for="Pa8" ><input id="Pa8"  type="radio" name="pais" value="8-Ale"  > 08 - Alemania</label></li>
								<li><label class="P PA" for="Pa9" ><input id="Pa9"  type="radio" name="pais" value="9-Bol"  > 09 - Bolivia</label></li>
								<li><label class="P PA" for="Pa10"><input id="Pa10" type="radio" name="pais" value="10-Cub" > 10 - Cuba</label></li>
								<li><label class="P PA" for="Pa11"><input id="Pa11" type="radio" name="pais" value="11-Chi" > 11 - Chile</label></li>
								<li><label class="P PA" for="Pa12"><input id="Pa12" type="radio" name="pais" value="12-Cor" > 12 - Corea</label></li>
								<li><label class="P PA" for="Pa13"><input id="Pa13" type="radio" name="pais" value="13-Ita" > 13 - Italia</label></li>
								<li><label class="P PA" for="Pa14"><input id="Pa14" type="radio" name="pais" value="14-Afr" > 14 - Africa</label></li>
								<li><label class="P PA" for="Pa15"><input id="Pa15" type="radio" name="pais" value="15-Esp" > 15 - España</label></li>
								<li><label class="P PA" for="Pa16"><input id="Pa16" type="radio" name="pais" value="16-Mex" > 16 - Mexico</label></li>
								<li><label class="P PA" for="Pa17"><input id="Pa17" type="radio" name="pais" value="17-Jam" > 17 - Jamaica</label></li>
								<li><label class="P PA" for="Pa18"><input id="Pa18" type="radio" name="pais" value="18-Fra" > 18 - Francia</label></li>
								<li><label class="P PA" for="Pa19"><input id="Pa19" type="radio" name="pais" value="19-Egi" > 19 - Egipto</label></li>							
								<li><label class="P PA" for="Pa20"><input id="Pa20" type="radio" name="pais" value="20-Sue" > 20 - Suecia</label></li>
								<li><label class="P PA" for="Pa21"><input id="Pa21" type="radio" name="pais" value="21-Per" > 21 - Peru</label></li>
								<li><label class="P PA" for="Pa22"><input id="Pa22" type="radio" name="pais" value="22-Fil" > 22 - Filipina</label></li>
								<li><label class="P PA" for="Pa23"><input id="Pa23" type="radio" name="pais" value="23-Rus" > 23 - Rusia</label></li>
								<li><label class="P PA" for="Pa24"><input id="Pa24" type="radio" name="pais" value="24-Gre" > 24 - Grecia</label></li>
								<li><label class="P PA" for="Pa25"><input id="Pa25" type="radio" name="pais" value="25-Ing" > 25 - Inglaterra</label></li>
								<li><label class="P PA" for="Pa26"><input id="Pa26" type="radio" name="pais" value="26-Uru" > 26 - Uruguay</label></li>
								<li><label class="P PA" for="Pa27"><input id="Pa27" type="radio" name="pais" value="27-Tur" > 27 - Turquia</label></li>
								<li><label class="P PA" for="Pa28"><input id="Pa28" type="radio" name="pais" value="28-Can" > 28 - Canada</label></li>
								<li><label class="P PA" for="Pa29"><input id="Pa29" type="radio" name="pais" value="29-Ind" > 29 - India</label></li>
								<li><label class="P PA" for="Pa30"><input id="Pa30" type="radio" name="pais" value="30-Ecu" > 30 - Ecuador</label></li>
								<li><label class="P PA" for="Pa31"><input id="Pa31" type="radio" name="pais" value="31-Mar" > 31 - Marrueco</label></li>
								<li><label class="P PA" for="Pa32"><input id="Pa32" type="radio" name="pais" value="32-Arg" > 32 - Argentina</label></li>
								<li><label class="P PA" for="Pa33"><input id="Pa33" type="radio" name="pais" value="33-Por" > 33 - Portugal</label></li>
								<li><label class="P PA" for="Pa34"><input id="Pa34" type="radio" name="pais" value="34-Dom" > 34 - Dominicana</label></li>
								<li><label class="P PA" for="Pa35"><input id="Pa35" type="radio" name="pais" value="35-Hol" > 35 - Holanda</label></li>
								<li><label class="P PA" for="Pa36"><input id="Pa36" type="radio" name="pais" value="36-Pan" > 36 - Panama</label></li>
								<li><label class="P PA" for="Pa37"><input id="Pa37" type="radio" name="pais" value="37-Pue" > 37 - Puerto Rico</label></li>							
								<li><label class="P PA" for="Pa38"><input id="Pa38" type="radio" name="pais" value="38-Haw" > 38 - Hawuaii</label></li>
							</ul>
						</div>
					</form>						
					<div class="cajas">
						<div class="tablaL">
							<div class="fila">
								<h2 id="L">Resultados de LottoActivo</h2>
							</div>
							<div class="fila">
								<div class="columna">
									<h3>09:00</h3>
								</div>
								<div class="columna">
									<h3>10:00</h3>
								</div>
								<div class="columna">
									<h3>11:00</h3>
								</div>
								<div class="columna">
									<h3>12:00</h3>
								</div>
								<div class="columna">
									<h3>01:00</h3>
								</div>
								<div class="columna">
									<h3>03:00</h3>
								</div>
								<div class="columna">
									<h3>04:00</h3>
								</div>
								<div class="columna">
									<h3>05:00</h3>
								</div>
								<div class="columna">
									<h3>06:00</h3>
								</div>
								<div class="columna">
									<h3>07:00</h3>
								</div>
							</div>							
							<div class="fila">
								<?php
								while ($Resultado = mysqli_fetch_row($ResultadosL)){ 
									if ($Resultado[1] == 9) { $ResultL[9] = $Resultado[0];}
									if ($Resultado[1] == 10) { $ResultL[10] = $Resultado[0];}
									if ($Resultado[1] == 11) { $ResultL[11] = $Resultado[0];}
									if ($Resultado[1] == 12) { $ResultL[12] = $Resultado[0];}
									if ($Resultado[1] == 13) { $ResultL[13] = $Resultado[0];}
									if ($Resultado[1] == 15) { $ResultL[15] = $Resultado[0];}
									if ($Resultado[1] == 16) { $ResultL[16] = $Resultado[0];}
									if ($Resultado[1] == 17) { $ResultL[17] = $Resultado[0];}
									if ($Resultado[1] == 18) { $ResultL[18] = $Resultado[0];}
									if ($Resultado[1] == 19) { $ResultL[19] = $Resultado[0];}
								}
								?>
								<div class="columna">
									<h4><?php echo $ResultL[9]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultL[10]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultL[11]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultL[12]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultL[13]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultL[15]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultL[16]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultL[17]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultL[18]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultL[19]; ?></h4>
								</div>
							</div>							
						</div>
						<div class="tablaG">
							<div class="fila">
								<h2 id="G">Resultados de La Granjita</h2>
							</div>
							<div class="fila">
								<div class="columna">
									<h3>09:00</h3>
								</div>
								<div class="columna">
									<h3>10:00</h3>
								</div>
								<div class="columna">
									<h3>11:00</h3>
								</div>
								<div class="columna">
									<h3>12:00</h3>
								</div>
								<div class="columna">
									<h3>01:00</h3>
								</div>
								<div class="columna">
									<h3>02:00</h3>
								</div>
								<div class="columna">
									<h3>03:00</h3>
								</div>
								<div class="columna">
									<h3>04:00</h3>
								</div>
								<div class="columna">
									<h3>05:00</h3>
								</div>
								<div class="columna">
									<h3>06:00</h3>
								</div>
								<div class="columna">
									<h3>07:00</h3>
								</div>
							</div>							
							<div class="fila">
								<?php
								while ($Resultado = mysqli_fetch_row($ResultadosG)){ 
									if ($Resultado[1] == 9) { $ResultG[9] = $Resultado[0];}
									if ($Resultado[1] == 10) { $ResultG[10] = $Resultado[0];}
									if ($Resultado[1] == 11) { $ResultG[11] = $Resultado[0];}
									if ($Resultado[1] == 12) { $ResultG[12] = $Resultado[0];}
									if ($Resultado[1] == 13) { $ResultG[13] = $Resultado[0];}
									if ($Resultado[1] == 14) { $ResultG[14] = $Resultado[0];}
									if ($Resultado[1] == 15) { $ResultG[15] = $Resultado[0];}
									if ($Resultado[1] == 16) { $ResultG[16] = $Resultado[0];}
									if ($Resultado[1] == 17) { $ResultG[17] = $Resultado[0];}
									if ($Resultado[1] == 18) { $ResultG[18] = $Resultado[0];}
									if ($Resultado[1] == 19) { $ResultG[19] = $Resultado[0];}
								}
								?>
								<div class="columna">
									<h4><?php echo $ResultG[9]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultG[10]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultG[11]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultG[12]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultG[13]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultG[14]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultG[15]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultG[16]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultG[17]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultG[18]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultG[19]; ?></h4>
								</div>
							</div>							
						</div>
						<div class="tablaL">
							<div class="fila">
								<h2 id="L">Resultados de Los Paises</h2>
							</div>
							<div class="fila">								
								<div class="columna">
									<h3>10:00</h3>
								</div>
								<div class="columna">
									<h3>11:00</h3>
								</div>
								<div class="columna">
									<h3>12:00</h3>
								</div>
								<div class="columna">
									<h3>01:00</h3>
								</div>
								<div class="columna">
									<h3>02:00</h3>
								</div>
								<div class="columna">
									<h3>03:00</h3>
								</div>
								<div class="columna">
									<h3>04:00</h3>
								</div>
								<div class="columna">
									<h3>05:00</h3>
								</div>
								<div class="columna">
									<h3>06:00</h3>
								</div>
								<div class="columna">
									<h3>07:00</h3>
								</div>
							</div>							
							<div class="fila">
								<?php
								while ($Resultado = mysqli_fetch_row($ResultadosP)){									
									if ($Resultado[1] == 10) { $ResultP[10] = $Resultado[0];}
									if ($Resultado[1] == 11) { $ResultP[11] = $Resultado[0];}
									if ($Resultado[1] == 12) { $ResultP[12] = $Resultado[0];}
									if ($Resultado[1] == 13) { $ResultP[13] = $Resultado[0];}
									if ($Resultado[1] == 14) { $ResultP[14] = $Resultado[0];}
									if ($Resultado[1] == 15) { $ResultP[15] = $Resultado[0];}
									if ($Resultado[1] == 16) { $ResultP[16] = $Resultado[0];}
									if ($Resultado[1] == 17) { $ResultP[17] = $Resultado[0];}
									if ($Resultado[1] == 18) { $ResultP[18] = $Resultado[0];}
									if ($Resultado[1] == 19) { $ResultP[19] = $Resultado[0];}
								}
								?>
								<div class="columna">
									<h4><?php echo $ResultP[10]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultP[11]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultP[12]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultP[13]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultP[14]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultP[15]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultP[16]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultP[17]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultP[18]; ?></h4>
								</div>
								<div class="columna">
									<h4><?php echo $ResultP[19]; ?></h4>
								</div>
							</div>							
						</div>	
						<div class="tabla">
							<div class="fila">
								<h2>Datos Financieros</h2>
							</div>
							<div class="fila">
								<div class="columna1">
									<h3>Hora</h3>
								</div>
								<div class="columna1">
									<h3>Tickets</h3>
								</div>
								<div class="columnabs">
									<h3>Venta</h3>
								</div>
								<div class="columnabs">
									<h3>Premio</h3>
								</div>
								<div class="columnabs">
									<h3>Ganancia</h3>
								</div>
							</div>
							<?php 	
								while ($V = mysqli_fetch_row($VentaH)){
									$P = 0;
									while ($Dato = mysqli_fetch_row($MostrarP)){
										$T = 0;
										if ($V[1] == $Dato[2]){
											$P = $Dato[2];
											$H = ajustar_Hora($V[1]);
											$T = $Dato[0];
											$Venta = $V[0];
											$VentaT += $Venta;
											$Pagar = $Dato[1]*30;
											$PagarT += $Pagar;
											$Ganancia = $Venta - $Pagar;
											$GananciaT += $Ganancia; ?>
											<div class="fila">
												<div class="columna1">
													<h3><?php echo $H; ?>:00</h3>
												</div>
												<div class="columna1">
													<h3><?php echo $T; ?></h3>
												</div>
												<div class="columnabs">
													<h3><?php echo number_format($Venta, 0, ',', '.'); ?></h3>
												</div>
												<div class="columnabs">
													<h3><?php echo number_format($Pagar, 0, ',', '.'); ?></h3>
												</div>
												<div class="columnabs">
													<h3><?php echo number_format($Ganancia, 0, ',', '.'); ?></h3>
												</div>
											</div>
							<?php		}
									}
									mysqli_data_seek($MostrarP, 0); 
									if ($T == 0 && $V[1] != $P){
										$H = ajustar_Hora($V[1]);
										$T = 0;
										$Venta = $V[0];
										$VentaT += $Venta;
										$Pagar = 0;
										$Ganancia = $Venta - $Pagar;
										$GananciaT += $Ganancia; ?>
										<div class="fila">
											<div class="columna1">
												<h3><?php echo $H; ?>:00</h3>
											</div>
											<div class="columna1">
												<h3><?php echo $T; ?></h3>
											</div>
											<div class="columnabs">
												<h3><?php echo number_format($Venta, 0, ',', '.'); ?></h3>
											</div>
											<div class="columnabs">
												<h3><?php echo number_format($Pagar, 0, ',', '.'); ?></h3>
											</div>
											<div class="columnabs">
												<h3><?php echo number_format($Ganancia, 0, ',', '.'); ?></h3>
											</div>
										</div>
							<?php	}
								} ?>
							<div class="fila">
								<div class="columna2">
									<h3>TOTALES</h3>
								</div>
								<div class="columnabs">
									<h3><?php echo number_format($VentaT, 0, ',', '.'); ?></h3>
								</div>
								<div class="columnabs">
									<h3><?php echo number_format($PagarT, 0, ',', '.'); ?></h3>
								</div>
								<div class="columnabs">
									<h3><?php echo number_format($GananciaT, 0, ',', '.'); ?></h3>
								</div>
							</div>
						</div>		
					</div>
				</div>						
			</div>
        </main>
	</body>
</html>