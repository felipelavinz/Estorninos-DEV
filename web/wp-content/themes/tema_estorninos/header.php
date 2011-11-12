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
<body <?php body_class(); ?>>
<header>
		<nav id="login"><?php if (is_user_logged_in () ) global $current_user; get_currentuserinfo(); echo '<a href="'. admin_url('profile.php') .'"></a>' . $current_user->display_name . "\n";?>|
		<?php if ( is_user_logged_in()) { echo '<a href="'. admin_url('wp-login.php?action=logout') .'">Salir</a>'; } else { echo '<a href="/wordpress/wp-login.php">Ingresar</a>'; };?>
		<nav id="buscador"><?php get_search_form( $echo ); ?></nav>
		</nav> <!-- login -->
		<nav id="titulo-sitio"><a href="<?php bloginfo('home');?>/">Estorninos</nav>
				<nav id="menu"><?php wp_nav_menu(array('theme_location'=>'primary')); ?></nav>

</header>
