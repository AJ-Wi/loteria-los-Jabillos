setInterval(deshabilitarHoras,1000);

function chequearLimite(monto, tipo){	
	var animalitos = ["00-Bal", "0-Del", "1-Car", "2-Tor", "3-Cie", "4-Ala", "5-Leo", "6-Ran", "7-Per", "8-Rat", "9-Agu", "10-Tig", "11-Gat", "12-Cab", "13-Mon", "14-Pal", "15-Zor", 
	"16-Oso", "17-Pav", "18-Bur", "19-Chi", "20-Coc", "21-Gal", "22-Cam", "23-Ceb", "24-Igu", "25-Gal", "26-Vac", "27-Per", "28-Zam", "29-Ele", "30-Cai", "31-Lap", "32-Ard", "33-Pes", 
	"34-Ven", "35-Jir", "36-Cul"];
	var paises = ["falso", "1-Ven", "2-Chi", "3-Usa", "4-Ara", "5-Bra", "6-Col", "7-Jap", "8-Ale", "9-Bol", "10-Cub", "11-Chi", "12-Cor", "13-Ita", "14-Afr", "15-Esp", "16-Mex",
	"17-Jam", "18-Fra", "19-Egi", "20-Sue", "21-Per", "22-Fil", "23-Rus", "24-Gre", "25-Ing", "26-Uru", "27-Tur", "28-Can", "29-Ind", "30-Ecu", "31-Mar", "32-Arg", "33-Por", 
	"34-Dom", "35-Hol", "36-Pan", "37-Pue", "38-Haw"];
	var Limites = document.getElementById('Est').value.split("|");
	var Limite_G = document.getElementById('Lim').value.split("|");
	var Num = document.getElementById('num').value;
	var Mensaje = "";
	var Estado = "";
	var Animal = [];
	var Sorteos = [];
	var Sorteo = "";
	var hor = "";
	var N = 0;
	var S = 0;
	var cont = 0;
	var J = false;
	var encontrado = false;
	
	if (tipo == 'nuevo'){
		$("input[name='sorteos[]']").each(function() {
			if ($(this).prop('checked')){
				Sorteos[cont] = $(this).val();
				if ($(this).val().substring(0, 1) == 'P'){J = true;}				
				cont++;
			}
		});
		
		cont = 0;
		
		if (J == false){
			$("input[name='animalitos[]']").each(function() {
				if ($(this).prop('checked')){
					if ($(this).val() == 00){N = 0;}else{N = parseInt($(this).val()) + 1;}
					Animal[cont] = animalitos[N];					
					cont++;
				}				
			});
			
		}
		
		if (J == true){
			$("input[name='paises[]']").each(function() {
				if ($(this).prop('checked')){
					N = parseInt($(this).val());
					Animal[cont] = paises[N];
					cont++;
				}				
			});
			
		}		
		
		Animal.forEach(function(Ani){			
			if (Ani == 00){N = 0;}else{N = parseInt(Ani) + 1;}
			var A = animalitos[N];
			Limites.forEach(function(Limite) {					
				Estado = Limite.split(",");
				if (Estado[0] == A){
					Sorteos.forEach(function(Sorteo) {	
						if (Estado[1] == Sorteo){
							if (parseInt(Estado[2]) < monto){
								Mensaje += 'Limite Superado: ' + A +' solo vender por: '+ Estado[2] +'\n';
							}
							encontrado = true;
						}					
					});
				}
			});
			if (encontrado == false){
				Limite_G.forEach(function(Lgeneral){
					General = Lgeneral.split(",");
					if (General[0] == A){
						if (parseInt(General[1]) < monto){
							Mensaje += 'Limite Superado: ' + A +' solo vender por: '+ Estado[2] +'\n';
						}
					}
				});				
			}
		});			
	}
	
	if (tipo == 'modificar'){
		$("input[name='jugada[]']").each(function() {
			if ($(this).prop('checked')){
				Animal[cont] = $(this).val();
				cont++;
			}				
		});
		Animal.forEach(function(Ani){
			var A = Ani.split(",");
			Limites.forEach(function(Limite) {
				Estado = Limite.split(",");	
				if (Estado[0] == A[1]){
					if (Estado[1] == A[2]){
						var L = parseInt(Estado[2]) + parseInt(A[3]); 
						if (L < monto){
							Mensaje += 'Limite Superado: ' + A[1] +' solo vender por: '+ L +'\n';
						}
						encontrado = true;
					}
				}
			});
			if (encontrado == false){
				Limite_G.forEach(function(Lgeneral){
					General = Lgeneral.split(",");					
					if (General[0] == A[1]){
						if (parseInt(General[1]) < monto){
							Mensaje += 'Limite Superado: ' + A[1] +' solo vender por: '+ Estado[2] +'\n';
						}
					}
				});	
			}
		});		
	}	
		
	if (Mensaje != ""){
		alert(Mensaje);
		return false;
	}else{
		return true;
	}
}

