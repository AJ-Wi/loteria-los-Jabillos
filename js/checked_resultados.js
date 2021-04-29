//setInterval(deshabilitarHoras,1000);

function deshabilitarHoras(){	
	var fecha = new Date();	
	var horas = fecha.getHours();
	var minutos = fecha.getMinutes();
	var cierre = (horas * 60) + minutos;
	if (cierre >= 595) {
		document.getElementById('L9').style.display="none"; 
		document.getElementById('LL9').style.display="none"; 
		document.getElementById('G9').style.display="none"; 
		document.getElementById('LG9').style.display="none"; 		
	}
	if (cierre >= 655) {
		document.getElementById('L10').style.display="none"; 
		document.getElementById('LL10').style.display="none"; 
		document.getElementById('G10').style.display="none"; 
		document.getElementById('LG10').style.display="none"; 
		document.getElementById('P10').style.display="none"; 
		document.getElementById('LP10').style.display="none"; 
	}
	if (cierre >= 715) {
		document.getElementById('L11').style.display="none"; 
		document.getElementById('LL11').style.display="none"; 
		document.getElementById('G11').style.display="none"; 
		document.getElementById('LG11').style.display="none"; 
		document.getElementById('P11').style.display="none"; 
		document.getElementById('LP11').style.display="none";
	}
	if (cierre >= 775) {
		document.getElementById('L12').style.display="none"; 
		document.getElementById('LL12').style.display="none"; 
		document.getElementById('G12').style.display="none"; 
		document.getElementById('LG12').style.display="none"; 
		document.getElementById('P12').style.display="none"; 
		document.getElementById('LP12').style.display="none";
	}
	if (cierre >= 835) {
		document.getElementById('L13').style.display="none"; 
		document.getElementById('LL13').style.display="none"; 
		document.getElementById('G13').style.display="none"; 
		document.getElementById('LG13').style.display="none"; 
		document.getElementById('P13').style.display="none"; 
		document.getElementById('LP13').style.display="none";
	}
	if (cierre >= 895) { 
		document.getElementById('G14').style.display="none"; 
		document.getElementById('LG14').style.display="none"; 
		document.getElementById('P14').style.display="none"; 
		document.getElementById('LP14').style.display="none";
	}
	if (cierre >= 955) {
		document.getElementById('L15').style.display="none"; 
		document.getElementById('LL15').style.display="none"; 
		document.getElementById('G15').style.display="none"; 
		document.getElementById('LG15').style.display="none"; 
		document.getElementById('P15').style.display="none"; 
		document.getElementById('LP15').style.display="none";
	}
	if (cierre >= 1015) {
		document.getElementById('L16').style.display="none"; 
		document.getElementById('LL16').style.display="none"; 
		document.getElementById('G16').style.display="none"; 
		document.getElementById('LG16').style.display="none"; 
		document.getElementById('P16').style.display="none"; 
		document.getElementById('LP16').style.display="none";
	}
	if (cierre >= 1075) {
		document.getElementById('L17').style.display="none"; 
		document.getElementById('LL17').style.display="none"; 
		document.getElementById('G17').style.display="none"; 
		document.getElementById('LG17').style.display="none"; 
		document.getElementById('P17').style.display="none"; 
		document.getElementById('LP17').style.display="none";
	}
	if (cierre >= 1135) {
		document.getElementById('L18').style.display="none"; 
		document.getElementById('LL18').style.display="none"; 
		document.getElementById('G18').style.display="none"; 
		document.getElementById('LG18').style.display="none"; 
		document.getElementById('P18').style.display="none"; 
		document.getElementById('LP18').style.display="none";
	}
	if (cierre >= 1195) {
		document.getElementById('L19').style.display="none"; 
		document.getElementById('LL19').style.display="none"; 
		document.getElementById('G19').style.display="none"; 
		document.getElementById('LG19').style.display="none"; 
		document.getElementById('P19').style.display="none"; 
		document.getElementById('LP19').style.display="none";
		document.getElementById('agregarR').disabled = true;
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
			$("input[name='animalito']").each(function() {
				$(this).prop('disabled', true);
				$("label.A").css({'color':'grey'});
			});
		}
		
		if (habilitarP == false){
			$("input[name='pais']").each(function() {
				$(this).prop('disabled', true);
				$("label.PA").css({'color':'grey'});
			});
		}
		
		if (habilitarA == true){
			$("input[name='animalito']").each(function() {
				$(this).prop('disabled', false);
				$("label.A").css({'color':''});		
			});
		}
		
		if (habilitarP == true){
			$("input[name='pais']").each(function() {
				$(this).prop('disabled', false);
				$("label.PA").css({'color':''});
			});
		}
	
} 

function cargar(){
	activarLista();
	//deshabilitarHoras();
}
