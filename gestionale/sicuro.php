<?php
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['noauth']) || $_SESSION['auth'] !== TRUE || $_SESSION['noauth'] != -1 || empty($_SESSION['negozio']) || ( array_key_exists("Modifica", $_POST) || array_key_exists("Elimina", $_POST)) ) {
  session_unset();
  session_destroy();
  setcookie('4FLogErr', "TRUE", time()+120);
  header('Location: login.php');
  die();
}
require_once '../basefunction.php';
$message = "";
$middle = "";

$titolo = "Modifica Prodotto";
if ($middle == "") {
  $middle.='<script src="js/jquery-3.3.1.min.js" ></script>
  ';
}
$middle .= '
      <script src="../js/forms-checks-and-slider.js"></script>
      <script src="js/modernizr-2.6.2.min.js"></script>
      <script src="js/jquery.cookie-1.3.1.js"></script>
      <script src="js/jquery.steps.js"></script>
      <link rel="stylesheet" href="css/normalize.css" media="handled, screen"/>
      <link rel="stylesheet" href="css/main.css" media="handled, screen"/>
      <link rel="stylesheet" href="css/jquery.steps.css" media="handled, screen"/>
      <link rel="stylesheet" href="css/gestionale(print).css" media="print"/>
      <script src="js/start_wizard.js"></script>
';
//
require_once 'inizio.php';

