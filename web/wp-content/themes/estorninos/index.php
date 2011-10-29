<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?php wp_title(); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/yui.css" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/script.js"></script>
	<?php wp_head(); ?>
</head>
<body <?php body_class('yui3-cssbase'); ?>>
	<div id="posts" class="hfeed posts-entries">
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
<?php wp_footer(); ?>
</body>
</html>