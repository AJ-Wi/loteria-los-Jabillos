<?php	

function chequear_Limites($Ani, $Apu, $Fec, $Hor, $Sor, $Mensaje, $Nval) {	
	$sqlEstado = "SELECT animalito, SUM(apuesta), hora, sorteo FROM tickets WHERE fecha='".$Fec."' GROUP BY animalito, hora, sorteo ORDER BY animalito, sorteo";
    $sqlLimite = "SELECT id, animalito, limite FROM animalitos";
	$S1 = $Sor.$Hor;
	$Estados = array();
	$resultado = '';
	$Nuevo = true;
	$Encontrado = false;
	$cont = 0;

    if (!$estatus = mysqli_query(conexion(), $sqlEstado)){		
	   return 'Error';
	   exit;
	}
	
	if (!$limites = mysqli_query(conexion(), $sqlLimite)){
	   return 'Error';
	   exit;
    }
	
	while ($estado = mysqli_fetch_row($estatus)){	
		if ($estado[0] == $Ani) {
			$S2 = $estado[3].$estado[2];			
			if ($S1 == $S2){
				while ($limite = mysqli_fetch_row($limites)){
					$Animalito = $limite[0].'-'.substr($limite[1], 0, 3);
					if ($Animalito == $Ani) {
						$Dif = $limite[2] - $estado[1];
						if ($Mensaje == 'modificar'){$L = $Dif + $Apu; $Valor = $Nval;}else{$L = $Dif; $Valor = $Apu;}
						if ($L < $Valor) {
							$resultado = $L;
						}else{
							$resultado = $Valor;
						}
						$Encontrado = true;
					}
				}
			}
		}
	}
	
	if ($Encontrado == false) {		
		while ($limite = mysqli_fetch_row($limites)){			
			$Animalito = $limite[0].'-'.substr($limite[1], 0, 3);
			if ($Animalito == $Ani) {
				$L = $limite[2];
				if ($Mensaje == 'modificar'){$Valor = $Nval;}else{$Valor = $Apu;}
				if ($L < $Valor) {
					$resultado = $L;
				}else{
					$resultado = $Valor;
				}
				$Encontrado = true;
			}
		}
	}

	return $resultado;
}

?>