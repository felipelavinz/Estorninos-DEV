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
});