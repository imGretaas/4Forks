<?php
session_start();


if (!isset($_SESSION['auth']) || !isset($_SESSION['noauth']) || $_SESSION['auth'] !== TRUE || $_SESSION['noauth'] != -1 || empty($_SESSION['negozio'])) {
  session_unset();
  session_destroy();
  setcookie('4FLogErr', "TRUE", time()+120);
  header('Location: login.php');
  die();

}
require_once '../basefunction.php';
require_once 'prodottiattuali.php';

$middle = "";

$titolo = "Modifica Prodotto";
if ($middle == "") {
  $middle.='<script src="js/jquery-3.3.1.min.js" ></script>
  ';
}
$middle .= '<script src="js/modernizr-2.6.2.min.js"></script>
      <script src="js/jquery.cookie-1.3.1.js"></script>
      <script src="js/jquery.steps.js"></script>
      <link rel="stylesheet" href="css/normalize.css" media="handled, screen"/>
      <link rel="stylesheet" href="css/main.css" media="handled, screen"/>
      <link rel="stylesheet" href="css/jquery.steps.css" media="handled, screen"/>
      <link rel="stylesheet" href="css/gestionle(print).css" media="print"/>
      <script src="js/start_wizard.js"></script>
';
$message = "";
if(array_key_exists('modprodottoErr', $_SESSION)) {
    if ($_SESSION['modprodottoErr'] < -1 ) {
      $message = "Errore: eliminazione non confermata";
    } else {
      $message = "Prodotto Correttamente Eliminato";
    }
    unset($_SESSION['modprodottoErr']);
}

require_once 'inizio.php';

require 'modificaprodotto.html';

require 'end.txt';
?>
