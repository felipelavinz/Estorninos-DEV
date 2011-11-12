<?php
	/* Template Name: Enviar evento */
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
				$evento_id = (int)$_GET['id'];
				$evento_editar = get_post($evento_id);
				echo '<pre>'. print_r($evento_editar, true) .'</pre>';
			?>
			<form id="formulario-evento" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
				<fieldset>
					<div>
						<label for="nombre_evento">Titulo</label>
						<input id="nombre_evento" name="evento[nombre]" type="text" value="<?php echo $evento_editar->post_title ? esc_attr($evento_editar->post_title) : '' ?>" />
					</div>
					<div>
						<label for="descripcion_evento">Descripción</label>
						<textarea name="evento[descripcion]" id="descripcion_evento" cols="30" rows="10"></textarea>
					</div>
					<div>
						<label for="lugar_nota">Lugar</label>
						<input name="evento[lugar]" id="lugar_nota" />
					</div>
					<div>
						<label for="fecha_nota">Fecha</label>
						<select name="evento[fecha][dia]">
							<?php for ( $i = 1; $i < 32; $i++ ) : ?>
							<option><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						<select name="evento[fecha][mes]">
							<?php for ( $i = 1; $i <= 12; $i++ ) : ?>
							<option><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						<select name="evento[fecha][ano]">
							<?php for ( $i = date('Y'); $i <= date('Y') + 5; $i++ ) : ?>
							<option><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						<?php
							/**
							 * guardar fecha de inicio + hora de inicio en post_modified
							 * guardar fecha de iniio + hora de termin en post_modified_gmt
							 * */
						?>
					</div>
					<!--<div>-->
					<!--	<label for="hora-inicio_nota">Hora de Incio</label>-->
					<!--	<textarea name="nota[hora-inicio]" id="hora-inicio_nota" cols="30" rows="2"></textarea>-->
					<!--</div>-->
					<!--<div>-->
					<!--	<label for="hora-termino_nota">Hora de Termino</label>-->
					<!--	<textarea name="nota[hora-termino]" id="hora-termino_nota" cols="30" rows="2"></textarea>-->
					<!--</div>-->
					<!--<div>-->
					<!--	<label for="imagen_nota">Imagen</label></label>-->
					<!--	<input id="imagen_nota" name="nota[imagen]" type="text" />-->
					<!--</div>-->
					<!--<div>-->
					<!--	<label for="categorias_nota">Selecciona las categorías que responden a tu publicacion</label></label>-->
					<!--	<input id="categorias_nota" name="nota[categorias]" type="text" />-->
					<!--</div>-->
					<div>
						<input type="submit" value="Enviar" />
						<input type="hidden" name="action" value="enviar_evento" />
						<?php wp_nonce_field('enviar_evento', '_evento_nonce'); ?>
					</div>
				</fieldset>
			</form>
		</div>
	<?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>