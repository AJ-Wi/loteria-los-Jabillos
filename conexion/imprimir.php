<?php 
date_default_timezone_set ('America/La_Paz');
$Ticket = isset($_GET['Ticket'])? $_GET['Ticket'] : null;
$Cliente = isset($_GET['cliente'])? $_GET['cliente'] : null;
include('tickets.php');

$Jugadas = buscar_Ticket($Ticket);
$Fecha = date('Y-m-d');
$HoraCompra = date('h:i:s');
//$HoraCompra = '03:41:11';
$FechaP = '';
$Total = '';

$F = explode('-', $Fecha);
$FechaP = $F[2]."-".$F[1]."-".$F[0];

require __DIR__ . '/ticket/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
 
$nombre_impresora = "POS-58"; 
  
$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("Agencia Los Jabillos" . "\n");
$printer->text("Ticket: " .$Ticket. "\n");
$printer->text("Clave: " .rand(0,1000000000). "\n");
$printer->text("Fecha: " .$FechaP." ".$HoraCompra . "\n");
$printer->text("-------------------------" . "\n");
if ($Jugadas != false){
	$Total = 0;
	$Juego = '';
	$c = 8;
	$j = 0;
	$S = '';
	while ($Jugada = mysqli_fetch_row($Jugadas)){
		$Total += $Jugada[1];
		if ($c < $Jugada[2]) {
			$HoraA = ajustar_Hora($Jugada[2]);
			$S = $Jugada[4];
			if ($j == 1) { 
				$printer->text($Juego . "\n");
				$Juego = '';
				$j = 0;
			} 
			$printer->text("*** ".ajustar_Sorteo($Jugada[4]).$HoraA." ***" . "\n"); 
			$c = $Jugada[2];
		}	
		if ($Jugada[4] == $S){
			if ($j == 0) {
				$Juego = $Jugada[0]." ".$Jugada[1];
				$j = 1;
				continue;
			}
			if ($j == 1) {
				$Juego .= "  ".$Jugada[0]." ".$Jugada[1]; 
				$printer->text($Juego . "\n");
				$Juego = '';
				$j = 0;
			}
		}else{
			$HoraA = ajustar_Hora($Jugada[2]);
			$S = $Jugada[4];
			if ($j == 1) { 
				$printer->text($Juego . "\n");
				$Juego = '';
				$j = 0;
			} 
			$printer->text("*** ".ajustar_Sorteo($Jugada[4]).$HoraA." ***" . "\n");
			if ($j == 0) {
				$Juego = $Jugada[0]." ".$Jugada[1];
				$j = 1;
				continue;
			}
		}
	}
	if ($Juego != ''){
		$printer->text($Juego . "\n");
	}
}
$printer->text("-------------------------" . "\n");
$printer->text("Total Venta: " .number_format($Total, 0, ',', '.'). "\n");
$printer->text("SIN TICKET NO COBRA" . "\n");
$printer->text("CADUCA A LOS 3 DIAS" . "\n");

$printer->feed(2);

$printer->close();

marcar_Ticket($Ticket, $HoraCompra, $Cliente);

sleep(2);
header("Location: /index.php?Mante=".$Total );

?>