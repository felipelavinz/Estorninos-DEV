<?php

/**
 * - Eventos
 * - Proyectos
 * - Debates
 * - Notas
 **/

//Eliminar barra de administraci—n
function quitar_barra_administracion()	{
	return false;
}

add_filter( 'show_admin_bar' , 'quitar_barra_administracion');


// Creo dos Menús: El Principal y el del Footer //
register_nav_menu( 'primary', 'Menú principal');
register_nav_menu( 'secondary', 'Footer');


add_theme_support('post-thumbnails');

add_image_size('nota', 320, 240, true);
add_image_size('nota-thumbnail', 80, 80, true);


// Acortar textos para mostrar en el Home y Página específica de cada tipo de publicación //
function wp_limit_post($max_char, $more_link_text = '[...]',$notagp = false, $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
      if($notagp) {
      echo substr($content,0,$max_char);
      }
      else {
      echo '<p>';
      echo substr($content,0,$max_char);
      echo "</p>";
      }
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        if($notagp) {
        echo substr($content,0,$max_char);
        echo $more_link_text;
        }
        else {
        echo '<p>';
        echo substr($content,0,$max_char);
        echo $more_link_text;
        echo "</p>";
        }
   }
   else {
      if($notagp) {
      echo substr($content,0,$max_char);
      }
      else {
      echo '<p>';
      echo substr($content,0,$max_char);
      echo "</p>";
      }
   }
}



//Acortando titulos por caracteres para mostrar en el Home y Página específica de cada tipo de publicación//
function titulo_corto($after = null, $length) {
	$mytitle = get_the_title();
	$size = strlen($mytitle);
	if($size>$length) {
		$mytitle = substr($mytitle, 0, $length);
		$mytitle = explode(' ',$mytitle);
		array_pop($mytitle);
		$mytitle = implode(" ",$mytitle).$after;
	}
	return $mytitle;
}




///Comentarios///

function estorninos_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:'); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>'),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s'), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit'), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.'); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>'), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}




// Crear Proyecto //
function registrar_tipo_proyecto(){
	register_post_type( 'proyecto', array(
		'label' => 'Proyecto',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'excerpt'),
		'taxonomies' => array('category'),
		'has_archive' =>  'proyectos',
	) );
}

add_action('init', 'registrar_tipo_proyecto');

add_action('wp_ajax_enviar_proyecto', 'recibir_proyecto');
add_action('wp_ajax_nopriv_enviar_proyecto', 'crea_tu_cuenta');

function recibir_proyecto(){
	if ( wp_verify_nonce($_POST['_proyecto_nonce'], 'enviar_proyecto') ) {
		$insert = wp_insert_post(array(
			'post_title' => $_POST['proyecto']['nombre'],
			'post_content' => $_POST['proyecto']['descripcion'],
			'post_excerpt' => $_POST['proyecto']['etapas'],
			'post_excerpt' => $_POST['proyecto']['imagen'],
			'post_excerpt' => $_POST['proyecto']['categorias'],
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
	global $post;
	$the_post = $post;
	$proyectos = new WP_Query(array(
		'post_type' => 'proyecto',
	));
	if ( $proyectos->have_posts() ) : $i = 0;
		echo '<ul>';
			while( $proyectos->have_posts() && $i < 6 ) : $proyectos->the_post();
			echo '<div class="titulo-lista"><li><a href="'. get_permalink() .'">'. get_the_title() .'</a></li></div>por ';
			echo '<li><a href="'. the_author_posts_link() .''. the_time (', j \d\e F Y') .' </a></li>';
			echo '<li><a href="'. get_the_date() .'</a></li>';
			$i++;
			endwhile;
		echo '</ul>';
	endif;
	$post = $the_post;
}



add_action('save_post', 'save_proyectos_metabox');
function save_proyectos_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['proyecto']['lugar'] );
}




// Crear Nota //
function registrar_tipo_nota(){
	register_post_type( 'nota', array(
		'label' => 'Nota',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'excerpt', 'comments'),
		'taxonomies' => array('category'),
		'has_archive' =>  'notas',
	) );
}

add_action('init', 'registrar_tipo_nota');

//add_action('wp_ajax_enviar_nota', 'recibir_nota');
add_action('wp_ajax_nopriv_enviar_nota', 'crea_tu_cuenta');

