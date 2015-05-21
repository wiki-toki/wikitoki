<?php
add_action('after_setup_theme', 'my_wikitoki_setup');
function my_wikitoki_setup(){
  load_child_theme_textdomain('wikitoki', get_stylesheet_directory() . '/languages');
}

// custom post types
add_action( 'init', 'create_post_type', 0 );

function create_post_type() {
	// ACTIVIDAD
	register_post_type( 'actividad', array(
		'labels' => array(
			'name' => __( 'Activities' ),
			'singular_name' => __( 'Activity' ),
			'add_new_item' => __( 'Añadir una actividad' ),
			'edit' => __( 'Editar' ),
			'edit_item' => __( 'Editar actividad' ),
			'new_item' => __( 'Nueva actividad' ),
			'view' => __( 'Ver la actividad' ),
			'view_item' => __( 'Ver la actividad' ),
			'search_items' => __( 'Buscar una actividad' ),
			'not_found' => __( 'No se ha encontrado ninguna actividad' ),
			'not_found_in_trash' => __( 'No se han encontrado actividades en la papelera' ),
			'parent' => __( 'Parent' )
		),
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'menu_position' => 4,
		'show_in_nav_menus' => true,
		'has_archive' => true,
//		'menu_icon' => get_template_directory_uri() . '/images/icon-post.type-integrantes.png',
		'hierarchical' => false, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title','editor','excerpt','custom-fields','author','comments','revisions','thumbnail'),
		//'taxonomies' => array('origine',), TODO
		'rewrite' => array('slug'=>'actividad','with_front'=>false),
		'can_export' => true,
//		'_builtin' => false,
//		'_edit_link' => 'post.php?post=%d',
//		'map_meta_cap' => true, // should be true to make capability_type works
//		'capability_type' => 'page',
	));
}

// Custom Taxonomies
add_action( 'init', 'build_taxonomies', 0 );

function build_taxonomies() {
	// TIPO DE ACTIVIDAD
	register_taxonomy( 'tipo-actividad', array('actividad'), array(
		'labels' => array(
			'name' => _x( 'Tipos de actividad','taxonomy general name' ),
			'singular_name' => _x( 'Tipo de actividad','taxonomy general name' ),
			'search_items' => __( 'Busca tipo de actividad' ),
			'popular_items' => __( 'Tipos de actividad populares' ),
			'all_items' => __( 'Todos los tipos de actividad' ),
			'parent_item' => __( 'Actividad tipo padre' ),
			'edit_item' => __( 'Modifica el tipo de actividad' ),
			'update_item' => __( 'Actualiza el tipo de actividad' ),
			'add_new_item' => __( 'Añade tipo de actividad' ),
			'new_item_name' => __( 'Nuevo nombre del tipo de actividad' ),
		),
		'public' => true,
		'hierarchical' => true,
		'update_count_callback' => true,
		'query_var' => true,
		'rewrite' => array('slug'=>'tipo-actividad','with_front'=>false,'hierarchical'=>true)
	));
	// ESCALA DE ACTIVIDAD
	register_taxonomy( 'escala-actividad', array('actividad'), array(
		'labels' => array(
			'name' => _x( 'Escalas de actividad','taxonomy general name' ),
			'singular_name' => _x( 'Escala de actividad','taxonomy general name' ),
			'search_items' => __( 'Busca escala de actividad' ),
			'popular_items' => __( 'escala de actividad populares' ),
			'all_items' => __( 'Todas las escalas de actividad' ),
			'parent_item' => __( 'Escala tipo madre' ),
			'edit_item' => __( 'Modifica la escala de actividad' ),
			'update_item' => __( 'Actualiza la escala de actividad' ),
			'add_new_item' => __( 'Añade la escala de actividad' ),
			'new_item_name' => __( 'Nuevo nombre del tipo de actividad' ),
		),
		'public' => true,
		'hierarchical' => true,
		'update_count_callback' => true,
		'query_var' => true,
		'rewrite' => array('slug'=>'escala-actividad','with_front'=>false,'hierarchical'=>true)
	));
}

