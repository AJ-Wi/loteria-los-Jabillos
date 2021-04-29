<?php
date_default_timezone_set ('America/La_Paz');
	include('../conexion/tickets.php');	
	
	$Datos = ventas_por_pais(date('Y-m-d'));

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
					<button id="atras" type="submit" onclick="window.location='/conexion/resultados.php';" ><img src="/img/atras.png" alt="atras"></button>
					<h1>Agencia de Loteria Los Jabillos</h1>
				</div>				
				<div class="cuerpo">
					<form method="post" action="">	
						<div class="fichas">
							<?php while ($Dato = mysqli_fetch_row($Datos)){
									$img = explode('-', $Dato[0]);
									$Imagen = "/img/paises/".$img[0].".jpg"; ?>
									<div class="ficha">												
											<img src="<?php echo $Imagen; ?>" alt="<?php echo $Dato[0]; ?>">
											<input type="hidden" name="id[]" value="<?php echo $Dato[0]; ?>" >
											<label class="texto" ><?php echo $Dato[0].' '.$Dato[2] ; ?></label>
											<label class="texto" ><?php echo $Dato[1]; ?></label>
									</div>	
								<?php } ?>
						</div>
					</form>
				</div>						
			</div>
        </main>
	</body>
</html>