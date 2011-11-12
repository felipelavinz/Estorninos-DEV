<?php get_header(); ?>

	<div id="crear-nuevo" class="clearfix"><?php if ( is_user_logged_in() ) { echo '<a href="http://estorninos.ead.pucv.cl/enviar-nota/">Crear Nuevo</a>'; } ?></div>


	<article id="publicacion">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="titulo"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></div>
		<div class="autor">Publicado por <?php the_author_posts_link()?> el <?php the_time ('j \d\e F Y')?></div>
		<div class="categorias"><?php the_category('') ?></div>
		<br><?php the_content(); ?></br>
		<?php the_post_thumbnail('nota-thumbnail'); ?>
		<?php endwhile; endif; ?>

	</article> <!-- publicacion -->


	<aside id="lista-archivos">
		<h1>Ultimas Notas</h2>
		<?php listar_notas ();?>
	</aside><!-- lista-archivos -->

	<div id="contenedor-comentario">
		<?php comments_template( 's', true ); ?>
	</div>


<?php get_footer(); ?>
