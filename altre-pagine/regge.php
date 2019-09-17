<?php
session_start();
if (empty($_POST)) {
  header("Location: registrazione.php");
  die();
}
require "../function.php";
$_SESSION['Ritornero'] = striparray($_POST);
$controlla = $_SESSION['Ritornero'];
$result = controllarray($controlla);
if ($controlla['pass'] != $controlla['confirm-password']) {
  $result['pass'] = 0;
} else {
  $result['pass'] = 1;
}
if (!checkdate($controlla['mese'], $controlla['giorno'], $controlla['anno'])) {
  $result['giorno'] = 0;
  $result['mese'] = 0;
  $result['anno'] = 0;
} else {
  $result['giorno'] = 1;
  $result['mese'] = 1;
  $result['anno'] = 1;
}
$confirmprov = requestquery("sigla_province", "province", "sigla_province = ".insertapici($controlla['provincia']));
if(empty(dbrequest($GLOBALS['db'], $confirmprov))) {
  $result['provincia'] = 0;
} else {
  $result['provincia'] = 1;
}
$_SESSION['Specerror'] = $result;
if (in_array(0, $result) || in_array(FALSE, $result)) {
  vaia("registrazione.php");
}
$pass = hash('sha256', $controlla['email']);
$credearray = array('Nome' => $controlla['nome'] , "Credenziali" => $pass );
$credequery = insertquery($credearray, "LogghinC", TRUE);
$altramail = requestquery("Nome", "LogghinC", "Nome = ".insertapici($controlla['email']));
if (dbrequest($GLOBALS['db'], $altramail)) {
  $_SESSION['Numerror'] = 0; // "Email gia registrata";
}
if (!dbinsert($GLOBALS['db'], $credequery)) {
  $_SESSION['Numerror'] = -1; // "Fallito inserimento credenziali";
}
if (dbrequest($GLOBALS['db'], $altramail)) {
  $_SESSION['Numerror'] = -1; // "Fallito inserimento credenziali";
}

$data= $controlla['anno']."-".$controlla['mese']."-".$controlla['giorno'];
$utentearr = array (
  'Email' => $controlla['email'],
  'Nome' => $controlla['nome'],
  'Cognome' => $controlla['cognome'],
  'Datanascita' => $data
);
$utentequery = insertquery($utentearr, "Cliente", FALSE);
$utenteconf = requestquery("Email", "Cliente", "Email = ".insertapici($controlla['email'])) ;

$removecrede = deletequery("LogghinC", "Nome = ".insertapici($controlla['email']));
if(!dbinsert($GLOBALS['db'], $utentequery) || !dbrequest($GLOBALS['db'], $utenteconf)) {
  dbinsert($GLOBALS['db'], $removecrede);
  $_SESSION['Numerror'] = -2; // "Fallito inserimento cliente";
  echo $utentequery."<br>";
  die();
  vaia("registrazione.php");
}

$recapitoarr = array(
  'Proprietario' => $controlla['email'],
  'Citta' => $controlla['citta'],
  'Via' => $controlla['via'],
  'CAP' => $controlla['cap'],
  'Provincia' => $controlla['provincia']
);
if(!empty($controlla['tel'])) {
  $recapitoarr['numTel'] = $controlla['tel'];
}
$recapitoquery = insertquery($recapitoarr, "Recapito");
$recapitoconf = requestquery("Proprietario", "Recapito", "Proprietario = ".insertapici($controlla['email']));
$removecliente = deletequery("Cliente", "Email = ".insertapici($controlla['email']));
if(!dbinsert($GLOBALS['db'], $recapitoquery) || !dbrequest($GLOBALS['db'], $recapitoconf)) {
  dbinsert($GLOBALS['db'], $removecliente);
  dbinsert($GLOBALS['db'], $removecrede);
  $_SESSION['Numerror'] = -3; // "Fallito inserimento in Recapito";
  vaia("registrazione.php");
}

unset($_SESSION['Ritornero']);
$_SESSION['email'] = $controlla['email'];
vaia("Profilo.php");
//vaia("profilo.php");
?>
