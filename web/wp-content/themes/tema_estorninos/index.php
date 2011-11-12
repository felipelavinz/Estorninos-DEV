<?php get_header(); ?>

	Proyectos
	<article id="contenedor-proyecto">
		<?php $proyectos = new WP_Query(array('post_type' => 'proyecto')); if ( $proyectos->have_posts() ) : $i = 1; while ( $proyectos->have_posts() && $i < 4 ) : $proyectos->the_post(); ?>
		<section class="proyecto">
			<?php if(function_exists('wp_likes_render_post')) wp_likes_render_post();?>
			<div class="titulo"><a href="<?php the_permalink(); ?>"><?php echo titulo_corto ('...', 50);?></a></div>
			<div class="autor">Publicado por <?php the_author_posts_link()?> el <?php the_time ('j \d\e F Y')?></div>
			<div class="categorias"><?php the_category('') ?></div>
			<br><div class="texto"><?php wp_limit_post(350, '...', true) ?></div></br>
		</section><!--proyecto-->
		<?php $i++; endwhile; endif; ?>
	</article><!-- contenedor-proyecto -->


	<article id="contenedor-nota">
	Notas
		<?php $notas = new WP_Query(array('post_type' => 'nota')); if ( $notas->have_posts() ) : $i = 1; while ( $notas->have_posts() && $i < 4 ) : $notas->the_post(); ?>
		<section class="notas">
			<a href="<?php echo get_permalink_by_postname('enviar-nota'); ?>?id=<?php the_ID(); ?>">editar</a>
			<?php comments_popup_link( __( '0' ), __( '1' ), __( '%' ) ) ?>
			<div class="titulo"><a href="<?php the_permalink(); ?>"><?php echo titulo_corto ('...', 50);?></a></div>
			<div class="autor"><?php the_author_posts_link()?> <?php the_time ('j \d\e F Y')?></div>
			<div class="categorias"><?php the_category('') ?></div>
		</section>
		<?php $i++; endwhile; else : echo wpautop( 'Sorry, no posts were found' ); endif; ?>
	</article><!-- contenedor-nota -->


	<article id="contenedor-debate">
	Debates
		<?php $debates = new WP_Query(array('post_type' => 'debate')); if ( $debates->have_posts() ) : $i = 1; while ( $debates->have_posts() && $i < 4 ) : $debates->the_post(); ?>
		<section class="debates">
			<?php comments_popup_link( __( '0' ), __( '1' ), __( '%' ) ) ?>
			<div class="titulo"><a href="<?php the_permalink(); ?>"><?php echo titulo_corto ('...', 50);?></a></div>
			<div class="autor"><?php the_author_posts_link()?> <?php the_time ('j \d\e F Y')?></div>
			<div class="categorias"><?php the_category('') ?></div>
		</section>
		<?php $i++; endwhile; else : echo wpautop( 'Sorry, no posts were found' ); endif; ?>
	</article><!-- contenedor-debate -->



	<article id="contenedor-evento">
	Eventos
		<?php $eventos = new WP_Query(array('post_type' => 'evento', 'orderby' => 'modified', 'order' => 'DESC')); if ( $eventos->have_posts() ) : $i = 1; while ( $eventos->have_posts() && $i < 4 ) : $eventos->the_post(); ?>
		<a href="http://localhost/estorninos/web/enviar-evento/?id=<?php the_ID(); ?>">editar</a>
		<section class="eventos">
			<?php comments_popup_link( __( '0' ), __( '1' ), __( '%' ) ) ?>
			<div class="titulo"><a href="<?php the_permalink(); ?>"><?php echo titulo_corto ('...', 50);?></a></div>
			<div class="autor"><?php the_author_posts_link()?> <?php the_time ('j \d\e F Y')?></div>
			<div class="categorias"><?php the_category('') ?></div>
		</section>
		<?php $i++; endwhile; else : echo wpautop( 'Sorry, no posts were found' ); endif; ?>
	</article><!-- contenedor-evento -->

<?php get_footer(); ?>