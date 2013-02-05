<?php
/**
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */ 
//define("DONOTCACHEPAGE", true);

add_action( 'init', 'create_post_types' );
add_action('wp_dashboard_setup', 'hide_wp_welcome_panel' );
add_action('wp_enqueue_scripts', 'our_scripts');
add_action( 'init', 'register_menu' );
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);

function create_post_types() {
	register_post_type( 'template-content',
		array(
			'labels' => array(
			'name' => __( 'Mallinnehåll' ),
			'singular_name' => __( 'Mallnnehåll' ),
			'add_new' => __('Lägg till nytt mallinnehåll'),
			'all_items' => __('Visa allt mallinnehåll'),
			'add_new_item' => __('Lägg till nytt mallinnehåll'),
			'edit_item' => __('Redigera mallinnehåll'),
			'new_item' => __('Nytt mallinnehåll'),
			'view_item' => __('Visa mallinnehåll'),
			'search_items' => __('Sök mallinnehåll'),
			'not_found' =>  __('Inget mallinnehåll hittades'),
			'not_found_in_trash' => __('Inget mallinnehåll i papperskorgen'),
			'parent_item_colon' => '',
			'menu_name' => __('Mallinnehåll')
		),
		'capability_type' => 'page',
		'hierarchical' => false,
		'menu_icon' => get_bloginfo('template_directory'). "/img/admin/mallinnehall.png",
		'menu_position' => 21,
		'rewrite' => false,
		'public' => true,
		'supports' => array('title','editor'),
    )
  );
}

function my_css_attributes_filter($var) {
	return is_array($var) ? array_intersect($var, array('current-menu-item', 'current_page_parent', 'current-page-ancestor')) : '';
}

function hide_wp_welcome_panel(){
	if ( current_user_can( 'edit_theme_options' ) )
	$ah_clean_up_option = update_user_meta( get_current_user_id(), 'show_welcome_panel', false );
}

function our_scripts(){
	wp_enqueue_script("jquery");
	wp_enqueue_script("slides-min-jquery-js",  get_bloginfo('template_directory') . "/js/slides.min.jquery.js", "jquery", "1.0");
	wp_enqueue_script("global-js",  get_bloginfo('template_directory') . "/js/global.js", "jquery", "1.0");
	wp_enqueue_script("respond-min-js",  get_bloginfo('template_directory') . "/js/respond.min.js", "jquery", "1.0");
	wp_enqueue_script("jquery-ui-1.10.0.custom.min-js",  get_bloginfo('template_directory') . "/js/jquery-ui-1.10.0.custom.min.js", "jquery", "1.0");
}

function register_menu() {
	register_nav_menu( 'primary', 'Huvudmeny' );
}

function remove_dashboard_widgets(){
	// Ta bort widgets i vänsterkolumnen
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' ); // Inkommande länkar
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' ); // Tillägg
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Senaste kommentarer
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // Just nu
	// Ta bort widgets i högerkolumnen
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // WordPress Blogg
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // SnabbPress
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' ); // Senaste utkasten
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' ); // Andra WordPressnyheter
}

function year($start){
	if(date("Y") == $start) echo $start;
	else echo $start . "-". date("Y");
}

// SIMPLE FIELDS: Adds a new Field Group (Startsidan)
simple_fields_register_field_group('bildspelsrubrik',
	array (
		'name' => 'Bildspelsrubrik',
		'description' => "Här anges den rubrik som ska ligga över bildspelet.",
		'repeatable' => 0,
		'fields' => array(
			array('name' => 'Rubrik för hela bilspelet',
			      'description' => '',
			      'slug' => 'bildspelsrubrik_rubrik',
				  'type' => 'text'
			),
		)
	)
);
simple_fields_register_field_group('bildspel',
	array (
		'name' => 'Bildspel',
		'description' => "",
		'repeatable' => 1,
		'fields' => array(
			array('name' => 'Bild',
				  'description' => 'Bilderna ska vara 580x275px stora.',
				  'slug' => 'bildspel_bild',
				  'type' => 'file'
			),
			array('name' => 'Bildtext',
			      'description' => '',
			      'slug' => 'bildspel_text',
				  'type' => 'text'
			),
		)
	)
);
simple_fields_register_field_group('antal_fonster',
	array (
		'name' => 'Antal putsade fönster',
		'description' => "Här anges hur många fönster som putsats sen 1997.",
		'repeatable' => 0,
		'fields' => array(
			array('name' => 'Antal',
			      'description' => '',
			      'slug' => 'fonster_antal',
				  'type' => 'text'
			),
		)
	)
);
// SIMPLE FIELDS: Adds a new Post Connector (Startsidan)
simple_fields_register_post_connector('startsidan',
	array (
		'name' => "Startsidan",
		'field_groups' => array(
			array('name' => 'Bildspelsrubrik',
				  'key' => 'bildspelsrubrik',
				  'context' => 'normal',
				  'priority' => 'high'),
			array('name' => 'Bildspel',
				  'key' => 'bildspel',
				  'context' => 'normal',
				  'priority' => 'high'),
			array('name' => 'Antal putsade fönster',
				  'key' => 'antal_fonster',
				  'context' => 'side',
				  'priority' => 'high')
			),
	'post_types' => array('page')
	)
);

