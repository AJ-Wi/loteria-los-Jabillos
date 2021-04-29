<?php
date_default_timezone_set ('America/La_Paz');
	include('../conexion/tickets.php');	
	$BTicket = isset($_POST['Bticket'])? $_POST['Bticket'] : null;
	$PTicket = isset($_POST['Pticket'])? $_POST['Pticket'] : null;
	$TTicket = isset($_POST['Tticket'])? $_POST['Tticket'] : null;	
	$Cli = isset($_POST['cli'])? $_POST['cli'] : null;
	$ClientG = isset($_GET['client'])? $_GET['client'] : null;
	$ClientP = isset($_POST['client'])? $_POST['client'] : null;
	$FechaP = isset($_POST['fechas'])? $_POST['fechas'] : null;
	$FechaG = isset($_GET['fechas'])? $_GET['fechas'] : null;
	if ($ClientG){$Client = $ClientG;}else{$Client = $ClientP;}	 
	if ($FechaP){$Fechas = $FechaP;}else{$Fechas = $FechaG;}	
	$H = '';
	$T = '';
	$M = '';
	$P = '';
	$N = 0;
	$Z = array();
	$Ver = false;
	$Total = '';
	$Pre = '';
	$Tic = '';
	$T1 = 0;
	$T2 = 0;
	$Dif = 0;
	$Clave = 0;
	$HoraCompra = date('d-m-Y h:i:s');
	
	if ($Fechas != null){
		$Fecha = $Fechas;
	}else{
		$Fecha = date('Y-m-d');
	}
	
	if ($TTicket != null){
		transferir_Ticket($TTicket, $Cli);
	}
	
	$Clientes = buscar_Todos_cuenta($Fecha);
	
	if ($Client) {
		$C = buscar_cuenta($Client, $Fecha);		
		while ($C1 = mysqli_fetch_row($C)){		
			if ($T == $C1[1]){				
				$H = $C1[0];
				$M += $C1[2];
				if ($C1[3]){
					$P += $C1[2]*30;
				}
			}else{
				if ($T == '') {					
					$H = $C1[0];
					$T = $C1[1];
					$M = $C1[2];
					if ($C1[3]){
						$P = $C1[2]*30;
					}					
				}else{
					$Z[$N][0] = $H;
					$Z[$N][1] = $T;
					$Z[$N][2] = $M;
					$Z[$N][3] = $P;
					$N += 1;
					$H = $C1[0];
					$T = $C1[1];
					$M = $C1[2];
					$P = '';
					if ($C1[3]){
						$P = $C1[2]*30;
					}
				}
			}
		}
		if (!$Z[$N][0]){
			$Z[$N][0] = $H;
			$Z[$N][1] = $T;
			$Z[$N][2] = $M;
			$Z[$N][3] = $P;
		}
	}
	
	if ($PTicket != null){
		$sql = "UPDATE tickets SET pagado=true WHERE ticket='".$PTicket."'";
		mysqli_query(conexion(), $sql);
	}
	
	if ($BTicket != null){
		$Jugadas = buscar_Tic($BTicket);
		$Tic = $BTicket;
		while ($Jugada = mysqli_fetch_row($Jugadas)){
			$F = explode('-', $Jugada[6]);
			$FechaP = $F[2]."-".$F[1]."-".$F[0];
			$HoraCompra = $FechaP.' '.$Jugada[7];
		}
		$Clave = rand(0,1000000000);
		mysqli_data_seek($Jugadas, 0);		
	}
	
	if (isset($_REQUEST['ver'])){
		$Ver = true;
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
    	<link rel="shortcut icon" href="/img/icon/jabillo.ico">
		<link rel="stylesheet" href="/css/estilos.css">
		<link rel="stylesheet" href="/css/cuentas.css">
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
						<form method="post" action="">
							<div class="seleccion">
								<select class="dato" name="cliente" onChange="window.location='cuentas.php?client=' + this.value<?php echo " + '&fechas=".$Fecha."'"; ?>;" required>
									<option value="">Seleccione al Cliente</option>
									<?php while ($Cliente = mysqli_fetch_row($Clientes)){ 
									if (!$Cliente[0]){continue;}?>
									<option value="<?php echo $Cliente[0]; ?>"><?php echo $Cliente[0]; ?></option>
									<?php } ?>
								</select>
                            </div>
						</form><br/>
						<form id="buscarF" method="post" action="">
							<div class="cajaF">
								<input id="fecha" type="date" name="fechas">
							</div>
							<input type="hidden" name="cliente" value="<?php echo $Client; ?>">
							<input id="agre2" class="boton" type="submit" name="agregar" value="Buscar por Fecha">	
						</form><br/>
						<form id="buscarT" method="post" action="">
							<input id="BT" type="hidden" name="Bticket" value="">							
						</form>
						<input class="boton" type="button" value="Repetir Ticket" onclick="window.location='agregar_jugada.php?repetir=<?php echo $Tic; ?>';"><br/><br/>
						<form method="post" action="">
							<input type="hidden" name="Tticket" value="<?php echo $Tic; ?>">
							<div class="apuesta">
								<input class="texto" type="text" autocomplete="on" placeholder="Ingrese cliente..." name="cli" >
							</div>
							<input class="boton" type="submit" value="Transferir Ticket" name="btnT">
						</form><br/>
						<form id="pagarT" method="post" action="">
							<input id="PT" type="hidden" name="Pticket" value="<?php echo $Tic; ?>">	
							<input id="pag" class="boton" type="submit" value="Pagar Ticket">
						</form><br/>
						<form method="post" action="imprimir2.php">
							<input type="hidden" name="Ticket" value="<?php echo $Tic; ?>">	
							<input type="hidden" name="cliente" value="<?php echo $Client; ?>">
							<input type="hidden" name="fecha" value="<?php echo $Fecha; ?>">
							<input class="boton" type="submit" value="Imprimir Ticket">
						</form>
					</div>
					<div class="imprimir">
						<div class="previo">
							<div class="ticket">
								<h4>Agencia Los Jabillos</h4>
								<h4>Ticket: <?php echo $Tic; ?></h4>
								<h4>Clave: <?php echo $Clave; ?></h4>
								<h4>Fecha: <?php echo $HoraCompra; ?></h4>
								<h4>------------------------------------</h4>
								<?php 
									if ($Jugadas != false){	
										$Juego = '';
										$pago = false;
										$c = 8;
										$j = 0;
										$S = '';
										while ($Jugada = mysqli_fetch_row($Jugadas)){
											$Total += $Jugada[1];
											if ($Jugada[8] == true){
												$Pre += $Jugada[1];
											}
											if ($Jugada[4] == true){
												$pago = true;
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
											<h4><?php echo $Juego;}} ?></h4>
								<h4>------------------------------------</h4>
								<h4>Total Venta: <?php echo number_format($Total, 0, ',', '.'); ?></h4>
								<h4>SIN TICKET NO COBRA</h4>
								<h4>CADUCA A LOS 3 DIAS</h4>
							</div>
						</div>
					</div>
					<div class="montopagar">	
						<div class="tabla">
							<div class="fila">
								<h2>Estado de Cuenta de <?php echo $Client; ?></h2>
							</div>
							<div class="fila">
								<div class="columna1">
									<h3>Hora</h3>
								</div>
								<div class="columna1">
									<h3>Tickets</h3>
								</div>
								<div class="columnabs">
									<h3>Monto</h3>
								</div>
								<div class="columnabs">
									<h3>Premio</h3>
								</div>
							</div>
							<?php 	
								foreach ($Z as $Z1) { ?>
									<div class="fila">
										<div class="columna1">
											<h3><?php echo ajustar_Hora($Z1[0]); ?></h3>
										</div>
										<div class="columna1">
											<h3 class="repe" onclick="mostrar_Ticket('<?php echo $Z1[1]; ?>')" ><?php echo $Z1[1]; ?></h3>
										</div>
										<div class="columnabs">
											<h3><?php echo number_format($Z1[2], 0, ',', '.'); $T1 += $Z1[2]; ?></h3>
										</div>
										<div class="columnabs">
											<h3><?php echo number_format($Z1[3], 0, ',', '.'); $T2 += $Z1[3]; ?></h3>
										</div>
									</div>
							<?php } ?>
							<div class="fila">
								<div class="columnaTotal">
									<h3>Totales</h3>
								</div>
								<div class="columnabs">
									<h3><?php echo number_format($T1, 0, ',', '.'); ?></h3>
								</div>
								<div class="columnabs">
									<h3><?php echo number_format($T2, 0, ',', '.'); $Dif = $T2 - $T1; ?></h3>
								</div>
							</div>
							<div class="fila">
								<div class="columnaTotal">
									<h3>Diferencia</h3>
								</div>
								<div class="columnaDif">
									<h3><?php echo number_format($Dif, 0, ',', '.'); ?></h3>
								</div>
							</div>
						</div>
					</div>						
				</div>					
			</div>
        </main>
	</body>
</html>