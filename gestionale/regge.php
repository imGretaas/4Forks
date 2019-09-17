<?php
session_start(); // CONTROLLI DI SESSIONE e di AUTENTICAZIONE
if (!isset($_SESSION['auth']) || !isset($_SESSION['noauth']) || $_SESSION['auth'] !== TRUE || $_SESSION['noauth'] != -1 || !$_POST['email'] || !$_POST['password'] || $_POST['email'] == '' || $_POST['password'] == '' || $_POST['azienda'] == '' ) {
  session_unset();
  session_destroy();
  setcookie('4FLogErr', "TRUE", time()+120);
  header('Location: login.php');
}
require_once '../basefunction.php';
$arr["email"] = $_POST['email'];
$arr["password"] = $_POST['password'];
$arr["nome"] = $_POST['azienda'];
striparray($arr);
$pass = hash('sha256', $arr["password"]);
$Database = $GLOBALS['db'];
$nome =str_replace(" ", "0", $arr["nome"]);

$where = "Nome = ".insertapici($arr["email"]);
$giainserito = requestquery("Nome", "LogghinV", $where);

$where = "Nome = ".insertapici($arr["nome"]);
$giainseritonome = requestquery("Nome", "Negozi", $where);
$richiesta = dbrequest($GLOBALS['db'], $giainserito);
$richiestanome = dbrequest($GLOBALS['db'], $giainseritonome);

if (!empty($richiesta)) {
  $_SESSION['regresult'] = -1;
  header('Location: registrazione.php');
  die();
}
if (!empty($richiestanome)) {
  $_SESSION['regresult'] = -2;
  header('Location: registrazione.php');
  die();
}
$query = 'INSERT INTO LogghinV VALUES '."(".insertapici($arr["email"]).", '".$pass."');";
$bool2 = dbinsert($Database, $query);
if (!empty($bool2)) {
  $_SESSION['regresult'] = 1;
} else {
  $_SESSION['regresult'] = -3;
  header('Location: registrazione.php');
  die();
}

$querycrede = requestquery("Nome", "LogghinV", "Nome = ".insertapici($arr["email"]));
if (empty(dbrequest($GLOBALS['db'], $querycrede))) {
  $_SESSION['regresult'] = -3;
  header('Location: registrazione.php');
  die();
}
$queryneg = 'INSERT INTO Negozi VALUES '."(".insertapici($nome).", ".insertapici($arr["email"])." , NULL);";

$bool3 = dbinsert($Database, $queryneg);
if (!empty($bool3)) {
  $_SESSION['regresult'] = 1;
} else {
  $_SESSION['regresult'] = -4;
  $eleminacredenziali ='DELETE FROM "LogghinV" WHERE "Nome" = '.insertapici($arr["email"]);
  dbinsert($GLOBALS['db'], $eleminacredenziali);
  header('Location: registrazione.php');
  die();
}

$queryvendo = requestquery("Nome", "Negozi", "Nome = ".insertapici($nome));

if (empty(dbrequest($GLOBALS['db'], $queryvendo))) {
  $_SESSION['regresult'] = -4;
  $eleminacredenziali ='DELETE FROM "LogghinV" WHERE "Nome" = '.insertapici($arr["email"]);
  dbinsert($GLOBALS['db'], $eleminacredenziali);
  header('Location: registrazione.php');
  die();
}


$querysede = 'INSERT INTO Sede VALUES '."(".insertapici($nome).", NULL , NULL , NULL, NULL);";
$bool4 = dbinsert($Database, $querysede);
if (!empty($bool4)) {
  $_SESSION['regresult'] = 1;
} else {
  $_SESSION['regresult'] = -5;
  $eleminacredenziali ='DELETE FROM "LogghinV" WHERE "Nome" = '.insertapici($arr["email"]);
  dbinsert($GLOBALS['db'], $eleminacredenziali);
  $eleminanegozi ='DELETE FROM "Negozi" WHERE "Nome" = '.insertapici($nome);
  dbinsert($GLOBALS['db'], $eleminanegozi);
  header('Location: registrazione.php');
  die();
}

$querysede  = requestquery("Azienda", "Sede", "Azienda = ".insertapici($nome));
if (empty(dbrequest($GLOBALS['db'], $querysede))) {
  $_SESSION['regresult'] = -5;
  $eleminacredenziali ='DELETE FROM "LogghinV" WHERE "Nome" = '.insertapici($arr["email"]);
  dbinsert($GLOBALS['db'], $eleminacredenziali);
  $eleminanegozi ='DELETE FROM "Negozi" WHERE "Nome" = '.insertapici($nome);
  dbinsert($GLOBALS['db'], $eleminanegozi);

  header('Location: registrazione.php');
  die();
}

header('Location: registrazione.php');

?>
