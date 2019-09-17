<?php
/*
VALORI DI RITORNO DI modifica.php in $_SESSION['modproer']:
1     Tutto bene
noninserito     Errore nella query di Inserimento
nonconfermato   Errore nella query di conferma
Nessun raggio   Nessun raggio inserito
array()         che contiene l'errore di tipo/coerenza dell'inserimento

In caso di errori $_SESSION['ritornero'] contiene i valori per riempire automaticamente i campi input
*/
session_start();
require_once "../basefunction.php";
if (!isset($_SESSION['auth']) || !isset($_SESSION['noauth']) || $_SESSION['auth'] !== TRUE || $_SESSION['noauth'] != -1 || empty($_SESSION['negozio']) || !array_key_exists("modifica", $_POST) ) {
  session_unset();
  session_destroy();
  setcookie('4FLogErr', "TRUE", time()+120);
  header('Location: login.php');
  die();
}
striparray($_POST);
if(strpos($_POST['id'], ",")) {
  $tmparr = explode("," , $_POST['id']);
  $id = $tmparr[0];
  $raggio = $tmparr[1];
} else {
  $id = $_POST['id'];
  $raggio = FALSE;
}
$cat = categorie();         // Tabella Categorie da SQL
$pro = province(TRUE);      // TABELLA Province da SQL
$arr = array();             // Creazione array per funzione controllarray
$arr['nome'] = str_replace(" ", "0", trim(ucfirst(strtolower($_POST["prodotto"]))));
$arr['Inserimento'] = date('Y-m-d', time());
$arr['certificazione'] = str_replace(' ', '', strtoupper($_POST["certificazione"]));
$arr['prezzo'] = $_POST["prezzo"];
$sottocategorie = $_POST["sottocategoria"];
if(!empty($_POST["descrizionepro"])) { // DEscrizione é facoltativa
    $arr['desc'] = $_POST["descrizionepro"];
}
$arr['Negozio'] = $_SESSION['negozio'];
$arr['Categoria'] = $sottocategorie;
$arr['Descrizione'] = $arr['desc'];
$province = "";
$regioni = "";
if (!empty($_POST['province'])) { // Province é facoltativa
  $province = $_POST['province'];
  $arr['prov'] = $province;
}
$result = controllarray($arr); // Controlla il tipo dell'input dato

$_SESSION['ritornero'] = $arr; // Risparmio righe di codice mettendoli solo qui. Se non servono li unsetto alla fine
$_SESSION['ritornero']['id'] = $id;
$_SESSION['ritornero']['raggio'] = $raggio;

if (!empty($_POST['regioni'])) { // Regioni & Province hanno una funzione di controllo dedicata
  $regioni = $_POST['regioni'];
  $arr['regioni'] = $regioni;
}
if (in_array(FALSE, $result) || in_array(0, $result)) { // Errore di tipo dati inseriti
  $_SESSION['modproer'] = $result;
  vaia("sicuro.php");
}
$controllo = controlloraggio($pro, $regioni, $province);
if ($controllo['P'] == "NESSUNA PROVINCIA" && $controllo['R'] == "NESSUNA REGIONE" ) { // Errore: dove lo vendiamo sto prodotto?
  $_SESSION['modproer'] = "Nessun raggio";
  vaia("sicuro.php");
}
if (!($controllo["P"] == "OK" || $controllo['P'] == "NESSUNA PROVINCIA") || !($controllo['R'] == "NESSUNA REGIONE" || $controllo["R"] == "OK" )) {
  $_SESSION['modproer'] = $controllo["R"].$controllo["P"]; // Errore nell'esistenza delle regioni/province indicate
  vaia("sicuro.php");
}
//echo "<br><br> Regioni = ";
$coerenza = coerenzaraggio($pro, $province, $regioni);  // Elimina eventuali Province contenute in Regioni
$raggio = databaseraggio($coerenza[1], $coerenza[2]);
//echo "Coerenza = ";
//print_r($coerenza);
$arr['Raggio'] = $raggio;
unset($arr['desc']);

$nuovoarr = array();
foreach ($arr as $key => $value) {
  if ($key != "prov" && $key != "regioni"){
        $nuovoarr[ucfirst($key)] = $value;
  }
}
unset($nuovoarr['Negozio']);
$richiesta = updatequery($nuovoarr, "Prodotti", "ID = ".$id);
if(dbinsert($GLOBALS['db'] , $richiesta)){
  $come = "ID = ".$id;
  $idrequest = requestquery("*", "Prodotti", $come);
  $idris = dbrequest($GLOBALS['db'], $idrequest);
  if (!$idris) {
    echo "Errore nella richiesta al server";
  } else {
    foreach ($nuovoarr as $key => $value) {
      if (!in_array_r($value, $idris)) { // ERRORE nel controllo della query
        $_SESSION['modproer'] = "nonconfermato";
        vaia("sicuro.php");
      }
    }
    $risultato = fileimage($_FILES['foto'], "../img/product/", $idris[0]['ID']);
    if($risultato != 1) {
      $_SESSION['modproer'] = "erroreimmagine";
      $_SESSION['ritornero']['errimg'] = $risultato;
      vaia("sicuro.php");
    }
  }
} else {
  $_SESSION['modproer'] = "noninserito";
  vaia('sicuro.php');
}
$_SESSION['modproer'] = 1;
unset($_SESSION['ritornero']);
vaia('modprodotto.php');
?>
