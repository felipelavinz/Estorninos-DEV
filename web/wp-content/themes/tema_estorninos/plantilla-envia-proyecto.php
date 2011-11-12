<?php
	/* Template Name: Enviar proyecto */
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
			<form id="formulario-proyecto" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
				<fieldset>
					<div>
						<label for="nombre_proyecto">Título</label>
						<input id="nombre_proyecto" name="proyecto[nombre]" type="text" />
					</div>
					<div>
						<label for="descripcion_proyecto">Descripción</label>
						<textarea name="proyecto[descripcion]" id="descripcion_proyecto" cols="30" rows="10"></textarea>
					</div>
					<div>
						<label for="etapas_proyecto">Etapas</label>
						<textarea name="proyecto[etapas]" id="etapas_proyecto" cols="30" rows="10"></textarea>
					</div>
					<div>
						<label for="imagen_debate">Imagen</label>
						<textarea name="debate[imagen]" id="imagen_debate" cols="30" rows="10"></textarea>
					</div>
					<div>
						<label for="categorias_nota">Selecciona las categorías que responden a tu publicacion</label></label>
						<input id="categorias_nota" name="nota[categorias]" type="text" />
					</div>
					<div>
						<input type="submit" value="Enviar" />
						<input type="hidden" name="action" value="enviar_proyecto" />
						<?php wp_nonce_field('enviar_proyecto', '_proyecto_nonce'); ?>
					</div>
				</fieldset>
			</form>
		</div>
	<?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>