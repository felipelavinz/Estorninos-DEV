<?php get_header(); ?>
	<div id="posts" class="hfeed posts-entries">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div <?php post_class('hentry yui3-g') ?>>
				<div class="yui3-u-1-4">
					<h2 class="entry-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h2>
					<p class="entry-meta">
						<?php the_date(); ?>
					</p>
				</div>
				<div class="yui3-u-3-4">
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		<?php endwhile; endif; ?>
	</div>
<?php get_footer(); ?>