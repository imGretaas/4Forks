<?php
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['noauth']) || $_SESSION['auth'] !== TRUE || $_SESSION['noauth'] != -1 || empty($_SESSION['negozio'] ||  !array_key_exists("Elimina", $_POST))) {
  session_unset();
  session_destroy();
  setcookie('4FLogErr', "TRUE", time()+120);
  header('Location: login.php');
  die();
}
require_once "../basefunction.php";
if (array_key_exists('return', $_POST)) {
  vaia('modprodotto.php');
}
$dati = explode('O;O',$_POST['dati']);

if(!array_key_exists(0, $dati)) {
  $_SESSION['modprodottoErr'] = -5; // Errore nei dati inseriti
  vaia('modprodotto.php');
}
$dquery = deletequery("Prodotti", "ID = ".$dati[0]);
if (!dbinsert($GLOBALS['db'], $dquery)) {
  $_SESSION['modprodottoErr'] = -4; // Errore nella delete query
  vaia('modprodotto.php');
}
$cquery = requestquery("ID", "Prodotti", "ID = ".$dati[0]);
$risconf = dbrequest($GLOBALS['db'], $cquery);
if (!empty($risconf)) {
  $_SESSION['modprodottoErr'] = -3; // Errore nella confirm query
  vaia('modprodotto.php');
} else {
  $_SESSION['modprodottoErr'] = -0; // Tutto Apposto
  vaia('modprodotto.php');
}
 ?>