add_action('init', 'recibir_nota');
function recibir_nota(){
	if ( wp_verify_nonce($_POST['_nota_nonce'], 'enviar_nota') ) {
		$insert = wp_insert_post(array(
			'post_title' => $_POST['nota']['nombre'],
			'post_content' => $_POST['nota']['descripcion'],
			'post_excerpt' => $_POST['nota']['imagen'],
			'post_type' => 'nota',
			'post_status' => 'publish'
		));
		$out = new stdClass;
		if ( is_wp_error($insert) ) {
			$out->status = 'error';
			$out->message = 'Hubo un error al insertar el post';
		} else {
			if ( $_FILES ) {
				require ABSPATH .'/wp-admin/includes/file.php';
				foreach ( $_FILES as $file ) {
					if ( $file['error'] == 0 ) {
						$upload = wp_handle_upload( $file, array('test_form'=>false) );
						if ( $upload ) {
							$attachment = wp_insert_attachment(array(
								'post_mime_type' => $upload['type'],
								'post_title' => $_POST['nota']['nombre'],
								'post_content' => '',
								'post_status' => 'inherit'
							), $upload['file'], $insert);
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata( $attachment, $upload['file'] );
							wp_update_attachment_metadata( $attachment, $attach_data );
							add_post_meta( $insert, '_thumbnail_id', $attachment );
						}
					}
				}
			}
			foreach( $_POST['nota']['categorias'] as $categoria ){
				wp_set_post_terms( $insert, (int)$categoria, 'category', true );
			}
			wp_redirect( get_permalink($insert) );
			exit;
		}
	}
}

/*
function crea_tu_cuenta(){
	wp_redirect( get_bloginfo('url') .'/registrate' );
}

function add_notas_metabox(){
	add_meta_box('notas-metabox', 'Info de la Nota', 'notas_metabox', 'nota');
}

function notas_metabox( $post ){
	echo '<label for="notas_lugar">Lugar:</label> <input type="text" name="nota[lugar]" id="notas_lugar" value="'. get_post_meta($post->ID, '_lugar', true) .'" />';
}

add_action('add_meta_boxes', 'add_notas_metabox');
*/


function listar_notas(){
	$notas = new WP_Query(array(
		'post_type' => 'nota',
	));
	if ( $notas->have_posts() ) : $i = 0;
		echo '<ul>';
			while( $notas->have_posts() && $i < 6 ) : $notas->the_post();
			echo '<div class="titulo-lista"><li><a href="'. get_permalink() .'">'. get_the_title() .'</a></li></div>por ';
			echo '<li><a href="'. the_author_posts_link() .''. the_time (', j \d\e F Y') .' </a></li>';
			echo '<li><a href="'. get_the_date() .'</a></li>';
			$i++;
			endwhile;
		echo '</ul>';
	endif;
}

add_action('save_post', 'save_notas_metabox');
function save_notas_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['nota']['lugar'] );
}



// Crear Debates//
function registrar_tipo_debate(){
	register_post_type( 'debate', array(
		'label' => 'Debate',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'excerpt'),
		'taxonomies' => array('category'),
		'has_archive' =>  'debates',
	) );
}

add_action('init', 'registrar_tipo_debate');

add_action('wp_ajax_enviar_debate', 'recibir_debate');
add_action('wp_ajax_nopriv_enviar_debate', 'crea_tu_cuenta');

