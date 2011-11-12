jQuery(document).ready(function($){

	$('#formulario-proyecto').submit(function(){
		$.post( $('#formulario-proyecto').attr('action') , $('#formulario-proyecto').serialize(), function( datos ){
			if ( datos.status === 'ok' ) {
				if ( confirm(datos.message) ) {
					location.href = datos.url;
				}
			} else {
				alert(datos.message);
			}
		}, 'json' );
		return false;
	});



	//$('#formulario-nota').submit(function(){
	//	$.post( $('#formulario-nota').attr('action') , $('#formulario-nota').serialize(), function( datos ){
	//		if ( datos.status === 'ok' ) {
	//			if ( confirm(datos.message) ) {
	//				location.href = datos.url;
	//			}
	//		} else {
	//			alert(datos.message);
	//		}
	//	}, 'json' );
	//	return false;
	//});



		$('#formulario-debate').submit(function(){
		$.post( $('#formulario-debate').attr('action') , $('#formulario-debate').serialize(), function( datos ){
			if ( datos.status === 'ok' ) {
				if ( confirm(datos.message) ) {
					location.href = datos.url;
				}
			} else {
				alert(datos.message);
			}
		}, 'json' );
		return false;
	});



//$('#formulario-evento').submit(function(){
//		$.post( $('#formulario-evento').attr('action') , $('#formulario-evento').serialize(), function( datos ){
//			if ( datos.status === 'ok' ) {
//				if ( confirm(datos.message) ) {
//					location.href = datos.url;
//				}
//			} else {
//				alert(datos.message);
//			}
//		}, 'json' );
//		return false;
//	});




});