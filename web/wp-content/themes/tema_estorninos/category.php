<?php get_header() ?>

<div id="proyectos">
			<?php while ( have_posts() ) : the_post() ?>
				<div id="post">
					<div id="post-numeros">
						<?php comments_popup_link( __( '0', 'sandbox' ), __( '1', 'sandbox' ), __( '%', 'sandbox' ) ) ?>
					</div><!-- post-numeros-->
						<div id="post-texto">
		<!--acorta titulos--><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php echo titulo_corto('...', 50); ?></a>	
							<p style="margin:0">Publicado por <?php the_author_posts_link() ?>, <?php the_time('j \d\e F') ?></p>
							<div id="tags"><?php the_tags(); ?></div>
							<p></p><span class="cat-links"><?php printf( __( 'En %s', 'sandbox' ), get_the_category_list(', ') ) ?></span></p>
		 <!--acorta texto--><p><?php wp_limit_post(350, '...', true) ?></p>
						</div><!-- post-texto-->
				</div><!-- post-->
			<?php comments_template() ?>
			<?php endwhile; ?>
	</div><!-- #proyectos -->


Pagina con las categor’as
<?php get_footer() ?>