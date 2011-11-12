<?php
	/* Template Name: Enviar nota */
	get_header();
?>
<div id="posts" class="hfeed posts-entries">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
		<div <?php post_class('hentry') ?>>
			<?php if ( get_the_title() ) : ?>
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
			<?php endif; ?>
			<?php
				$nota_id = (int)$_GET['id'];
				$nota = get_post($nota_id	);
			?>
			<form id="formulario-nota" method="post" action="<?php bloginfo('url'); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
					<div>
						<label for="nombre_nota">Titulo</label></label>
						<input id="nombre_nota" name="nota[nombre]" type="text" value="<?php echo $nota->post_title ? esc_attr($nota->post_title) : '' ?>"/>
					</div>
					<div>
						<label for="descripcion_nota">Descripción</label>
						<textarea name="nota[descripcion]" id="descripcion_nota" cols="30" rows="10"></textarea>
					</div>
					<div>
						<label for="imagen_nota">Imagen</label></label>
						<input id="imagen_nota" name="nota_imagen" type="file" />
					</div>
					<div>
						<label for="categorias_nota">Selecciona las categorías que responden a tu publicacion</label>
						<?php estorninos_category_checkbox('nota', $nota); ?>
					</div>
					<div>
						<input type="submit" value="Enviar" />
						<input type="hidden" name="action" value="enviar_nota" />
						<?php wp_nonce_field('enviar_nota', '_nota_nonce'); ?>
					</div>
				</fieldset>
			</form>
		</div>
	<?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>