function deshabilitarHoras(){	
	var fecha = new Date();	
	var horas = fecha.getHours();
	var minutos = fecha.getMinutes();
	var cierre = (horas * 60) + minutos;
	if (cierre >= 535) {
		document.getElementById('L9').style.display="none"; 
		document.getElementById('LL9').style.display="none"; 
		document.getElementById('G9').style.display="none"; 
		document.getElementById('LG9').style.display="none"; 		
	}
	if (cierre >= 595) {
		document.getElementById('L10').style.display="none"; 
		document.getElementById('LL10').style.display="none"; 
		document.getElementById('G10').style.display="none"; 
		document.getElementById('LG10').style.display="none"; 
		document.getElementById('P10').style.display="none"; 
		document.getElementById('LP10').style.display="none"; 
	}
	if (cierre >= 655) {
		document.getElementById('L11').style.display="none"; 
		document.getElementById('LL11').style.display="none"; 
		document.getElementById('G11').style.display="none"; 
		document.getElementById('LG11').style.display="none"; 
		document.getElementById('P11').style.display="none"; 
		document.getElementById('LP11').style.display="none";
	}
	if (cierre >= 715) {
		document.getElementById('L12').style.display="none"; 
		document.getElementById('LL12').style.display="none"; 
		document.getElementById('G12').style.display="none"; 
		document.getElementById('LG12').style.display="none"; 
		document.getElementById('P12').style.display="none"; 
		document.getElementById('LP12').style.display="none";
	}
	if (cierre >= 775) {
		document.getElementById('L13').style.display="none"; 
		document.getElementById('LL13').style.display="none"; 
		document.getElementById('G13').style.display="none"; 
		document.getElementById('LG13').style.display="none"; 
		document.getElementById('P13').style.display="none"; 
		document.getElementById('LP13').style.display="none";
	}
	if (cierre >= 835) { 
		document.getElementById('G14').style.display="none"; 
		document.getElementById('LG14').style.display="none"; 
		document.getElementById('P14').style.display="none"; 
		document.getElementById('LP14').style.display="none";
	}
	if (cierre >= 895) {
		document.getElementById('L15').style.display="none"; 
		document.getElementById('LL15').style.display="none"; 
		document.getElementById('G15').style.display="none"; 
		document.getElementById('LG15').style.display="none"; 
		document.getElementById('P15').style.display="none"; 
		document.getElementById('LP15').style.display="none";
	}
	if (cierre >= 955) {
		document.getElementById('L16').style.display="none"; 
		document.getElementById('LL16').style.display="none"; 
		document.getElementById('G16').style.display="none"; 
		document.getElementById('LG16').style.display="none"; 
		document.getElementById('P16').style.display="none"; 
		document.getElementById('LP16').style.display="none";
	}
	if (cierre >= 1015) {
		document.getElementById('L17').style.display="none"; 
		document.getElementById('LL17').style.display="none"; 
		document.getElementById('G17').style.display="none"; 
		document.getElementById('LG17').style.display="none"; 
		document.getElementById('P17').style.display="none"; 
		document.getElementById('LP17').style.display="none";
	}
	if (cierre >= 1075) {
		document.getElementById('L18').style.display="none"; 
		document.getElementById('LL18').style.display="none"; 
		document.getElementById('G18').style.display="none"; 
		document.getElementById('LG18').style.display="none"; 
		document.getElementById('P18').style.display="none"; 
		document.getElementById('LP18').style.display="none";
	}
	if (cierre >= 1135) {
		document.getElementById('L19').style.display="none"; 
		document.getElementById('LL19').style.display="none"; 
		document.getElementById('G19').style.display="none"; 
		document.getElementById('LG19').style.display="none"; 
		document.getElementById('P19').style.display="none"; 
		document.getElementById('LP19').style.display="none";
		document.getElementById('num').disabled = true;
		document.getElementById('eliminarT').disabled = true;
		document.getElementById('btnAnular').disabled = true;
		document.getElementById('mon').disabled = true;
		document.getElementById('btnEliminar').disabled = true;
		document.getElementById('btnModificar').disabled = true;
		document.getElementById('Nval').disabled = true;
		document.getElementById('btnRepetir').disabled = true;
		document.getElementById('repetir').disabled = true;
	}
}

