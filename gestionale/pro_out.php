<?php
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['noauth']) || $_SESSION['auth'] !== TRUE || $_SESSION['noauth'] != -1 || !isset($_POST['inserisci']) || (!isset($_SESSION['proprietario']) || empty($_SESSION['proprietario']))) {
  session_unset();
  session_destroy();
  setcookie('4FLogErr', "TRUE", time()+120);
  header('Location: login.php');
}
require_once '../basefunction.php';
striparray($_POST);
print_r ($_FILES);

$cat = categorie();         // Tabella Categorie da SQL
$pro = province(TRUE);      // TABELLA Province da SQL
$arr = array();             // Creazione array per funzione controllarray
$arr['nome'] = str_replace(" ", "0", trim(ucfirst(strtolower($_POST["prodotto"]))));
$arr['Inserimento'] = date('Y-m-d', time());

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
$arr['certificazione'] = strtoupper($_POST["certificazione"]);

if (!empty($_POST['regioni'])) { // Regioni & Province hanno una funzione di controllo dedicata
  $regioni = $_POST['regioni'];
  $arr['regioni'] = $regioni;
}
if (in_array(FALSE, $result) || in_array(0, $result)) { // Errore di tipo dati inseriti
  $_SESSION['insproer'] = $result;
  $_SESSION['ritornero'] = $arr;
  vaia("prodotto.php");
}

$controllo = controlloraggio($pro, $regioni, $province);
if ($controllo['P'] == "NESSUNA PROVINCIA" && $controllo['R'] == "NESSUNA REGIONE" ) { // Errore: dove lo vendiamo sto prodotto?
  $_SESSION['raggio'] = "Nessun raggio";
  $_SESSION['ritornero'] = $arr;
  vaia("prodotto.php");
}

if (!($controllo["P"] == "OK" || $controllo['P'] == "NESSUNA PROVINCIA") || !($controllo['R'] == "NESSUNA REGIONE" || $controllo["R"] == "OK" )) {
  $_SESSION['raggio'] = $controllo["R"].$controllo["P"]; // Errore nell'esistenza delle regioni/province indicate
  $_SESSION['ritornero'] = $arr;
  //vaia("prodotto.php");
}



$coerenza = coerenzaraggio($pro, $province, $regioni);  // Elimina eventuali Province contenute in Regioni
$id = databaseraggio($coerenza[1], $coerenza[2]);
// Controlla se esiste giá un raggio con le province/regioni elencate altrimenti lo crea
$arr['Raggio'] = $id;
unset($arr['desc']);
$nuovoarr = array();
foreach ($arr as $key => $value) {
  if ($key != "prov" && $key != "regioni"){
        $nuovoarr[ucfirst($key)] = $value;
  }
}
$nuovoarr['Negozio'] = str_replace(" ", "0",$nuovoarr['Negozio']);
unset($arr);


if (coerenzaprodotto($nuovoarr['Nome'], $nuovoarr['Negozio'])) {
  // Errore di copia: é giá stato inserito da questo negozio un prodotto con lo stesso nome
  $_SESSION['insproer'] = "giainserito";
  $_SESSION['ritornero'] = $nuovoarr;
  vaia("prodotto.php");
}
$richiesta = insertquery($nuovoarr, "Prodotti", FALSE);
echo "<br>$richiesta<br><br>";
if(dbinsert($GLOBALS['db'] , $richiesta)){
  $come = "Nome = ".insertapici($nuovoarr["Nome"])." AND Inserimento = ".insertapici($nuovoarr['Inserimento']);
  $come.=" AND Negozio = ".insertapici(str_replace(" ", "0",$nuovoarr['Negozio']))." LIMIT 1";
  $idrequest = requestquery("ID", "Prodotti", $come);
  $idris = dbrequest($GLOBALS['db'], $idrequest);
  if (!$idris) {
    echo "Errore nella richiesta al server";
  } else {
    $risultato = fileimage($_FILES['foto'], "../img/product/", $idris[0]['ID']);
  }
} else {
  echo "Errore nella richiesta al server";
}

$querycontrollo = requestquery("ID", "Prodotti", "Nome = ".insertapici($nuovoarr["Nome"])." AND Inserimento =".insertapici($nuovoarr['Inserimento']));
if (empty(dbrequest($GLOBALS['db'], $querycontrollo))) {
  $_SESSION['insproer'] = "server";
  $_SESSION['ritornero'] = $nuovoarr;
  vaia("prodotto.php");
}

$_SESSION['insproer'] = 0;
vaia('prodotto.php');
 ?>