// SIMPLE FIELDS: Adds a new Field Group (Undersida)
simple_fields_register_field_group('info_i_blatt_falt',
	array (
		'name' => 'Information i blått fält',
		'description' => "Här anges den sidetikett och text som ska visas i det blåa fältet under sidhuvudet.",
		'repeatable' => 0,
		'fields' => array(
			array('name' => 'Sidetikett',
			      'description' => '',
			      'slug' => 'info_sidetikett',
				  'type' => 'text'
			),
			array('name' => 'Text',
			      'description' => '',
			      'slug' => 'info_text',
				  'type' => 'textarea',
				  'type_textarea_options' => array('use_html_editor' => 1)
			),
		)
	)
);
// SIMPLE FIELDS: Adds a new Post Connector (Undersida)
simple_fields_register_post_connector('undersida',
	array (
		'name' => "Undersida",
		'field_groups' => array(
			array('name' => 'Information i blått fält',
				  'key' => 'info_i_blatt_falt',
				  'context' => 'normal',
				  'priority' => 'high')
			),
	'post_types' => array('page')
	)
);

// SIMPLE FIELDS: Adds a new Field Group (Personal - Putsare)
simple_fields_register_field_group('anstallda',
	array (
		'name' => 'Anställda',
		'description' => "",
		'repeatable' => 1,
		'fields' => array(
			array('name' => 'Bild',
				  'description' => 'Bilderna ska vara 120x140px stora.',
				  'slug' => 'anstallda_bild',
				  'type' => 'file'
			),
			array('name' => 'Namn',
			      'description' => '',
			      'slug' => 'anstallda_namn',
				  'type' => 'text'
			),
			array('name' => 'Bilnummer',
			      'description' => '',
			      'slug' => 'anstallda_bilnr',
				  'type' => 'text'
			),
		)
	)
);
// SIMPLE FIELDS: Adds a new Post Connector (Personal - Putsare)
simple_fields_register_post_connector('personal',
	array (
		'name' => "Personal",
		'field_groups' => array(
			array('name' => 'Anställda',
				  'key' => 'anstallda',
				  'context' => 'normal',
				  'priority' => 'high'),
			array('name' => 'Information i blått fält',
				  'key' => 'info_i_blatt_falt',
				  'context' => 'normal',
				  'priority' => 'high')
			),
	'post_types' => array('page')
	)
);

// SIMPLE FIELDS: Adds a new Field Group (Personal - Kontor)
simple_fields_register_field_group('anstallda_kontor',
	array (
		'name' => 'Anställda kontor',
		'description' => "",
		'repeatable' => 1,
		'fields' => array(
			array('name' => 'Bild',
				  'description' => 'Bilderna ska vara 120x140px stora.',
				  'slug' => 'kontor_bild',
				  'type' => 'file'
			),
			array('name' => 'Namn',
			      'description' => '',
			      'slug' => 'kontor_namn',
				  'type' => 'text'
			),
			array('name' => 'Avdelning',
			      'description' => '',
			      'slug' => 'kontor_avd',
				  'type' => 'text'
			),
			array('name' => 'Telefon',
			      'description' => '',
			      'slug' => 'kontor_tel',
				  'type' => 'text'
			),
			array('name' => 'E-post',
			      'description' => '',
			      'slug' => 'kontor_epost',
				  'type' => 'text'
			),
		)
	)
);
// SIMPLE FIELDS: Adds a new Post Connector (Personal - Kontor)
simple_fields_register_post_connector('personal_kontor',
	array (
		'name' => "Personal kontor",
		'field_groups' => array(
			array('name' => 'Anställda kontor',
				  'key' => 'anstallda_kontor',
				  'context' => 'normal',
				  'priority' => 'high'),
			array('name' => 'Information i blått fält',
				  'key' => 'info_i_blatt_falt',
				  'context' => 'normal',
				  'priority' => 'high')
			),
	'post_types' => array('page')
	)
);

// SIMPLE FIELDS: Adds a new Field Group (Mallinnehåll)
simple_fields_register_field_group('genvagar_i_sidfoten',
	array (
		'name' => 'Genvägar i sidfoten',
		'description' => "Här redigerar man innehållet i de fyra genvägarna i sidfoten",
		'repeatable' => 1,
		'fields' => array(
			array('name' => 'Rubrik',
			      'description' => '',
			      'slug' => 'genvag_rubrik',
				  'type' => 'text'
			),
			array('name' => 'Text',
			      'description' => '',
			      'slug' => 'genvag_text',
				  'type' => 'textarea',
				  'type_textarea_options' => array('use_html_editor' => 1)
			),
			array('name' => 'Länktext',
			      'description' => '',
			      'slug' => 'genvag_lanktext',
				  'type' => 'text'
			),
			array('name' => 'Länkadress',
			      'description' => '',
			      'slug' => 'genvag_lankadress',
				  'type' => 'text'
			),
		)
	)
);
// SIMPLE FIELDS: Adds a new Post Connector (mallinnehåll)
simple_fields_register_post_connector('mallinnehall',
	array (
		'name' => "Mallinnehåll",
		'field_groups' => array(
			array('name' => 'Genvägar i sidfoten',
				  'key' => 'genvagar_i_sidfoten',
				  'context' => 'normal',
				  'priority' => 'high')
			),
	'post_types' => array('template-content')
	)
);

// SIMPLE FIELDS: Sets the default post connector for a post type
simple_fields_register_post_type_default('undersida', 'page');

function top_level_parent(){
	global $post;
	if($post->ancestors){
		return end($post->ancestors);
	}
	else {
		return false;
	}
}

/******  Reptilo does Ratsit 2012-12-06 ******/
include 'functions-efp.php';
?>