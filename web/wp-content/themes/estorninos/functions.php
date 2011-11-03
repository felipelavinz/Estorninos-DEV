<?php

/**
 * - Eventos
 * - Proyectos
 * - Debates
 * - Notas
 **/

register_nav_menu( 'primary', 'Menú principal');


add_theme_support('post-thumbnails');

function registrar_tipo_proyecto(){
	register_post_type( 'proyecto', array(
		'label' => 'Proyecto',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'excerpt'),
		'taxonomies' => array('category'),
		'has_archive' =>  'proyectos'
	) );
}

add_action('init', 'registrar_tipo_proyecto');

add_action('wp_ajax_enviar_proyecto', 'recibir_proyecto');
add_action('wp_ajax_nopriv_enviar_proyecto', 'crea_tu_cuenta');

function recibir_proyecto(){
	if ( wp_verify_nonce($_POST['_proyecto_nonce'], 'enviar_proyecto') ) {
		$insert = wp_insert_post(array(
			'post_title' => $_POST['proyecto']['nombre'],
			'post_excerpt' => $_POST['proyecto']['descripcion'],
			'post_content' => $_POST['proyecto']['contenido'],
			'post_type' => 'proyecto',
			'post_status' => 'publish'
		));
		$out = new stdClass;
		if ( is_wp_error($insert) ) {
			$out->status = 'error';
			$out->message = 'Hubo un error al insertar el post';
		} else {
			$out->status = 'ok';
			$out->message = 'El post fue insertado exitosamente';
			$out->url = get_permalink($insert);
		}
		echo json_encode( $out );
		exit;
	}
}

function crea_tu_cuenta(){
	wp_redirect( get_bloginfo('url') .'/registrate' );
}

function add_proyectos_metabox(){
	add_meta_box('proyectos-metabox', 'Info del Proyecto', 'proyectos_metabox', 'proyecto');
}

function proyectos_metabox( $post ){
	echo '<label for="proyectos_lugar">Lugar:</label> <input type="text" name="proyecto[lugar]" id="proyectos_lugar" value="'. get_post_meta($post->ID, '_lugar', true) .'" />';
}

add_action('add_meta_boxes', 'add_proyectos_metabox');

function listar_proyectos(){
	$proyectos = new WP_Query(array(
		'post_type' => 'proyecto',
		'orderby' => 'title',
		'order' => 'ASC'
	));
	if ( $proyectos->have_posts() ) :
		echo '<ul>';
		while( $proyectos->have_posts() ) : $proyectos->the_post();
			echo '<li><a href="'. get_permalink() .'">'. get_the_title() .'</a></li>';
		endwhile;
		echo '</ul>';
	endif;
}

add_action('save_post', 'save_proyectos_metabox');
function save_proyectos_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['proyecto']['lugar'] );
}