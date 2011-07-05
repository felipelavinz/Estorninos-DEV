jQuery(document).ready(function($){
	SyntaxHighlighter.all();
	$('p.toggle').bind('click', function(){
		$(this).next('div').slideToggle('fast');
	});
});