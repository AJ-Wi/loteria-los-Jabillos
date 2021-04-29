<?php 
$Ticket = isset($_GET['Ticket'])? $_GET['Ticket'] : null;
require('conexion.php');

if (eliminar_Ticket($Ticket)) {
	header("Location: /index.php?msg=true");
}else{
	header("Location: /index.php?msg=false");
}

function eliminar_Ticket($Tic) {
	$sql = "DELETE FROM tickets WHERE ticket='".$Tic."'";
    if (!$resultado = mysqli_query(conexion(), $sql)){
	   return false;
	   exit;
    }else{
        return true;
    }
}

?>