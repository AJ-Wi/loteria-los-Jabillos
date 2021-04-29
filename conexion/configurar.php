<?php
date_default_timezone_set ('America/La_Paz');
	include('../conexion/tickets.php');	
	
	$IDS = isset($_POST['id'])? $_POST['id'] : null;
	$LIMITES = isset($_POST['limite'])? $_POST['limite'] : null;
	$LimiteGeneral = isset($_POST['limiteTodos'])? $_POST['limiteTodos'] : null;
	$Mensaje = '';
	$i = 0;	
	
	if ($LimiteGeneral != null){
		$sql = "UPDATE animalitos SET limite='".$LimiteGeneral."'";
		mysqli_query(conexion(), $sql);
		$Mensaje = 'Limites Agregados';
	}else{
		if ($IDS != null){
			foreach ($IDS as $ID){
				$sql = "UPDATE animalitos SET limite='".$LIMITES[$i]."' WHERE animalito='".$ID."'";
				mysqli_query(conexion(), $sql);
				$i += 1;
			}
			$Mensaje = 'Limites Agregados';
		}
	}
	
	$Datos = generar_Lista();
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
		<link rel="stylesheet" href="/css/config.css">
	</head>
	<body>
        <main>
			<div class="principal">
				<div class="cabecera">
					<button id="atras" type="submit" onclick="window.location='/';" ><img src="/img/atras.png" alt="atras"></button>
					<h1>Agencia de Loteria Los Jabillos</h1>
				</div>				
				<div class="cuerpo">
					<form method="post" action="">
						<div class="fichas">
							<?php while ($Dato = mysqli_fetch_row($Datos)){	
								if ($Dato[3] == 'a'){
									$Imagen = "/img/animalitos/".$Dato[0].".png"; ?>
									<div class="ficha">							
											<img src="<?php echo $Imagen; ?>" alt="<?php echo $Dato[1]; ?>">
											<input type="hidden" name="id[]" value="<?php echo $Dato[1]; ?>" >
											<input class="texto" type="text" autocomplete="on" placeholder="Limite..." name="limite[]" value="<?php echo $Dato[2]; ?>" >
									</div>	
								<?php } } 
							mysqli_data_seek($Datos, 0); ?>
						</div>	
						<div class="fichas">
							<?php while ($Dato = mysqli_fetch_row($Datos)){	
								if ($Dato[3] == 'p'){
									$Imagen = "/img/paises/".$Dato[0].".jpg"; ?>
									<div class="ficha">												
											<img src="<?php echo $Imagen; ?>" alt="<?php echo $Dato[1]; ?>">
											<input type="hidden" name="id[]" value="<?php echo $Dato[1]; ?>" >
											<label><?php echo $Dato[1]; ?></label>
											<input class="texto" type="text" autocomplete="on" placeholder="Limite..." name="limite[]" value="<?php echo $Dato[2]; ?>" >
									</div>	
								<?php } } 
							mysqli_data_seek($Datos, 0); ?>
						</div>	
						<div class="boton">
							<input class="btn" type="submit" name="agregar" value="Agregar Limites">
							<input id="todos" class="texto" type="text" autocomplete="on" placeholder="Limite General..." name="limiteTodos" >
							<?php if ($Mensaje != ''){ ?>
								<h3><?php echo $Mensaje; ?></h3>
							<?php } ?>
						</div>
					</form>
				</div>						
			</div>
        </main>
	</body>
</html>