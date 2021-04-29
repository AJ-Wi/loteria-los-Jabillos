<?php
date_default_timezone_set ('America/La_Paz');
	include('../conexion/tickets.php');		
	$Ticket = isset($_POST['ticket'])? $_POST['ticket'] : null;
	$Fechas = isset($_POST['fechas'])? $_POST['fechas'] : null;
	$BTicket = isset($_POST['Bticket'])? $_POST['Bticket'] : null;
	$Ver = isset($_POST['ver'])? $_POST['ver'] : null;
	$Total = '';
	$Pre = '';
	$Tic = '';
	$HoraCompra = date('d-m-Y h:i:s');
		
	if (isset($_REQUEST['pagar1'])){
		$sql = "UPDATE tickets SET pagado=true WHERE ticket='".$Ticket."'";
		mysqli_query(conexion(), $sql);
	}

	if ($Ticket != null){
		$Jugadas = buscar_Premiado($Ticket);
		$Tic = $Ticket;
	}
	
	if ($BTicket != null){
		$Jugadas = buscar_Tic($BTicket);
		$Tic = $BTicket;
		while ($Jugada = mysqli_fetch_row($Jugadas)){
			$F = explode('-', $Jugada[6]);
			$FechaP = $F[2]."-".$F[1]."-".$F[0];
			$HoraCompra = $FechaP.' '.$Jugada[7];
		}
		mysqli_data_seek($Jugadas, 0);		
	}
	
	if ($Fechas != null){
		$Fecha = $Fechas;
	}else{
		$Fecha = date('Y-m-d');
	}
	$Premiados = Premiados_dia($Fecha);
	
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
		<link rel="stylesheet" href="/css/pagar.css">
		<script src="/js/checked.js"></script>
	</head>
	<body>
        <main>
			<div class="principal">
				<div class="cabecera">
					<button id="atras" type="submit" onclick="window.location='/';" ><img src="/img/atras.png" alt="atras"></button>
					<h1>Agencia de Loteria Los Jabillos</h1>
				</div>				
				<div class="cuerpo">
					<div class="agregar">
						<form id="buscarP" method="post" action="">
							<div class="apuesta">
								<input id="apu" onKeyUp="saltar(event, 'buscarP')" class="texto" type="text" autocomplete="on" placeholder="Ingrese Ticket..." name="ticket" >
							</div>
							<input class="boton" type="submit" name="buscar" value="Buscar Ticket">
						</form>
						<form method="post" action="">
							<input type="hidden" name="ticket" value="<?php echo $Tic; ?>">
							<input id="pag" class="boton" type="submit" name="pagar1" value="Pagar Ticket">
						</form>
						<form id="buscarF" method="post" action="">
							<div class="cajaF">
								<input id="fecha" onKeyUp="saltar(event, 'buscarF')"  type="date" name="fechas">
							</div>
							<input id="agre2" class="boton" type="submit" name="agregar" value="Buscar por Fecha">	
						</form>	<br/>
						<form id="buscarT" method="post" action="">
							<input id="BT" type="hidden" name="Bticket" value="">	
							<input type="hidden" name="ver" value="true">
						</form>
					</div>
					<div class="imprimir">
						<div class="previo">
							<div class="ticket">
								<?php 
									$pago = false;
									while ($Jugada = mysqli_fetch_row($Jugadas)){
										if ($Jugada[4] == true){
											$pago = true;
										}
									}
									mysqli_data_seek($Jugadas, 0);
									if ($pago == true){?>
										<img id="imgP" src="/img/pagado.png" alt="pago">
								<?php } ?>
								<h4>Agencia Los Jabillos</h4>
								<h4>Ticket: <?php echo $Tic; ?></h4>
								<h4>Fecha: <?php echo $HoraCompra; ?></h4>
								<h4>------------------------------------</h4>
								<?php
									if ($Jugadas != false){	
										$Juego = '';
										$c = 8;
										$j = 0;
										$S = '';
										while ($Jugada = mysqli_fetch_row($Jugadas)){
											$Total += $Jugada[1];
											if ($Jugada[8]){
												$Pre += $Jugada[1];
											}
											if ($c < $Jugada[2]) {
												$HoraA = ajustar_Hora($Jugada[2]);
												$S = $Jugada[5];
												if ($j == 1) { ?>
													<h4><?php echo $Juego; ?></h4>
								<?php				$Juego = '';
													$j = 0;
												} ?>
												<h4>*** <?php echo ajustar_Sorteo($Jugada[5]).$HoraA; ?> ***</h4>
								<?php			$c = $Jugada[2];
											}	
											if ($Jugada[5] == $S){
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
												$S = $Jugada[5];
												if ($j == 1) { ?>
													<h4><?php echo $Juego; ?></h4>
								<?php				$Juego = '';
													$j = 0;
												} ?>
												<h4>*** <?php echo ajustar_Sorteo($Jugada[5]).$HoraA; ?> ***</h4>
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
										if ($Ver == false){$TotalPagar = $Total * 30; $Mensaje = "Total a Pagar";}else{$TotalPagar = $Pre * 30; $Mensaje = "Total Premio";}
									}else{
										$Mensaje = "Ticket NO Premiado";
									}									
								?>
								<h4>------------------------------------</h4>
								<h4>Total Venta: <?php echo number_format($Total, 0, ',', '.'); ?></h4>
								<h4>SIN TICKET NO COBRA</h4>
								<h4>CADUCA A LOS 3 DIAS</h4>
							</div>
						</div>
					</div>
					<div class="montopagar">
						<h2><?php echo $Mensaje; ?></h2>
						<?php if ($TotalPagar != 0) { ?>
						<h2><?php echo number_format($TotalPagar, 0, ',', '.'); ?></h2>
						<?php } ?>	
					<br/>	
					<div class="tabla">
							<div class="fila">
								<h2>Todos los Ganadores</h2>
							</div>
							<div class="fila">
								<div class="columna1">
									<h3>Tickets</h3>
								</div>
								<div class="columnabs">
									<h3>Monto</h3>
								</div>
								<div class="columna1">
									<h3>Estado</h3>
								</div>
							</div>
							<?php 	
								while ($Premiado = mysqli_fetch_row($Premiados)){
									$P = $Premiado[1]*30;
									if ($Premiado[2] == true){$E = 'Pagado';}else{$E = '';} ?>
									<div class="fila">
										<div class="columna1">
											<h3 class="repe" onclick="mostrar_Ticket('<?php echo $Premiado[0]; ?>')"><?php echo $Premiado[0]; ?></h3>
										</div>
										<div class="columnabs">
											<h3><?php echo number_format($P, 0, ',', '.'); ?></h3>
										</div>
										<div class="columna1">
											<h3><?php echo $E; ?></h3>
										</div>
									</div>
							<?php	} ?>
						</div>
					</div>						
				</div>					
			</div>
        </main>
	</body>
</html>