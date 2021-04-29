<?php

require('conexion.php');

function buscar_Ticket($Tic) {
    $sql = "SELECT animalito, apuesta, hora, jugada, sorteo, fecha, horacompra FROM tickets WHERE ticket='".$Tic."' ORDER BY hora, sorteo, CAST( ( LEFT( animalito, INSTR( animalito, '-' ) -1 ) ) AS UNSIGNED)";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($resultado) == 0){
            return false;
            exit;
        }else{
            return $resultado;
        }
    }
}

function buscar_Premiado($Tic) {
    $sql = "SELECT animalito, apuesta, hora, jugada, pagado, sorteo FROM tickets WHERE ticket='".$Tic."' AND premiado=true ORDER BY hora, sorteo";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($resultado) == 0){
            return false;
            exit;
        }else{
            return $resultado;
        }
    }
}

function buscar_Tic($Tic) {
    $sql = "SELECT animalito, apuesta, hora, jugada, pagado, sorteo, fecha, horacompra, premiado FROM tickets WHERE ticket='".$Tic."' ORDER BY hora, sorteo, CAST( ( LEFT( animalito, INSTR( animalito, '-' ) -1 ) ) AS UNSIGNED)";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($resultado) == 0){
            return false;
            exit;
        }else{
            return $resultado;
        }
    }
}

function buscar_Todos_cuenta($F) {
    $sql = "SELECT cliente FROM tickets WHERE fecha='".$F."' group by cliente";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($resultado) == 0){
            return false;
            exit;
        }else{
            return $resultado;
        }
    }
}

function buscar_cuenta($C, $F) {
    $sql = "SELECT hora, ticket, apuesta, premiado FROM tickets WHERE cliente='".$C."' AND fecha='".$F."' ORDER BY hora";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($resultado) == 0){
            return false;
            exit;
        }else{
            return $resultado;
        }
    }
}

function Premiados_dia($F) {
    $sql = "SELECT ticket, apuesta, pagado FROM tickets WHERE fecha='".$F."' AND premiado=true ORDER BY hora";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($resultado) == 0){
            return false;
            exit;
        }else{
            return $resultado;
        }
    }
}

function buscar_todos_Premiado($Fec) {
    $sql = "SELECT COUNT(ticket), SUM(apuesta), hora FROM tickets WHERE fecha='".$Fec."' AND premiado=true GROUP BY hora ORDER BY hora";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($resultado) == 0){
            return false;
            exit;
        }else{
            return $resultado;
        }
    }
}

function ventas_por_pais($Fec) {
    $sql = "SELECT animalito, SUM(apuesta), hora FROM tickets WHERE fecha='".$Fec."' AND hora='".$Hor."' AND sorteo='P' GROUP BY animalito, hora ORDER BY hora, animalito";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($resultado) == 0){
            return false;
            exit;
        }else{
            return $resultado;
        }
    }
}

function venta_Horas($Fec) {
    $sql = "SELECT SUM(apuesta), hora FROM tickets WHERE fecha='".$Fec."' GROUP BY hora ORDER BY hora";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($resultado) == 0){
            return false;
            exit;
        }else{
            return $resultado;
        }
    }
}

function generar_Lista() {
    $sql = "SELECT * FROM animalitos";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($resultado) == 0){
            return false;
            exit;
        }else{
            return $resultado;
        }
    }
}

function chequear_Limites($Fec) {	
	$sql = "SELECT animalito, SUM(apuesta), hora, sorteo FROM tickets WHERE fecha='".$Fec."' GROUP BY animalito, hora, sorteo ORDER BY animalito, sorteo";
    $sql1 = "SELECT id, animalito, limite FROM animalitos";
	$resultado = '';
	$cont = 0;
	
    if (!$estatus = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }
	
	if (!$limites = mysqli_query(conexion(), $sql1)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($limites) == 0){
            return false;
            exit;
        }
    }
	
	while ($limite = mysqli_fetch_row($limites)){
		$Animalito = $limite[0].'-'.substr($limite[1], 0, 3);
		while ($estado = mysqli_fetch_row($estatus)){
			if ($estado[0] == $Animalito) {					
				$Dif = $limite[2] - $estado[1];
				if ($cont >= 1){
					$resultado .= '|';
				}
				$resultado .= $estado[0].','.$estado[3].$estado[2].','.$Dif;
				$cont += 1;
			}
		}
		mysqli_data_seek($estatus, 0);
	}
	return $resultado;
}

function limites_Generales() {	
    $sql = "SELECT id, animalito, limite FROM animalitos";
	$resultado = '';
	$cont = 0;
	
	if (!$limites = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($limites) == 0){
            return false;
            exit;
        }
    }
	
	while ($limite = mysqli_fetch_row($limites)){
		$Animalito = $limite[0].'-'.substr($limite[1], 0, 3);
		if ($cont >= 1){
			$resultado .= '|';
		}
		$resultado .= $Animalito.','.$limite[2];
		$cont += 1;
	}
	return $resultado;
}

function marcar_Ticket($Tic, $HorC, $cliente) {
	$sql = "UPDATE tickets SET impreso=true, horacompra='".$HorC."', cliente='".$cliente."' WHERE ticket='".$Tic."'";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        return true;
    }
}

function transferir_Ticket($Tic, $cliente) {
	$sql = "UPDATE tickets SET cliente='".$cliente."' WHERE ticket='".$Tic."'";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        return true;
    }
}

function resultados($Fec, $Sor) {
	$sql = "SELECT * FROM resultados WHERE fecha='".$Fec."' AND sorteo='".$Sor."'";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        if (mysqli_num_rows($resultado) == 0){
            return false;
            exit;
        }else{
            return $resultado;
        }
    }
}

function ajustar_Hora($Hor) {
	if ($Hor == 9){$result = $Hor;}
	if ($Hor == 10){$result = $Hor;}
	if ($Hor == 11){$result = $Hor;}
	if ($Hor == 12){$result = $Hor;}
	if ($Hor == 13){$result = 1;}
	if ($Hor == 14){$result = 2;}
	if ($Hor == 15){$result = 3;}
	if ($Hor == 16){$result = 4;}
	if ($Hor == 17){$result = 5;}
	if ($Hor == 18){$result = 6;}
	if ($Hor == 19){$result = 7;}
	return $result;
}

function ajustar_Sorteo($Sor) {
	if ($Sor == 'L'){$result = 'Lotto Activo ';}
	if ($Sor == 'G'){$result = 'La Granjita ';}
	if ($Sor == 'P'){$result = 'Los Paises ';}
	return $result;
}

?>