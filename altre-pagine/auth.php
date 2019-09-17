<?php
session_start();
if (!isset($_POST['email']) || !isset($_POST['password'])) {
  $_SESSION['Logerr'] = 0; // come ci sta arrivando qui l'utente?
  header('Location: login.php');
  die();
}
require_once "../function.php";
$controllo = array('email' => $_POST['email'], 'pass' => $_POST['password']);
$verifica = controllarray($controllo);
if ($verifica['email'] == 0 || $verifica['pass'] == 0) {
  $_SESSION['Logerr'] = -1;
  $_SESSION['Specerr'] = $verifica;
  vaia("login.php");
}
$pass = hash('sha256', $_POST['password']);
$request = requestquery("Nome", "LogghinC", "Credenziali = ".insertapici($pass));
$ris = dbrequest($GLOBALS['db'], $request);

if (empty($ris) || !in_array_r($_POST['email'], $ris)) {
  $_SESSION['Logerr'] = -2;
  vaia("login.php");
}

$_SESSION['email'] = $_POST['email'];
vaia("profilo.php");


?>
