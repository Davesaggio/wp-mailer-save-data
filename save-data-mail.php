<?php
// $args = array(
//   'numberposts'	=> -1,
//   'posts_per_page' => -1,
//   'post_type'		=> 'wideo-contacts'
// );
// $query = new WP_Query( $args );
// $cpts = $query->posts;

// foreach ($cpts as $cpt) {
//   wp_delete_post($cpt->ID, true);
// }

// Import datas
// **********************************************************
/** @function findDCpt  */
function findCPT($title, $cpt) {
  $post = get_page_by_title($title, OBJECT,  $cpt);
  if( $post ) {
    return $post;
  } else {
    return null;
  }
}
date_default_timezone_set('Europe/Amsterdam');

/** @function updateCPTFieldsContact */
function updateCPTFieldsContact($cptID, $data) {
   // nome
  update_field('field_60793b5f1b278', $data->survey_name, $cptID);
  // cognome 
  update_field('field_607941eb85a85', $data->survey_surname, $cptID);
  // anno di nascita
  update_field('field_607941f485a86', $data->survey_year, $cptID);
  // comune di residenza
  update_field('field_6079422b85a87', $data->survey_address, $cptID);
  // email
  update_field('field_6079424b85a88', $data->survey_email, $cptID);
  // altri contatti
  update_field('field_6079426c85a89', $data->survey_contatti, $cptID);
  // curriculum
  update_field('field_6079436485a99', $data->survey_curriculum, $cptID);
  // mvc
  update_field('field_6079428685a8a', $data->mvc, $cptID);
  // oop
  update_field('field_6079429485a8b', $data->oop, $cptID);
  // orm
  update_field('field_6079429b85a8c', $data->orm, $cptID);
  // ui
  update_field('field_607942a085a8d', $data->ui, $cptID);
  // ux
  update_field('field_607942a885a8e', $data->ux, $cptID);
  // odoo 1
  update_field('field_607942b285a8f', $data->odoo1, $cptID);
  // odoo 2
  update_field('field_607942ba85a90', $data->odoo2, $cptID);
  // wp
  update_field('field_607942c385a91', $data->wp, $cptID);
  // drupal
  update_field('field_607942f885a92', $data->drupal, $cptID);
  // moodle
  update_field('field_6079430485a93', $data->moodle, $cptID);
  // html
  update_field('field_6079431185a94', $data->html, $cptID);
  // css
  update_field('field_6079431585a95', $data->css, $cptID);
  // bs
  update_field('field_6079432385a96', $data->bs, $cptID);
  // js
  update_field('field_6079433185a97', $data->js, $cptID);
  // ts
  update_field('field_6079433b85a98', $data->ts, $cptID);
  // ajs
  update_field('field_6079437985a9a', $data->ajs, $cptID);
  // a2+
  update_field('field_6079438885a9b', $data->a2, $cptID);
  // npm
  update_field('field_607943a085a9c', $data->npm, $cptID);
  // grunt 
  update_field('field_607943bb85a9d', $data->grunt, $cptID);
  // django
  update_field('field_607943cf85a9e', $data->django, $cptID);
  // jinja2
  update_field('field_607943da85a9f', $data->jinja2, $cptID);
  // orm phyton
  update_field('field_607943e885aa0', $data->orm_python, $cptID);
  // rest e cors
  update_field('field_6079443485aa1', $data->rest, $cptID);
  // php
  update_field('field_6079444885aa2', $data->php, $cptID);
  // symfony
  update_field('field_6079445385aa3', $data->symfony, $cptID);
  // twig
  update_field('field_6079445e85aa4', $data->twig, $cptID);
  // sql1
  update_field('field_6079446a85aa5', $data->sql1, $cptID);
  // sql2
  update_field('field_6079447585aa6', $data->sql2, $cptID);
  // git
  update_field('field_6079448f85aa7', $data->git, $cptID);
  // nosql
  update_field('field_6079449485aa8', $data->nosql, $cptID);
  // lamp
  update_field('field_607944a785aa9', $data->lamp, $cptID);
  // apache
  update_field('field_607944b885aaa', $data->apache, $cptID);
  // db
  update_field('field_607944c485aab', $data->db, $cptID);
  // vm
  update_field('field_607944d785aac', $data->vm, $cptID);
  // bi
  update_field('field_607944eb85aad', $data->bi, $cptID);
  // note
  update_field('field_607944f285aae', $data->survey_message, $cptID);
  // privacy
  update_field('field_6079485cd04f2', $data->survey_privacy, $cptID);


  $url_file_mail = $data->survey_curriculum;
  $upload_dir   = wp_upload_dir();
  $dir_cv = $upload_dir['basedir'].'/contacts-cv/';
  // controllo se la cartalla esiste, se non esiste la creo
  if ( ! file_exists( $dir_cv ) ) {
    wp_mkdir_p( $dir_cv );
  }
  if($url_file_mail) {
    $cv_filename = time() .'-'. $data->surname;
    copy($url_file_mail, $upload_dir['basedir'].'/contacts-cv/cv-'.$cv_filename.'.pdf');
    // url_file_cv:
    update_field('field_6079436485a99', $upload_dir['baseurl'].'/contacts-cv/cv-'.$cv_filename.'.pdf', $cptID);
  }


}

function createContact($contact) {
    // $contact = object
    $cptID = wp_insert_post(array(
      'post_type' => 'wideo-contacts',
      'post_status' => 'publish',
      'post_title' => $contact->survey_email,
    ), true);
    updateCPTFieldsContact($cptID, $contact);
    wp_publish_post( $cptID );
}

// funzione per salvare tutti i dati della mail

function save_data_email($data_email)  {
  $contact = json_decode(json_encode($data_email), FALSE);
  createContact($contact);
}
?>
