<?php	
date_default_timezone_set ('America/La_Paz');
require('conexion.php');
require('limites.php');
$animal = array("00" => "00-Bal", "0" => "0-Del","1" => "1-Car", "2" => "2-Tor","3" => "3-Cie", "4" => "4-Ala","5" => "5-Leo", "6" => "6-Ran","7" => "7-Per", "8" => "8-Rat",
"9" => "9-Agu", "10" => "10-Tig","11" => "11-Gat", "12" => "12-Cab","13" => "13-Mon", "14" => "14-Pal","15" => "15-Zor", "16" => "16-Oso","17" => "17-Pav", "18" => "18-Bur","19" => "19-Chi", 
"20" => "20-Coc","21" => "21-Gal", "22" => "22-Cam","23" => "23-Ceb", "24" => "24-Igu","25" => "25-Gal", "26" => "26-Vac","27" => "27-Per", "28" => "28-Zam","29" => "29-Ele", "30" => "30-Cai",
"31" => "31-Lap", "32" => "32-Ard","33" => "33-Pes", "34" => "34-Ven","35" => "35-Jir", "36" => "36-Cul");
$pais = array("falso", "1-Ven", "2-Chi", "3-Usa", "4-Ara", "5-Bra", "6-Col", "7-Jap", "8-Ale", "9-Bol", "10-Cub", "11-Chi", "12-Cor", "13-Ita", "14-Afr", "15-Esp", "16-Mex",
	"17-Jam", "18-Fra", "19-Egi", "20-Sue", "21-Per", "22-Fil", "23-Rus", "24-Gre", "25-Ing", "26-Uru", "27-Tur", "28-Can", "29-Ind", "30-Ecu", "31-Mar", "32-Arg", "33-Por", 
	"34-Dom", "35-Hol", "36-Pan", "37-Pue", "38-Haw");
$Item ='';
$Repetir = isset($_GET['repetir'])? $_GET['repetir'] : null;
$Animalitos = isset($_POST['animalitos'])? $_POST['animalitos'] : null;
$Paises = isset($_POST['paises'])? $_POST['paises'] : null;
$Horas = isset($_POST['sorteos'])? $_POST['sorteos'] : null;
$Apuesta = isset($_POST['apuesta'])? $_POST['apuesta'] : null;
$Sorteos = array();

$Ticket = contarTicket();
$Fecha = date('Y-m-d');

if ($Apuesta != null){	
	foreach ($Horas as $Hora) {	
		$Sorteos[$Hora] = "checked";	
		if (substr($Hora,0,1) == 'P'){
			$Animalitos = $Paises;
			$Item = $pais;			
		}else{
			$Item = $animal;
		}
		
		foreach ($Animalitos as $i) {			
			if ($i != ''){				
				$Jugada = contarJugada();
				$Datos = buscarTicket($Ticket);
				$Respuesta = chequear_Limites($Item[$i], $Apuesta, $Fecha, substr($Hora,1), substr($Hora,0,1), 'nuevo', 0);
				if ($Respuesta > 0){
					$nuevoM = '';
					$Juga = '';
					while ($Dato = mysqli_fetch_row($Datos)){
						if ($Dato[0] == $Item[$i]){
							if ($Dato[2] == substr($Hora,0,1)){
								$nuevoM = $Dato[1] + $Respuesta; $Juga = $Dato[4];
							}							
						}
					}
					if($nuevoM){
						actualizarJugada($Juga, $nuevoM);	
					}else{
						guardarJugada($Ticket, $Item[$i], $Respuesta, $Fecha, substr($Hora,1), $Jugada, substr($Hora,0,1));	
					}
				}
			}
		}
	}
	header("Location: ../index.php?tic=".$Ticket.'&sor='.serialize($Sorteos).'&mon='.$Apuesta);
}

if ($Repetir != null){	
	$Datos = buscarTicket($Repetir);
	while ($Dato = mysqli_fetch_row($Datos)){	
		$Jugada = contarJugada();
		if (date('i') <= 54) {
			if (date('H') < 9){
				$H = 9;
			}else{
				if($Dato[2] == 'L'){
					if (date('H') == 13){
						$H = date('H') + 2;
					}else{
						$H = date('H') + 1;
					}
				}else{
					$H = date('H') + 1;
				}					
			}
		}else{				
			$H = date('H') + 2;				
		}
		$Respuesta = chequear_Limites($Dato[0], $Dato[1], $Fecha, $H, $Dato[2], 'repetir', 0);
		if ($Respuesta > 0){			
			guardarJugada($Ticket, $Dato[0], $Respuesta, $Fecha, $H, $Jugada, $Dato[2]);
		}		
	}
	header("Location: ../index.php?tic=".$Ticket);
}

function guardarJugada($Tic, $Ani, $Apu, $Fec, $Hor, $Jug, $sor) {	
    $sql = "INSERT INTO tickets (ticket, animalito, apuesta, fecha, hora, jugada, sorteo) VALUES ('".$Tic."', '".$Ani."', '".$Apu."', '".$Fec."', '".$Hor."', '".$Jug."', '".$sor."')";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        return true;
    }
}

function actualizarJugada($Jug, $Apu) {
	$sql = "UPDATE tickets SET apuesta='".$Apu."' WHERE jugada='".$Jug."'";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        return true;
    }
}

function buscarTicket($Tic) {	
    $sql = "SELECT animalito, apuesta, sorteo, hora, jugada FROM tickets WHERE ticket='".$Tic."'";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        return $resultado;
    }
}

function contarTicket() {
    $sql = "SELECT max(ticket), impreso FROM tickets WHERE ticket= (SELECT MAX(ticket) FROM tickets)";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   $N = 0;
	   exit;
    }else{
		while ($Dato = mysqli_fetch_row($resultado)){			
			if ($Dato[1] == 0){
				$N = $Dato[0];
			}elseif ($Dato[1] == 1){
				$N = $Dato[0] + 1;
			}
		}        
    }
	return $N;
}

function contarJugada() {
    $sql = "SELECT MAX(jugada) FROM tickets";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return 0;
	   exit;
    }else{
		while ($Dato = mysqli_fetch_row($resultado)){
			$N = $Dato[0] + 1;
		}
        return $N;
    }
}

?>