function activarLista(){	
var habilitarA = false;
var habilitarP = false;

	$("input[class='Ani']").each(function() {
		if ($(this).prop('checked') == 1){			
			habilitarA = true;
		}
	});	
	
	$("input[class='Pai']").each(function() {
		if ($(this).prop('checked') == 1){			
			habilitarP = true;
		}
	});	
	
		if (habilitarA == false){
			$("input[name='animalitos[]']").each(function() {
				$(this).prop('disabled', true);
				document.getElementById('num').disabled = true;
				document.getElementById('mon').disabled = true;
				$("label.A").css({'color':'grey'});
			});
			$("input[class='Pai']").each(function() {
				$(this).prop('disabled', false);
				$("label.pa").css({'color':''});
			});	
		}
		
		if (habilitarP == false){
			$("input[name='paises[]']").each(function() {
				$(this).prop('disabled', true);
				document.getElementById('num').disabled = true;
				document.getElementById('mon').disabled = true;
				$("label.PA").css({'color':'grey'});
			});
			$("input[class='Ani']").each(function() {
				$(this).prop('disabled', false);
				$("label.an").css({'color':''});
			});	
		}
		
		if (habilitarA == true){
			$("input[name='animalitos[]']").each(function() {
				$(this).prop('disabled', false);
				$("label.A").css({'color':''});		
				document.getElementById('num').focus();
				document.getElementById('mon').disabled = false;
				document.getElementById('num').disabled = false;
			});
			$("input[class='Pai']").each(function() {
				$(this).prop('disabled', true);
				$("label.pa").css({'color':'grey'});
			});	
		}
		
		if (habilitarP == true){
			$("input[name='paises[]']").each(function() {
				$(this).prop('disabled', false);
				$("label.PA").css({'color':''});
				document.getElementById('num').disabled = false;
				document.getElementById('mon').disabled = false;				
				document.getElementById('num').focus();
			});
			$("input[class='Ani']").each(function() {
				$(this).prop('disabled', true);
				$("label.an").css({'color':'grey'});
			});	
		}	
} 

function saltar(e,id){
	(e.keyCode)?k=e.keyCode:k=e.which;
 
	if(k == 13){
		if(id == "num"){
			var monto = document.getElementById('mon').value;
			if (/^([0-9])*$/.test(monto)){
				if (monto >= 100){
					chequearLimite(monto, 'nuevo')
					document.getElementById('F1').submit();
				}else{
					alert('El Monto minimo por jugada es de 100 BsF.');
				}
			}else{
				alert('Solo puede ingresar Numeros en el Campo Monto.');
			}			
		}
		if (id == "mon"){
			var J = '';
			var I ='';
			var M = '';
			$("input[name='sorteos[]']").each(function() {
				if ($(this).prop('checked')){
					if ($(this).val().substring(0, 1) == 'P'){I = 1; J = 38; M = '1 y 38.'}else{I = 0; J = 36; M = '0 y 36 ó 00.'}
				}
			});
			var A = document.getElementById('num').value;			
			if (/^([0-9])*$/.test(A)){
				if (A <= J && A >= I){
					if (I == 1){
						var pa = 'Pa' + A.toString();
						document.getElementById(pa).checked = true;
					}
					if (I == 0){
						document.getElementById(A).checked = true;
					}
					document.getElementById(id).focus();
					$("#mon").select();
				}else{
					alert('Debe Ingresar un Número Valido entre ' + M);
					$("#num").select();
				}
			}else{
				alert('Debe Ingresar un Número Valido entre ' + M);
				$("#num").select();
			}			
		}
		if (id == 'M'){
			modificar_jugada()
		}
		if (id == 'R'){
			repetir_ticket()
		}
		if (id == 'A'){
			eliminar_T()
		}
		if (id == 'buscarP'){
			document.getElementById('buscarP').submit();
		}
		if (id == 'buscarF'){
			document.getElementById('buscarF').submit();
		}
		if (id == 'buscarT'){
			document.getElementById('buscarT').submit();
		}
	}
}

