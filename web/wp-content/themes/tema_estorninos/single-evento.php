<?php get_header(); ?>
	
<div id="crear-nuevo" class="clearfix"><?php if ( is_user_logged_in() ) { echo '<a href="http://estorninos.ead.pucv.cl/enviar-evento/">Crear Nuevo</a>'; } ?></div>

	<article id="publicacion">
	
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="titulo"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></div>
		<div class="autor">Publicado por <?php the_author_posts_link()?> el <?php the_time ('j \d\e F Y')?></div>
		<div class="categorias"><?php the_category('') ?></div>
		<br><?php the_content(); ?></br>
		<?php endwhile; endif; ?>

	</article> <!-- publicacion -->

	
	<aside id="lista-archivos">
		<h1>Ultimos Eventos</h2>
		<?php listar_eventos ();?>
	</aside><!-- lista-archivos -->
	
	
	<div id="contenedor-comentario">
		<?php comments_template( 's', true ); ?>
	</div>
	
<?php get_footer(); ?>