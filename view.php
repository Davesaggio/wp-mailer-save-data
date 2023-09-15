<style>
  .ideo-wp-box {
    background: #FFFFFF;
    border: 1px solid #E5E5E5;
    position: relative;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
    padding: 15px;
    margin-bottom: 30px;
  }

  .ideo-wp-code {
    border: 1px solid #E5E5E5;
    padding: 0 5px;
  }

  .plugin-import__loading {
    display: none;
    margin-bottom: 20px;
    color: #666;
    padding: 20px 10px;
    border: solid 1px #eee;
  }

  .plugin-import__loading img {
    position: relative;
    top: 3px;
  }

  .plugin-import__loading--active {
    display: block;
  }

  .plugin-import__result {
    display: none;
    margin-bottom: 20px;
    color: #666;
  }

  .plugin-import__result--active {
    display: block;
  }

  .plugin-import__result p {
    font-size: 20px;
  }

  .plugin-import__result-error {
    background-color: #f1f1f1;
    color: #000;
    padding: 15px !important;
    margin-bottom: 15px;
  }

  .plugin-import__result-notices {
    display: none;
  }

  .plugin-import__result-notices--active {
    display: block;
  }

  .plugin-import__result-notices-title {
    font-weight: bold;
  }

  .plugin-import__result-notices-list {
    list-style-type: none;
    margin: 0;
    margin-left: 0;
    margin-top: 5px;
    margin-bottom: 5px;
  }

  .plugin-import__result-notices-list li {
    margin: 0;
    padding: 5px 0;
    border-bottom: solid 1px #eee;
  }
</style>

<div class='wrap'>

  <h1>Importazioni</h1>

  <br>

  <!-- RISULTATI -->
  <div class="notice notice-success plugin-import__result plugin-import__result-positive" style="margin-bottom: 0;">
    <p>Esportazione completata!</p>
    <div class="plugin-import__result-notices">
      <div class="plugin-import__result-notices-title">Segnalazioni:</div>
      <ul class="plugin-import__result-notices-list"></ul>
    </div>
  </div>

  <div class="notice notice-warning plugin-import__result plugin-import__result-negative" style="margin-bottom: 0;">
    <p>Si sono verificate delle problematiche durante l'esportazione:</p>
    <div class="plugin-import__result-error"></div>
  </div>

  <!-- CONTENUTO -->

  <div class="ideo-wp-box">

    <h2>Esportazione contatti</h2>

    <div class="plugin-import__loading contatti">
      <img src="<?php echo admin_url('images/loading.gif'); ?>" /> Operazione in corso. Durata indicativa: 30 Secondi
    </div>
    <button class="button button-primary button-large" onClick="exportContacts()">Esporta contatti</button>
  </div>


</div>
<!-- SCRIPT -->
<script>
  var importUrlcontatti = '<?php echo get_template_directory_uri(); ?>/plugins/import-plugin/api-export-data.php'

  function exportContacts() {

    var xhttp = new XMLHttpRequest()
    var loading = document.querySelector('.plugin-import__loading.contatti')
    var resultPositive = document.querySelector('.plugin-import__result-positive')
    var resultNegative = document.querySelector('.plugin-import__result-negative')
    var resultError = document.querySelector('.plugin-import__result-error')
    loading.classList.add('plugin-import__loading--active')
    resultPositive.classList.remove('plugin-import__result--active')
    resultNegative.classList.remove('plugin-import__result--active')
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var response = JSON.parse(this.responseText)
        console.log('risposta', response)
        loading.classList.remove('plugin-import__loading--active')
        if (response.result) {
          console.log(response)
          resultPositive.classList.add('plugin-import__result--active')
        } else {
          resultError.innerHTML = response.error
          resultNegative.classList.add('plugin-import__result--active')
        }
      } else if (this.readyState == 4 && this.status == 504) {
        console.log("status" + this.status)
        resultError.innerHTML = "Timeout - Errore " + this.status
        loading.innerHTML = "Timeout - Errore " + this.status
        resultNegative.classList.add('plugin-import__result--active')
      }
    }
    xhttp.onerror = function(e) {
      console.log('errore di connessione', e)
    }
    xhttp.open("POST", importUrlcontatti, true)
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    xhttp.send()
  }

</script>

<?php wp_enqueue_media(); ?>