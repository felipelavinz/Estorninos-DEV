<?php
	/* Template Name: Archivo Proyectos */
	get_header();
?>

		Proyectos Recientes
		<?php if ( is_user_logged_in() ) { echo '<a href="http://estorninos.ead.pucv.cl/enviar-proyecto/" style="float:right">Crear Nuevo</a>'; } ?>
		
	
	<article id="contenedor-proyecto" class="clearfix">
		<?php $proyectos = new WP_Query(array('post_type' => 'proyecto')); if ( $proyectos->have_posts() ) : $i = 0	; while ( $proyectos->have_posts() && $i < 6 ) : $proyectos->the_post(); ?>
		
		<section class="proyecto">
					<?php if(function_exists('wp_likes_render_post')) wp_likes_render_post();?>
			<?php comments_popup_link( __( '0' ), __( '1' ), __( '%' ) ) ?>
			<div class="titulo"><a href="<?php the_permalink(); ?>"><?php echo titulo_corto ('...', 50);?></a></div>
			<div class="autor">Publicado por <?php the_author_posts_link()?> el <?php the_time ('j \d\e F Y')?></div>
			<div class="categorias"><?php the_category('') ?></div>
			<br><div class="texto"><?php wp_limit_post(350, '...', true) ?></div></br>
		</section><!--proyecto-->
		<?php $i++; endwhile; endif; ?>
	</article><!-- contenedor-proyecto -->	
	
	<?php get_footer() ?>