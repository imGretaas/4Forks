<?php
session_start();
/*
VALORI DI RITORNO DI Negozio_out in $_SESSION['proup']:
1     Tutto bene
-1    Errore di inserimento nei campi email, pass e password (mail e password devono esserci entrambe)
-2    Errore di coerenza nei dati inseriti ($_SESSION['specerror'] contiene il tipo dell'errore)
-3    Query Cambio credenziali non RIUSCITO
-4    Query Cambio credenziali non RIUSCITO (Query di controllo inserimento fallita)
-5    Query Cambio profilo non RIUSCITO
-6    Query Cambio credenziali non RIUSCITO (Query di controllo inserimento fallita)
-7    Query Cambio sede non RIUSCITO
-8  Query Cambio credenziali non RIUSCITO (Query di controllo inserimento fallita)
da -10 in poi corrispondono ai valori ritornati da fileimage() con ogni errore -10
In caso di errori $_SESSION['ritornero'] contiene i valori per riempire automaticamente i campi input
*/

 // CONTROLLI DI SESSIONE e di Accesso
if (!isset($_SESSION['auth']) || !isset($_SESSION['noauth']) || $_SESSION['auth'] !== TRUE || $_SESSION['noauth'] != -1 || $_POST['modifica'] != "Modifica" || (!isset($_SESSION['proprietario']) || empty($_SESSION['proprietario']))) {
  session_unset();
  session_destroy();
  setcookie('4FLogErr', "TRUE", time()+120);
  vaia('login.php');
}

require_once '../basefunction.php';
striparray($_POST);
striparray($_FILES);
$control = array(); // CONTROLLI DI COERENZA
$control["desc"] = $_POST['descrizioneazienda'];
$control["citta"] = $_POST['citta'];
$control["via"] = $_POST['via'];
$control["cap"] = $_POST['cap'];
if(!empty($_POST['email'])) {
  $control["email"] = $_POST['email'];
}
if (!empty($_POST['tel'])) {
  $control["tel"] = $_POST['tel'];
}
$result = controllarray($control);
$_SESSION['ritornero'] = $control;
$_SESSION['specerror'] = $result;
if (in_array(0, $result) || in_array(FALSE, $result)) {
  $_SESSION['proup'] = -2; //errore di coerenza
  vaia("profilonegozio.php");
}
$desc = "";
$nome = insertapici($_POST['nomenegozio']);
$desc = insertapici($_POST['descrizioneazienda']);
$citta = insertapici(ucfirst($_POST['citta']));
$via = insertapici($_POST['via']);
$cap = insertapici($_POST['cap']);
$tel = "";
$tel = insertapici($_POST['tel']);

$email = $_POST['email'];
$pass = $_POST['password'];
$p2 = $_POST['pass2'];
$cif = insertapici(hash('sha256', $pass));
// CONTROLLO SE NECESSARIO CAMBIO USER & PASSWORD
if ($pass != $p2 || (!empty($email) && empty($pass)) || ((empty($email) && !empty($pass))) ) {
  $_SESSION['proup'] = -1 ; // Errore di inserimento nei campi email, pass e password
  vaia("profilonegozio.php");
}
$newauth = ""; // VERIFICA SE CAMBIO PASSWORD E CREAZIONE QUERY
if (!empty($email) && !empty($pass)) {
  $control = array(); // A Questo punto controllo coerenza credenziali
  $control = ["pass" => $_POST['password'], "passrequestquer" => $_POST['pass2'] ];
  $result = controllarray($control);
  if (in_array(FALSE, $result)) {
    $_SESSION['proup'] = -2 ; //errore di coerenza
    $_SESSION['specerror'] = $result;
    vaia("profilonegozio.php");
  }
  $email = insertapici($email);

  $newauth = "UPDATE LogghinV SET Nome = $email , Credenziali = $cif WHERE Nome = ".insertapici($_SESSION['proprietario'])."; ";
  echo $newauth."<br><br>";

}
$profile = "UPDATE Negozi SET"; // CREO LA QUERY PER NEGOZI
if (!empty($email)) {
  $profile .= " Email = $email, ";
}
if (empty($desc)) {
  $profile .= " Descrizione = NULL";
} else {
  $profile .= " Descrizione = $desc";
}
$profile .= " WHERE Email =".insertapici($_SESSION['proprietario'])."; ";

$sede = "UPDATE Sede SET Citta = $citta, Cap = $cap, Via = $via ,"; // CREO LA QUERY PER SEDE
$cs = "Citta = $citta AND Cap = $cap AND Via = $via";
if ($tel == '\'\'') {
  $sede .= " numTel = NULL";
} else {
  $sede .= " numTel = $tel";
}
$sede .= " WHERE Azienda =".insertapici($_SESSION['negozio'])."; ";

$email2 = $_SESSION['proprietario'];
if ($newauth != "") { // QUERY CREDENZIALI
  $upauth = dbinsert($GLOBALS['db'], $newauth);
  if ($upauth == FALSE) {
    $_SESSION['proup'] = -3; // CAMBIO CREDENZIALI NON RIUSCITO
    header('Location: profilonegozio.php');
    die();
  } else {
    $cosa = "Nome";
    $dove = "LogghinV";
    $come = "Nome = ".$email;
    $query = requestquery($cosa, $dove, $come);
    $controlcred = dbrequest($GLOBALS['db'], $query);
    if (!in_array_r($email2, $controlcred)) {
      $_SESSION['proup'] = -4; // CAMBIO CREDENZIALI NON VERIFICATO
      header('Location: profilonegozio.php');
      die();
    }
  }
}

$uppro = dbinsert($GLOBALS['db'], $profile); // QUERY PROFILO
if ($uppro == FALSE) {
  $_SESSION['proup'] = -5; // CAMBIO PROFILO NON RIUSCITO
 header('Location: profilonegozio.php');
 die();
} else {
  $cosa = "Email";
  $dove = "Negozi";
  $come = "Email = ";
  if($newauth != "") {
    $come.=$email;
  } else {
    $come.=insertapici($_SESSION['proprietario']);
  }
  $query = requestquery($cosa, $dove, $come);
  $controlcred = dbrequest($GLOBALS['db'], $query);
  if (!in_array_r($email2, $controlcred)) {
    $_SESSION['proup'] = -6; // CAMBIO PROFILO NON VERIFICATO
    header('Location: profilonegozio.php');
    die();
  }
}
echo "<br>$sede<br>";
$upsede = dbinsert($GLOBALS['db'], $sede); // QUERY PROFILO
if ($upsede == FALSE) {
  $_SESSION['proup'] = -7; // CAMBIO SEDE NON RIUSCITO
 header('Location: profilonegozio.php');
 die();
} else {
  $cosa = array("Citta","Cap","Via");
  $dove = "Sede";
  $query = requestquery($cosa, $dove, $cs);
  $controlcred = dbrequest($GLOBALS['db'], $query);
  if (!in_array_r($_POST['citta'], $controlcred)) {
    $_SESSION['proup'] = -8; // CAMBIO PROFILO NON VERIFICATO
    header('Location: profilonegozio.php');
    die();
  }
}

$risultato = fileimage($_FILES['logo'], "../img/negozi/", $_SESSION['negozio']);
if ($risultato == 1) {
  $_SESSION['proup'] = 1; // OK Si va avanti
} else {
    $_SESSION['proup'] = ($risultato -10);
}

unset($_SESSION['ritornero']);
header('Location: profilonegozio.php');
 ?>