function mostrar_Ticket(id){
	document.getElementById('BT').value = id;
	document.getElementById('buscarT').submit();
}

function imprimir(e){
	(e.keyCode)?k=e.keyCode:k=e.which;
 
	if (k==27){
		document.getElementById('imprimir').style.display="block";
	}
}

function cargar(){
	activarLista();
	document.getElementById('num').focus();
	deshabilitarHoras();
	comprobarMensaje();
}

function repetir_ticket(){
	var Ticket = document.getElementById('repetir').value;
	window.location.href ="conexion/agregar_jugada.php?repetir=" + Ticket
}

function eliminar_jugada(){	
	var Ticket = document.getElementById('Ticket').value;	
	var Monto = document.getElementById('mon').value;	
	var Sorteos = '';
	var jugada = '';
	var cont = 0;
	
	$("input[name='jugada[]']").each(function() {
		if (cont >= 1 ) {
			jugada += "|";
		}	
		if ($(this).prop('checked') == 1){
			jugada += $(this).val();
			cont++;
		}
	});
	cont = 0;
			$("input[name='sorteos[]']").each(function() {
				if (cont >= 1 ) {
					Sorteos += "|";
				}	
				if ($(this).prop('checked')){
					Sorteos += $(this).val();				
					cont++;
				}
			});
	
	if (jugada != ''){
		window.location.href ="conexion/modificar_jugada.php?Ticket=" + Ticket + "&jugada=" + jugada + "&opcion=eliminar&sorteos=" + Sorteos + "&monto=" + Monto;
	}else{
		alert('NO hay Jugadas seleccionadas para Eliminar');
	}	
		
}

function modificar_jugada(){	
	var Ticket = document.getElementById('Ticket').value;
	var valor = document.getElementById('Nval').value;	
	var Monto = document.getElementById('mon').value;	
	var Sorteos = '';
	var jugada = '';
	var cont = 0;
	
	if (/^([0-9])*$/.test(valor)){
		if (valor >= 100){
			chequearLimite(valor, 'modificar')
			$("input[name='jugada[]']").each(function() {
				if (cont >= 1 ) {
					jugada += "|";
				}	
				if ($(this).prop('checked') == 1){
					jugada += $(this).val();
					cont++;
				}
			});
			cont = 0;
			$("input[name='sorteos[]']").each(function() {
				if (cont >= 1 ) {
					jugada += "|";
				}	
				if ($(this).prop('checked')){
					Sorteos += $(this).val();				
					cont++;
				}
			});
			if (jugada != ''){
				window.location.href ="conexion/modificar_jugada.php?Ticket=" + Ticket + "&jugada=" + jugada + "&opcion=modificar&nuevovalor=" + valor + "&sorteos=" + Sorteos + "&monto=" + Monto;
			}else{
				alert('NO hay Jugadas seleccionadas para Modificar');
			}
		}else{
			alert('El Monto minimo por jugada es de 100 BsF.');
		}
	}else{
		alert('Solo puede ingresar Numeros en el Campo Monto.');
	}	
}

function eliminar_T (){
	var Ticket = document.getElementById('eliminarT').value;
	
	window.location.href ="conexion/eliminar.php?Ticket=" + Ticket;
}

function comprobarMensaje(){
	var mensaje = document.getElementById('mensajes').value;
	if (mensaje == 'true'){
		alert('El Ticket fue Eliminado Exitosamente.');
		window.location.href ="/";
	}else if (mensaje == 'false'){
		alert('ERROR: El Ticket NO pudo ser Eliminado Exitosamente.');
		window.location.href ="/";
	}
}