if(array_key_exists("modifica",$_POST) || array_key_exists("modproer", $_SESSION)) {
  if(array_key_exists("modifica",$_POST)) {
    $dati = $_POST['dati'];
    require_once "sicurodamod.php";
  } else {
    $raggio = FALSE;
    $dati = [ // RECUPERO CAMPI GIa INSERITI E RIGETTATI
      'nome' => str_replace("0", " ", $_SESSION['ritornero']['nome']),
      'certificazione' => $_SESSION['ritornero']['certificazione'],
      'prezzo' => $_SESSION['ritornero']['prezzo'],
      'desc' => '',
      'Categoria' => $_SESSION['ritornero']['Categoria'],
      'prov' => "",
      'regioni' => array(),
      'italia' => ''
    ];
    $regioni = "";
    $id =  $_SESSION['ritornero']['id'];
    if (array_key_exists('desc', $_SESSION['ritornero'])) {
      $dati['desc'] = $_SESSION['ritornero']['desc'];
    }
    if (array_key_exists('raggio', $_SESSION['ritornero']) && !empty($_SESSION['ritornero']['raggio'])) {
      $raggio = $_SESSION['ritornero']['raggio'];
      $rquery = requestquery('Regione, Province', "Raggio", "ID = $raggio");
      $risp = dbrequest($GLOBALS['db'], $rquery);
      if (!empty($risp)){
        if (array_key_exists('Regione', $risp[0])) {
          $dati['regioni'] = explode(',' , $risp[0]['Regione']);
          $regioni = $risp[0]['Regione'];
        }
        if (array_key_exists('Province', $risp[0])) {
          $dati['prov'] = $risp[0]['Province'];
        }
      }
    } else {
      if (array_key_exists('regioni', $_SESSION['ritornero'])) {
        $dati['regioni'] = $_SESSION['ritornero']['regioni'];
        $regioni =implode("," , $dati['regioni']);
      }
      if (array_key_exists('prov', $_SESSION['ritornero'])) {
        $dati['prov'] = $_SESSION['ritornero']['prov'];
      }
    }
    if ($raggio !== FALSE) {
      $passare = "$id,$raggio";
    } else {
      $passare = $id;
    }

    if(is_array($_SESSION['modproer'])) { // cancella i risultati errati da errore di coerenza
      $message = "Errore nei dati inseriti";
      foreach ($_SESSION['modproer'] as $key => $value) {
        if(array_key_exists($key, $dati) && $_SESSION['modproer'][$key] == 0) {
            $dati[$key] = "";
        }
      }
    } else {
      switch ($_SESSION['modproer']) {
        case 'noninserito':
          $message = "Errore del server: 1";
          break;

        case 'nonconfermato':
          $message = "Errore del server: 2";
          break;

        case 'Nessun raggio':
          $message = "Nessuna provincia e regione inserita";
          break;

        case 'erroreimmagine':
          $message = "Errore nella immagine inserita: errore".$_SESSION['ritornero']['errimg'];
          break;
      }
    }
  }
  /*if (array_key_exists('ritornero', $_SESSION)){ // DEBUGGING in progress...
    print_r($_SESSION['ritornero']);
    echo " QUESTO é RITORNERO<br><br>";
    print_r($_SESSION['modproer']);
    echo " QUESTO é MODPROER<br><br>";
    print_r($dati['regioni']);
    echo " QUESTO é Regioni<br><br>";
    print_r($regioni);
    echo " QUESTO é Regioni<br><br>";
    print_r($_SESSION['ritornero']['prov']);
    echo " QUESTO é PROV<br><br>";
    print_r($dati);
    echo " QUESTO é Dati<br><br>";
  }*/

  $sottocategorie = ''; // GENERAZIONE AUTMOMATICA DELLE SOTTOCATEGORIE
  $ris = categorie();
  $gruppi = array();
  foreach ($ris as $key => $value) {
    if (is_array($value)) {
      if (!in_array($value['Gruppo'], $gruppi )) {
        if (!empty($gruppi)) {
          $sottocategorie .= '</div>
          ' ;
        }
        $sottocategorie .= '<div class="SottoCat">
            <p class="sc_p"> '.str_replace("0", " ", $value['Gruppo']).'<span class="Asterix">&#42;</span><sup>(3)</sup>:</p>
        ' ;
        $gruppi[] = $value['Gruppo'];
      }
      $sottocategorie .= '    <label class="sottolabel" for="'.$value['Nome'].'">'.str_replace("0", " ",$value['Nome']). '</label><input id="'.$value['Nome'];
      $sottocategorie .='" type="radio" name="sottocategoria" value="'.$value['Nome'].'" ' ;
      if ($value['Nome'] == $dati['Categoria']) {
        $sottocategorie.= 'checked="checked" ';
      }
      $sottocategorie.= 'required="required" />
        ';
    }
  }
  $sottocategorie .= '</div>
  ';

  $province = ''; // GENERAZIONE AUTMOMATICA DELLE PROVINCE
  $rispro = province();
  $pro = "";
  $contatore = 0;
  foreach ($rispro as $key => $value) {

    if (is_array($value)) {
      if ($contatore % 5 == 0) {
        $pro.= '
          <div class="Gruppo">';
      }
      $nome = str_replace("0", " ", $value['regione_province']);
      if ($nome == "Valle d Aosta") $nome = "Valle d&apos; Aosta";
      $pro.= '
            <label class="sottolabel" for="'.$value['regione_province'].'">'.$nome. '</label><input id="'.$value['regione_province'];
      $pro .='" type="checkbox" name="regioni[]" value="'.$value['regione_province'] . '"';
      if(!empty($dati['regioni']) && in_array($value['regione_province'], $dati['regioni'])) {
        $pro.=' checked="checked" ';
      }
      $pro.=' />';
      if ($contatore % 5 == 4) {
        $pro.= '
          </div>
        ';
      }
      $contatore+=1;
    }
  }


  // RECUPERO IMMAGINE Prodotto
  $basedir = 'img/product';
  $monconesx = ' <figure id="modprofig">
  <img src="';
  $monconedx = '" id="fotoprofiloattuale" title="foto del prodotto: '.$dati['nome'].'" alt="foto del prodotto: '.$dati['nome'].'" />
    <figcaption>Foto del Prodotto: '.$dati['nome'].'</figcaption>
  </figure>';
  $file = "";
  if(is_dir($basedir)) {
    $scan =scandir($basedir);
    foreach ($scan as $key => $value) {
      if(strpos($value, $id) !== FALSE ) {
        $file = $value;
      }
    }
    if ($file != "") {
      $file = $basedir.'/'.$file;
    }
  }

  require_once 'modifica.html';

} else {
  $dati = $_POST['dati'];
  require_once 'sicuro.html';
}

require 'end.txt';

?>
