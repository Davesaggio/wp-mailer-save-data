<?php
/*
Plugin Name: Import
Plugin URI: 
Version: 1.0
Author: 
Author URI: 
*/

// add_action('admin_menu', 'import_setup_menu');

// Add menu voice.
// function import_setup_menu() {
//   add_menu_page( 'Export contatti', 'Export contatti', 'read', 'import', 'import_settings', 'dashicons-upload', 50 );
// }

// Import settings.
function import_settings() {
  include 'view.php';
}

// creo cpt
add_action( 'init', 'register_cpt_save_data_mail' );

function register_cpt_save_data_mail() {

    $labels = array(
        'name' => _x( 'Lista contatti', 'wideo' ),
        'singular_name' => _x( 'Lista contatti', 'wideo' ),
        'add_new' => _x( 'contatto', 'wideo' ),
        'add_new_item' => _x( 'Importa nuovo contatto', 'wideo' ),
        'edit_item' => _x( 'Modifica contatto', 'wideo' ),
        'new_item' => _x( 'Nuovo contatto', 'wideo' ),
        'view_item' => _x( 'Vedi contatto', 'wideo' ),
        'search_items' => _x( 'Cerca contatto', 'wideo' ),
        'not_found' => _x( 'Nessuna voce trovata', 'wideo' ),
        'not_found_in_trash' => _x( 'Nessuna voce trovata', 'avcp' ),
        'parent_item_colon' => _x( 'Parent:', 'wideo' ),
        'menu_name' => _x( 'Lista contatti', 'wideo' ),
    );

    if ( function_exists( 'register_cpt_wideo' ) ) {
       $showinmenu = 'edit.php?post_type=wideo-contacts';
    } else {
        $showinmenu = true;
    }

  $args = array(
    'labels' => $labels,
    'hierarchical' => false,
    'description' => 'Lista contatti',
    'supports' => array( 'title', 'editor'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => $showinmenu,
    'menu_position' => 37,
    'menu_icon'    => 'dashicons-list-view',
    'show_in_nav_menus' => false,
    'publicly_queryable' => true,
    'exclude_from_search' => true,
    'has_archive' => false,
    'query_var' => true,
    'can_export' => false,
    'rewrite' => false,
    'capabilities' => array(
      // 'create_posts' => 'do_not_allow',
    ), 
  );

  register_post_type( 'wideo-contacts', $args );
}

add_filter( 'post_row_actions', 'remove_row_actions', 10, 1 );
function remove_row_actions( $actions )
{
    if( get_post_type() === 'wideo-contacts' )
        unset( $actions['edit'] );
        unset( $actions['view'] );
        unset( $actions['trash'] );
        unset( $actions['inline hide-if-no-js'] );
    return $actions;
}

function disable_new_posts_contacts() {
  // Hide sidebar link
  global $submenu;
  unset($submenu['edit.php?post_type=wideo-contacts'][10]);
  // Hide link on listing page
  if (isset($_GET['post_type']) && $_GET['post_type'] == 'wideo-contacts') {
      echo '<style type="text/css">
      #favorite-actions, .add-new-h2, .tablenav { display:none; }
      </style>';
  }
}

add_action('admin_menu', 'disable_new_posts_contacts');
add_filter('bulk_actions-edit-wideo-contacts', '__return_empty_array');

/*
 * Aggiungo colonne nella lista delle candidature
 */
// Add the custom columns to the book post type:
function wideo_set_custom_edit_contacts_columns($columns) {
  $columns['wideo_name'] = __( 'Nome', 'wideo' );
  $columns['wideo_surname'] = __( 'Cognome', 'wideo' );
  $columns['wideo_email'] = __( 'Email', 'wideo' );
  $columns['wideo_cv'] = __( 'CV', 'wideo' );

  return $columns;
}
add_filter( 'manage_wideo-contacts_posts_columns', 'wideo_set_custom_edit_contacts_columns' );



// Add the data to the custom columns for the book post type:
  function wideo_columns_contacts( $column, $post_id ) {
    switch ( $column ) {
    	case 'wideo_name' : echo get_post_meta( $post_id, 'name', true ); break;
    	case 'wideo_surname' : echo get_post_meta( $post_id, 'surname', true ); break;
    	case 'wideo_email' : echo get_post_meta( $post_id, 'email', true ); break;
    	case 'wideo_cv' : echo '<a href="'.get_post_meta( $post_id, 'cv', true ).'">Scarica cv</a>'; break;
    }
}
add_action( 'manage_wideo-contacts_posts_custom_column' , 'wideo_columns_contacts', 10, 2 );

// make columns sortable
function wideo_sortable_contacts( $columns ) {

	$columns['wideo_name'] = __( 'Nome', 'wideo' );
	$columns['wideo_surname'] = __( 'Cognome', 'wideo' );
  $columns['wideo_email'] = __( 'Email', 'wideo' );
  $columns['wideo_cv'] = __( 'CV', 'wideo' );

    return $columns;
}
add_filter( 'manage_edit-wideo-contacts_sortable_columns', 'wideo_sortable_contacts' );



?>
