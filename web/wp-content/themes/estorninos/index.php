<?php get_header(); ?>
<div class="yui3-g">
	<div id="posts" class="hfeed posts-entries yui3-u-2-3">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<div <?php post_class('hentry') ?>>
				<?php if ( get_the_title() ) : ?>
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<?php endif; ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		<?php endwhile; endif; ?>
	</div>
	<div class="yui3-u-1-3">
		<?php listar_proyectos(); ?>
	</div>
</div>
<?php get_footer(); ?>