function recibir_debate(){
	if ( wp_verify_nonce($_POST['_debate_nonce'], 'enviar_debate') ) {
		$insert = wp_insert_post(array(
			'post_title' => $_POST['debate']['nombre'],
			'post_content' => $_POST['debate']['descripcion'],
			'post_excerpt' => $_POST['debate']['opciones'],
			'post_excerpt' => $_POST['debate']['imagen'],
			'post_excerpt' => $_POST['debate']['categorias'],
			'post_type' => 'debate',
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

/*
function crea_tu_cuenta(){
	wp_redirect( get_bloginfo('url') .'/registrate' );
}

function add_notas_metabox(){
	add_meta_box('notas-metabox', 'Info de la Nota', 'notas_metabox', 'nota');
}

function notas_metabox( $post ){
	echo '<label for="notas_lugar">Lugar:</label> <input type="text" name="nota[lugar]" id="notas_lugar" value="'. get_post_meta($post->ID, '_lugar', true) .'" />';
}

add_action('add_meta_boxes', 'add_notas_metabox');
*/


function listar_debates(){
	$debates = new WP_Query(array(
		'post_type' => 'debate',
	));
	if ( $debates->have_posts() ) : $i = 0;
		echo '<ul>';
			while( $debates->have_posts() && $i < 6 ) : $debates->the_post();
			echo '<div class="titulo-lista"><li><a href="'. get_permalink() .'">'. get_the_title() .'</a></li></div>por ';
			echo '<li><a href="'. the_author_posts_link() .''. the_time (', j \d\e F Y') .' </a></li>';
			echo '<li><a href="'. get_the_date() .'</a></li>';
			$i++;
			endwhile;
		echo '</ul>';
	endif;
}


add_action('save_post', 'save_debates_metabox');
function save_debates_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['nota']['lugar'] );
}



// Crear Eventos//
function registrar_tipo_evento(){
	register_post_type( 'evento', array(
		'label' => 'Evento',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'excerpt'),
		'taxonomies' => array('category'),
		'has_archive' =>  'eventos',
	) );
}

add_action('init', 'registrar_tipo_evento');

add_action('wp_ajax_enviar_evento', 'recibir_evento');
add_action('wp_ajax_nopriv_enviar_evento', 'crea_tu_cuenta');

function recibir_evento(){
	if ( wp_verify_nonce($_POST['_evento_nonce'], 'enviar_evento') ) {
		add_filter('wp_insert_post_data', 'filtrar_fecha_evento', 10, 2);
		$insert = wp_insert_post(array(
			'post_title' => $_POST['evento']['nombre'],
			'post_content' => $_POST['evento']['descripcion'],
			'post_type' => 'evento',
			'post_status' => 'publish'
		));
		$out = new stdClass;
		if ( is_wp_error($insert) ) {
			$out->status = 'error';
			$out->message = 'Hubo un error al insertar el post';
		} else {
			add_post_meta( $insert, 'Lugar', $_POST['evento']['lugar'] );
			$out->status = 'ok';
			$out->message = 'El post fue insertado exitosamente';
			$out->url = get_permalink($insert);
		}
		echo json_encode( $out );
		exit;
	}
}

function filtrar_fecha_evento( $data, $postarr ){
	if ( $data['post_type'] === 'evento' ) {
		$data['post_date'] = $_POST['evento']['fecha'] .' 00:00:00';
	}
	return $data;
}

/*
function crea_tu_cuenta(){
	wp_redirect( get_bloginfo('url') .'/registrate' );
}

function add_notas_metabox(){
	add_meta_box('notas-metabox', 'Info de la Nota', 'notas_metabox', 'nota');
}

function notas_metabox( $post ){
	echo '<label for="notas_lugar">Lugar:</label> <input type="text" name="nota[lugar]" id="notas_lugar" value="'. get_post_meta($post->ID, '_lugar', true) .'" />';
}

add_action('add_meta_boxes', 'add_notas_metabox');
*/


function listar_eventos(){
	$eventos = new WP_Query(array(
		'post_type' => 'evento',
	));
	if ( $eventos->have_posts() ) : $i = 0;
		echo '<ul>';
			while( $eventos->have_posts() && $i < 6 ) : $eventos->the_post();
			echo '<div class="titulo-lista"><li><a href="'. get_permalink() .'">'. get_the_title() .'</a></li></div>por ';
			echo '<li><a href="'. the_author_posts_link() .''. the_time (', j \d\e F Y') .' </a></li>';
			echo '<li><a href="'. get_the_date() .'</a></li>';
			$i++;
			endwhile;
		echo '</ul>';
	endif;
}
add_action('save_post', 'save_eventos_metabox');
function save_eventos_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['nota']['lugar'] );
}

function get_permalink_by_postname( $postname ){
	global $wpdb;
	$id = $wpdb->get_var( $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name =%s", $postname) );
	return get_permalink( $id );
}

/**
 * @param string $objeto tipo de objeto que se va a enviar o editar
 * @param object $edit objeto que se está editando
 * */
function estorninos_category_checkbox( $objeto, $edit = false ){
	if ( $edit ) {
		$edit_terms = get_the_terms( $edit->ID, 'category' );
		$post_terms = array();
		foreach ( $edit_terms as $et ) {
			$post_terms[] = $et->term_id;
		}
	}
	$terms = get_terms('category', array('hide_empty'=>false));
	if ( $terms ) {
		echo '<ul>';
		foreach ( $terms as $term ) {
			$exits = in_array($term->term_id, $post_terms) ? ' checked="checked" ' : '';
			echo '<li><label for="'. $term->slug .'"><input '. $exits .' type="checkbox" name="'. $objeto .'[categorias][]" value="'. $term->term_id .'" id="'. $term->slug .'" /> '. $term->name .'</label></li>';
		}
		echo '</ul>';
	}
}