//// CUSTOM METABOXES: Adds new fields for Atividades
// More info about metabox at https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress/wiki/Basic-Usage
function sample_metaboxes( $meta_boxes ) {
	$prefixact = '_act_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'activiy-info',
		'title' => 'Información sobre Actividad',
		'pages' => array('actividad'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Lugar',
				'desc' => '',
				'id' => $prefixact . 'place',
				'type' => 'text_small'
			),
			array(
				'name' => 'Hora',
				'desc' => 'Hora a la que ocurre el evento. Ej: 18.30h',
				'id' => $prefixact . 'time',
				'type' => 'text_small',
			),
			array(
				'name' => 'Fecha de inicio',
				'desc' => 'Seleccion la fecha',
				'id' => $prefixact . 'date-init',
				'type' => 'text_datetime_timestamp'
			),
			array(
				'name' => 'Fecha final',
				'desc' => 'Seleccion la fecha',
				'id' => $prefixact . 'date-end',
				'type' => 'text_datetime_timestamp',
			),
			array(
				'name'    => 'Actividad permanente',
				'id'      => $prefixact . 'permanente',
				'type'    => 'radio_inline',
				'default' => 'no',
				'options' => array(
					  'sí' => 'sí',
					  'no' => 'no',
				),
			),
			array(
				'name' => 'Organizador',
				'desc' => 'Nombre del grupo o persona organizadora',
				'id' => $prefixact . 'organizador',
				'type' => 'text_small'
			),
			array(
				'name' => 'Número de asistentes',
				'desc' => 'Ejempo: 12',
				'id' => $prefixact . 'numero-asistentes',
				'type' => 'text_small'
			),
			array(
				'id' => $prefixact . 'mas_info_url',
				'type' => 'group',
				'desc' => 'Más información URL',
				'options' => array('group_title' => 'Más información'),
				'fields' => array(
					array(
						'name' => __( 'Texto del link','spacious-child' ),
						'id'   => 'url_text',
						'type' => 'text',
						'desc' => 'Texto del link, tipo: Más fotos, Párrafo con más información',
					),
					array(
						'name' => 'URL',
						'id'   => 'url',
						'type' => 'text_url',
						'protocols' => array( 'http', 'https' ),
						'desc' => 'URL del link: http://zaramari.com/el-taller-del-mapa',
					),
				),
			),
			array(
				'name' => __( 'Relación con el barrio','montera34' ),
				'desc' => 'Escribe un párrafo',
				'id' => $prefixact . 'relacion-barrio',
				'type' => 'wysiwyg',
				'options' => array(
					'textarea_rows' => get_option('default_post_edit_rows', 4),
				)
			),
			array(
				'name' => __( 'Qué relación las actividades ha tenido con temas promovidos por el Ayuntamiento','wikitoki' ),
				'desc' => 'Escribe un párrafo',
				'id' => $prefixact . 'relacion-ayuntamiento',
				'type' => 'wysiwyg',
				'options' => array(
					'textarea_rows' => get_option('default_post_edit_rows', 4),
				)
			),
			array(
				'name' => __( 'Resumen de la actividad','wikitoki' ),
				'desc' => '',
				'id' => $prefixact . 'resumen-actividad',
				'type' => 'wysiwyg',
				'options' => array(
					'textarea_rows' => get_option('default_post_edit_rows', 15),
				)
			),
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'sample_metaboxes' );

// Initialize the metabox class
add_action( 'init', 'initialize_cmb_meta_boxes', 9999 );
function initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'lib/metabox/init.php' );
	}
}

