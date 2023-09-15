<?php
// $args = array(
//   'numberposts'	=> -1,
//   'posts_per_page' => -1,
//   'post_type'		=> 'mail-contacts'
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
  // curriculum
  update_field('field_6079436485a99', $data->survey_curriculum, $cptID);
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
      'post_type' => 'mail-contacts',
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
