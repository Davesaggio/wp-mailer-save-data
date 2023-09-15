# WIDEO MAILER SAVE DATA FORM
plugin per salvare i dati del mailer wideo-mailer

1. Viene creato un cpt wideo-contacts al suo interno verranno salvati tutti i dati inviati dal mailer
2. viene generata una cartella negli uploads contacts-cv 
3. bisonga create tutti i campi acf necessari da salvare 
4. collegarli nel file save-data-mail.php nella funzione updateCPTFieldsContact

## Installation
```shell
inserire questo codice in wideo mailer

if($SAVE_DATA) {
  $array_fiels = [];
  foreach ($PARAMS as $parameter) {
    if($parameter === 'file_cv') {
      $array_fields['file_cv'] = $_FILES["file_cv"]["tmp_name"];
    } else {
      $value = isset($_POST[$parameter]) ? $_POST[$parameter] : '';
      $array_fields[$parameter] = $value;
    }

  }
  save_data_email($array_fiels);
} 
```shell
passare ai parametri del form 
'save_data' => true,