//// USER
// extra fields in user profile
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

	function extra_user_profile_fields( $user ) {
 		$extra_fields = array(
			array(
				'name' => 'Web (URL) <br>Ej: http://wikitoki.org',
				'label' => 'web'
			),
			array(
				'name' => 'Feed (rss) <br>Ej: http://wikitoki.org/feed',
				'label' => 'feed'
			),
			array(
				'name' => 'Twitter <br>Ej: wiki_toki',
				'label' => 'twitter'
			),
			array(
				'name' => 'Facebook <br>Ej http://facebook.com/wikitoki',
				'label' => 'facebook'
			),
		);
	?>

		<h3><?php _e("Información", "blank"); ?></h3>
		<table class="form-table">
	<?php foreach ( $extra_fields as $extra_field ) { ?>	
		<tr>
		<th><label for="<?php echo $extra_field['label']; ?>"><?php echo $extra_field['name']; ?></label></th>
		<td>
			<input type="text" name="<?php echo $extra_field['label']; ?>" id="<?php echo $extra_field['label']; ?>" value="<?php echo esc_attr( get_the_author_meta( $extra_field['label'], $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
		</tr>

	<?php } ?>
	

		</table>

<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
 
function save_extra_user_profile_fields( $user_id ) {
 
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
 		$extra_fields = array(
			array(
				'name' => 'Web (URL) <br>Ej: http://wikitoki.org',
				'label' => 'web'
			),
			array(
				'name' => 'Feed (rss) <br>Ej: http://wikitoki.org/feed',
				'label' => 'feed'
			),
			array(
				'name' => 'Twitter <br>Ej: wiki_toki',
				'label' => 'twitter'
			),
			array(
				'name' => 'Facebook <br>Ej http://facebook.com/wikitoki',
				'label' => 'facebook'
			),
		);

	foreach ( $extra_fields as $extra_field ) {	
		update_user_meta( $user_id, $extra_field['label'], $_POST[$extra_field['label']] );
	}

}

////////////////// USER TAXONOMIES
// Custom User Taxonomies
add_action( 'init', 'build_user_taxonomies', 0 );

function build_user_taxonomies() {
	// Tipo de usuario
	register_taxonomy( 'user-type', 'user', array(
		'labels' => array(
			'name' => _x( 'Tipos de usuario','taxonomy general name' ),
			'singular_name' => _x( 'Tipo de usuario','taxonomy general name' ),		
			'search_items' => __( 'Busca entre los tipos de usuario' ),
			'popular_items' => __( 'Tipos de usuario populares' ),
			'all_items' => __( 'Todos los tipos de usuario' ),
			'parent_item' => __( 'Tipo de usuario padre' ),
			'edit_item' => __( 'Editar tipo de usuario' ),
			'update_item' => __( 'Actualizar' ),
			'add_new_item' => __( 'Añadir nuevo tipo de usuario' ),
			'new_item_name' => __( 'nuevo tipo de usuario' ),
//			'separate_items_with_commas' => __( 'Separate tags with commas' ),
//			'add_or_remove_items' => __( 'Add or remove tags' ),
//			'choose_from_most_used' => __( 'Choose from the most used tags' ),
//			'menu_name' => 
		),
		'public' => true,
		'hierarchical' => true,
	//	'update_count_callback' => 'my_update_professionnel_count', // Use a custom function to update the count. TODO
//		'query_var' => true,
		'rewrite' => array('slug'=>'user-type','with_front'=>false,'hierarchical'=>true),
		'capabilities' => array(
			'manage_terms' => 'edit_users', // Using 'edit_users' cap to keep this simple.
			'edit_terms'   => 'edit_users',
			'delete_terms' => 'edit_users',
			'assign_terms' => 'read',
		),
	));
	// Usuario al que pertenece
	register_taxonomy( 'user-group', 'user', array(
		'labels' => array(
			'name' => _x( 'Grupos','taxonomy general name' ),
			'singular_name' => _x( 'Grupo','taxonomy general name' ),
			'search_items' => __( 'Busca entre los grupos' ),
			'popular_items' => __( 'Grupos populares' ),
			'all_items' => __( 'Todos los grupos' ),
			'parent_item' => __( 'Grupo padre' ),
			'edit_item' => __( 'Editar grupo' ),
			'update_item' => __( 'Actualizar' ),
			'add_new_item' => __( 'Añadir nuevo grupo' ),
			'new_item_name' => __( 'Nuevo tipo de grupo' ),
//			'separate_items_with_commas' => __( 'Separate tags with commas' ),
//			'add_or_remove_items' => __( 'Add or remove tags' ),
//			'choose_from_most_used' => __( 'Choose from the most used tags' ),
//			'menu_name' =>
		),
		'public' => true,
		'hierarchical' => true,
	//	'update_count_callback' => 'my_update_professionnel_count', // Use a custom function to update the count. TODO
//		'query_var' => true,
		'rewrite' => array('slug'=>'user-group','with_front'=>false,'hierarchical'=>true),
		'capabilities' => array(
			'manage_terms' => 'edit_users', // Using 'edit_users' cap to keep this simple.
			'edit_terms'   => 'edit_users',
			'delete_terms' => 'edit_users',
			'assign_terms' => 'read',
		),
	));
}

/* Adds user taxonomies page in the admin. */
add_action( 'admin_menu', 'my_add_user_type_admin_page' );
add_action( 'admin_menu', 'my_add_user_group_admin_page' );


/**
 * Creates the admin pages for the 'professionnel', 'secteur' and 'lieu' taxonomies under the 'Users' menu.  It works the same as any 
 * other taxonomy page in the admin.  However, this is kind of hacky and is meant as a quick solution.  When 
 * clicking on the menu item in the admin, WordPress' menu system thinks you're viewing something under 'Posts' 
 * instead of 'Users'.  We really need WP core support for this.
 */
function my_add_user_type_admin_page() {

	$tax = get_taxonomy( 'user-type' );

	add_users_page(
		esc_attr( $tax->labels->menu_name ),
		esc_attr( $tax->labels->menu_name ),
		$tax->cap->manage_terms,
		'edit-tags.php?taxonomy=' . $tax->name
	);
}

function my_add_user_group_admin_page() {

	$tax = get_taxonomy( 'user-group' );

	add_users_page(
		esc_attr( $tax->labels->menu_name ),
		esc_attr( $tax->labels->menu_name ),
		$tax->cap->manage_terms,
		'edit-tags.php?taxonomy=' . $tax->name
	);
}

/* Open the right admin menu when clicking in user taxonomies: Professionnel, Secteur, Lieu */
add_filter( 'parent_file', 'fix_user_tax_page' );

function fix_user_tax_page( $parent_file = '' ) {
	global $pagenow;

	if ( ! empty( $_GET[ 'taxonomy' ] ) && $_GET[ 'taxonomy' ] == 'user-type' && $pagenow == 'edit-tags.php' ) {
		$parent_file = 'users.php';
	}
	if ( ! empty( $_GET[ 'taxonomy' ] ) && $_GET[ 'taxonomy' ] == 'user-group' && $pagenow == 'edit-tags.php' ) {
		$parent_file = 'users.php';
	}
	
	return $parent_file;
}

/* Add section to the edit user page in the admin to select profession, secteur or lieu */
add_action( 'show_user_profile', 'my_edit_user_type_section' );
add_action( 'edit_user_profile', 'my_edit_user_type_section' );
add_action( 'show_user_profile', 'my_edit_user_group_section' );
add_action( 'edit_user_profile', 'my_edit_user_group_section' );

/**
 * Adds an additional settings section on the edit user/profile page in the admin.  This section allows users to 
 * select a profession, secteur or lieu from a checkbox of terms from each taxonomy.
 *
 * @param object $user The user object currently being edited.
 */

// user type
function my_edit_user_type_section( $user ) {

	$tax = get_taxonomy( 'user-type' );

	/* Make sure the user can assign terms of the profession taxonomy before proceeding. */
	if ( !current_user_can( $tax->cap->assign_terms ) )
		return;

	/* Get the terms of the 'profession' taxonomy. */
	$terms = get_terms( 'user-type', array( 'hide_empty' => false ) ); ?>

	<h3><?php _e( 'Tipo de usuario' ); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="user-type"><?php _e( 'Elige uno de los tipos' ); ?></label></th>
			<td>
				<fieldset id="user-type">
			<?php
			/* If there are any profession terms, loop through them and display checkboxes. */
			if ( !empty( $terms ) ) {
				foreach ( $terms as $term ) { ?>
					<input type="checkbox" name="user-type-<?php echo esc_attr( $term->slug ); ?>" id="user-type-<?php echo esc_attr( $term->slug ); ?>" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( true, is_object_in_term( $user->ID, 'user-type', $term->slug ) ); ?> /> <label for="user-type-<?php echo esc_attr( $term->slug ); ?>"><?php echo $term->name; ?></label> <br />
				<?php }
			}
			/* If there are no profession terms, display a message. */
			else {
				_e( 'No hay usuarios de este tipo.' );
			}
			?></fieldset></td>
		</tr>
	</table>
<?php }

// user group
function my_edit_user_group_section( $user ) {

	$tax = get_taxonomy( 'user-group' );

	/* Make sure the user can assign terms of the profession taxonomy before proceeding. */
	if ( !current_user_can( $tax->cap->assign_terms ) )
		return;

	/* Get the terms of the 'profession' taxonomy. */
	$terms = get_terms( 'user-group', array( 'hide_empty' => false ) ); ?>

	<h3><?php _e( 'Grupo al que pertenece el usuario' ); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="user-group"><?php _e( 'Elige uno de los grupos' ); ?></label></th>
			<td>
				<fieldset id="user-group">
			<?php
			/* If there are any profession terms, loop through them and display checkboxes. */
			if ( !empty( $terms ) ) {
				foreach ( $terms as $term ) { ?>
					<input type="checkbox" name="user-group-<?php echo esc_attr( $term->slug ); ?>" id="user-group-<?php echo esc_attr( $term->slug ); ?>" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( true, is_object_in_term( $user->ID, 'user-group', $term->slug ) ); ?> /> <label for="user-group-<?php echo esc_attr( $term->slug ); ?>"><?php echo $term->name; ?></label> <br />
				<?php }
			}
			/* If there are no profession terms, display a message. */
			else {
				_e( 'No hay grupos de usuario.' );
			}
			?></fieldset></td>
		</tr>
	</table>
<?php }

/* Update the profession terms when the edit user page is updated. */
add_action( 'personal_options_update', 'my_save_user_type_terms' );
add_action( 'edit_user_profile_update', 'my_save_user_type_terms' );
add_action( 'personal_options_update', 'my_save_user_group_terms' );
add_action( 'edit_user_profile_update', 'my_save_user_group_terms' );

/**
 * Saves the term selected on the edit user/profile page in the admin. This function is triggered when the page 
 * is updated.  We just grab the posted data and use wp_set_object_terms() to save it.
 *
 * @param int $user_id The ID of the user to save the terms for.
 */

// user type
function my_save_user_type_terms( $user_id ) {

	$tax = get_taxonomy( 'user-type' );

	/* Make sure the current user can edit the user and assign terms before proceeding. */
	if ( !current_user_can( 'edit_user', $user_id ) && current_user_can( $tax->cap->assign_terms ) )
		return false;

	$terms = get_terms('user-type','hide_empty=0');
	$add_terms = array();
	foreach ( $terms as $term ) {
		$toadd = esc_attr( $_POST['user-type-' .$term->slug] );
		if ( $toadd != '' ) { array_push($add_terms, $term->slug); }
	}

	/* Sets the terms (we're just using a single term) for the user. */
	wp_set_object_terms( $user_id, $add_terms, 'user-type', false);

	clean_object_term_cache( $user_id, 'user-type' );
}

// user group
function my_save_user_group_terms( $user_id ) {

	$tax = get_taxonomy( 'user-group' );

	/* Make sure the current user can edit the user and assign terms before proceeding. */
	if ( !current_user_can( 'edit_user', $user_id ) && current_user_can( $tax->cap->assign_terms ) )
		return false;

	$terms = get_terms('user-group','hide_empty=0');
	$add_terms = array();
	foreach ( $terms as $term ) {
		$toadd = esc_attr( $_POST['user-group-' .$term->slug] );
		if ( $toadd != '' ) { array_push($add_terms, $term->slug); }
	}

	/* Sets the terms (we're just using a single term) for the user. */
	wp_set_object_terms( $user_id, $add_terms, 'user-group', false);

	clean_object_term_cache( $user_id, 'user-group' );
}
//adds all the custom post types to the feed
function myfeed_request($qv) {
	if (isset($qv['feed']))
		$qv['post_type'] = get_post_types();
	return $qv;
}
add_filter('request', 'myfeed_request');

//Adds filter to make oembed filters (captions shortcode) work in wysiwyg field tpe in custom meta boxes
function wikitoki_get_wysiwyg_output( $meta_key, $post_id = 0 ) {
    global $wp_embed;

    $post_id = $post_id ? $post_id : get_the_id();

    $content = get_post_meta( $post_id, $meta_key, 1 );
    $content = $wp_embed->autoembed( $content );
    $content = $wp_embed->run_shortcode( $content );
    $content = do_shortcode( $content );
    $content = wpautop( $content );

    return $content;
}

//Adds Orbita menu
function register_my_menus() {
  register_nav_menus(
    array(
		'orbita' => 'Orbita',
		)
  );
}
add_action( 'init', 'register_my_menus' );
