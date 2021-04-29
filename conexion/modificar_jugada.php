<?php	
date_default_timezone_set ('America/La_Paz');
require('conexion.php');
require('limites.php');
$J = isset($_GET['jugada'])? $_GET['jugada'] : null;
$Ticket = isset($_GET['Ticket'])? $_GET['Ticket'] : null;
$Apuesta = isset($_GET['nuevovalor'])? $_GET['nuevovalor'] : null;
$Opcion = isset($_GET['opcion'])? $_GET['opcion'] : null;
$Sorteos = isset($_GET['sorteos'])? $_GET['sorteos'] : null;
$Monto = isset($_GET['monto'])? $_GET['monto'] : null;
$Fecha = date('Y-m-d');
$Sorteo = array();

$Jugadas = explode('|', $J);
$Sort = explode('|', $Sorteos);
foreach ($Sort as $Sorte) {
	$Sorteo[$Sorte] = "checked";
}

if ($Opcion == 'eliminar'){
	foreach ($Jugadas as $Jugada) {
		$Jug = explode(',', $Jugada);
		eliminar_Jugada($Jug[0]);
	}
}

if ($Opcion == 'modificar'){
	foreach ($Jugadas as $Jugada) {
		$Jug = explode(',', $Jugada);
		$Respuesta = chequear_Limites($Jug[1], $Jug[3], $Fecha, substr($Jug[2],1), substr($Jug[2],0,1), 'modificar', $Apuesta);
		if ($Respuesta > 0){
			modificar_Jugada($Jug[0], $Respuesta);
		}
	}
}

header("Location: /?tic=".$Ticket.'&sor='.serialize($Sorteo).'&mon='.$Monto );

function eliminar_Jugada($Jug) {
	$sql = "DELETE FROM tickets WHERE jugada='".$Jug."'";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        return true;
    }
}

function modificar_Jugada($Jug, $Apu) {
	$sql = "UPDATE tickets SET apuesta='".$Apu."' WHERE jugada='".$Jug."'";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        return true;
    }
}

?>