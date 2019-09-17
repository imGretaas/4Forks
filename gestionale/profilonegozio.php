<?php
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['noauth']) || $_SESSION['auth'] !== TRUE || $_SESSION['noauth'] != -1) {
  session_unset();
  session_destroy();
  setcookie('4FLogErr', "TRUE", time()+120);
  header('Location: login.php');
}
require_once '../basefunction.php';
$message = "";
$middle = '';
$erro = 0;
$dati = "";
if (!empty($_SESSION['proup']) && $_SESSION['proup'] != 0) {
  $erro = $_SESSION['proup'];
  if ($erro < -3 && $erro >-9) {
    $_SESSION['proup'] = -3;
  }
  if ($erro < -9) {
    $_SESSION['proup'] = -10;
  }
  switch ($_SESSION['proup']) {
    case 1:
      $message = "Profilo modificato con successo";
      break;

    case -1:
      $middle = '<script src="js/jquery-3.3.1.min.js" ></script>
            <script src="js/proermail.js"></script>';
      break;

    case -1:
      $middle = '<script src="js/jquery-3.3.1.min.js" ></script>
            <script src="js/proercoerenza.js"></script>';
      break;

    case -3:
      $message = "Modifica Fallita:<br> Connessione al server non riuscita";
      $middle = '<script src="js/jquery-3.3.1.min.js" ></script>
              <script src="js/proer.js"></script>';
      break;

    case -10:
      $message = "Modifica Fallita:<br> Il file inserito non é valido";
      $middle = '<script src="js/jquery-3.3.1.min.js" ></script>
              <script src="js/proerfile.js"></script>';
    break;

      /*default:
      $message = "Registrazione Fallita:<br> Errore numero $erro";
      break;*/
  }
}
if(!empty($_SESSION['ritornero']) && !empty($_SESSION['specerror'])){
  unset($dati);
  $dati = $_SESSION['ritornero'];
  foreach ($_SESSION['specerror'] as $key => $value) {
    if ($value == 0) {
      if(isset($dati[$key])) {
        $dati[$key] = "";
      }
    }
  }
  if(empty($dati['tel'])) {
    $dati['tel'] = "";
  }
}

if (!isset($_SESSION['ritornero'])) {
  require_once 'profiloattuale.php';
}

$titolo = "Profilo Venditore";
if ($middle == "") {
  $middle.='<script src="js/jquery-3.3.1.min.js" ></script>
  ';
}
$middle .= '<script src="js/modernizr-2.6.2.min.js"></script>
      <script src="js/jquery.cookie-1.3.1.js"></script>
      <script src="js/jquery.steps.js"></script>
      <link rel="stylesheet" href="css/normalize.css" media="handled, screen">
      <link rel="stylesheet" href="css/main.css" media="handled, screen">
      <link rel="stylesheet" href="css/jquery.steps.css" media="handled, screen">
      <link rel="stylesheet" href="css/gestionale(print).css" media="print">
      <script src="js/start_wizard.js"></script>
';
//

$basedir = 'img/negozi';
// <p id="pprofiloattuale">Foto Profilo Attuale</p>
$monconesx = ' <figure>
<img src="';
$monconedx = '" id="fotoprofiloattuale" title="foto profilo attuale di'.$_SESSION['negozio'].'" alt="foto profilo attuale di'.$_SESSION['negozio'].'" />
  <figcaption>Foto Profilo Attuale</figcaption>
</figure>';
$file = "";
if(is_dir($basedir)) {
  $scan =scandir($basedir);
  foreach ($scan as $key => $value) {
    if(strpos($value, $_SESSION['negozio']) !== FALSE ) {
      $file = $value;
    }
  }
  if ($file != "") {
    $file = $basedir.'/'.$file;
  }
}

$middle .= '<script src="../js/forms-checks-and-slider.js"></script>';

require_once 'inizio.php';

require 'profilonegozio.html';

require 'end.txt';
//print_r($_SESSION);
//echo $erro;
unset($_SESSION['proup']);
unset($_SESSION['ritornero']);
unset($_SESSION['specerror']);
?>
