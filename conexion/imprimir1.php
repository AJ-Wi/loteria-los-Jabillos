<?php 
date_default_timezone_set ('America/La_Paz');
$Ticket = isset($_POST['Ticket'])? $_POST['Ticket'] : null;
$Cliente = isset($_POST['cliente'])? $_POST['cliente'] : null;
$Total = isset($_POST['Total'])? $_POST['Total'] : null;
$Accion = isset($_POST['btnImprimir'])? $_POST['btnImprimir'] : null;
include('tickets.php');

$HoraCompra = date('h:i:s');
//$HoraCompra = '03:41:11';

if($Accion == 'Imprimir Ticket'){ 
	header("Location: imprimir.php?Ticket=".$Ticket."&cliente=".$Cliente );
}
if($Accion == 'Guardar Ticket'){ 
	marcar_Ticket($Ticket, $HoraCompra, $Cliente);
	header("Location: /index.php?Mante=".$Total );
}

?>