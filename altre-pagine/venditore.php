<?php
session_start();
if (!isset($_GET['Nome']) || empty($_GET['Nome']) || strlen($_GET['Nome']) > 45) { // SESSION['regione'] ? Dove viene instanziato?;
    header('Location: venditori.php?pag=1'); // Non c'é il nome del venditore. Come ci é arrivato qui l'utente?
    die();
}
require_once '../function.php';
settaregione();
$temp='<link rel="stylesheet" type="text/css" href="../css/venditore-smartphone.css" media="handheld, screen and (max-width:1023px)"/>
    <link rel="stylesheet" type="text/css" href="../css/venditore-desktop.css" media="screen and (min-width:1024px)"/>
    <link rel="stylesheet" type="text/css" href="../css/venditore(print).css" media="print"/>
    ';

$noscript = '<link rel="stylesheet" type="text/css" href="../css/venditore(noscript).css"/>';

$_GET = striparray($_GET);
$vquery = requestquery("*", "Negozi INNER JOIN Sede ON Negozi.Nome = Sede.Azienda", "Nome = ".insertapici($_GET['Nome']));
$venditore = dbrequest($GLOBALS['db'], $vquery);
if ($venditore == FALSE) {
	$_SESSION['vaiaerror'] = 'venditore';
	$_SESSION['specificerror'] = 'Venditore non trovato';
  vaia('index.php');
}
$dativ = &$venditore[0];
$immagine = "../img/negozi/default-user.png";
$extvendorimg = estraiImmagine("../img/negozi/", $dativ['Nome']);
if (!is_numeric($extvendorimg)) {
	$immagine = "../img/negozi/".$extvendorimg;
}


$contquery = requestquery("COUNT(Prodotti.ID) AS NUMERO", "Prodotti", "Negozio = ".insertapici($_GET['Nome']));
$sexion = "";
$union = "";
if ($_SESSION['regione'] == "-") {
  $elementiquery = 'SELECT * FROM Prodotti WHERE Negozio ='.insertapici($_GET['Nome']).'ORDER BY ID DESC';
} else {
  if ($_SESSION['provincia'] == "-") {
    $sexion = 'LIKE "%'.$_SESSION['regione'].'%" OR Raggio.ID = 0 ';
  } else {
    $sexion = 'LIKE "%'.$_SESSION['regione'].'%" OR Raggio.Province LIKE "%'.$_SESSION['provincia'].'%" OR Raggio.ID = 0';
  }
  $elementiquery = 'SELECT Prodotti.ID, Nome, Certificazione, Prezzo, Negozio, Categoria, Descrizione
  FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID WHERE Prodotti.Negozio = '.insertapici($_GET['Nome']).' A'.'ND ( Raggio.Regione
  '.$sexion.')';
  $union = 'SELECT DISTINCT Prodotti.ID, Nome, Certificazione, Prezzo, Negozio, Categoria, Descrizione
  FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID WHERE Prodotti.Negozio = '.insertapici($_GET['Nome']).' AND Prodotti.ID NOT IN
  (SELECT Prodotti.ID FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID WHERE Prodotti.Negozio = '.insertapici($_GET['Nome']).' AND ( Raggio.Regione
  '.$sexion.'))';
}
$proarr = elementipg($contquery, $elementiquery, $union, 1, 8);
if($proarr[0] < 0 && $proarr[0] >-3) {
  $_SESSION['specificerror'] = 'Errore del Server';
  $_SESSION['vaiaerror'] = 'venditore';
  vaia("../index.php");
}
require_once 'sliderorfascia.php';
if ($provend != "") {
  $provend = '
  <div class="StackLine"></div>

  <h2>Prodotti</h2>

  <div id="slider_cont">
    '.$provend.'
  </div>';

}

$keyarr = array(); // Per le keyword
if(!empty($proarr) && !empty($proarr[2])) {
  foreach ($proarr[2] as $key => $dinuovo) {
    if (array_key_exists("Categoria" ,$proarr[2][$key]) && !in_array($proarr[2][$key]["Categoria"], $keyarr)) {
      $keyarr[] = $proarr[2][$key]["Categoria"];
    }
  }
}

$indirizzo = "".$dativ['Citta'];
if (!empty($dativ['Via'])) {
  $indirizzo.= ", ".$dativ['Via'];
}
if (!empty($dativ['CAP'])) {
  $indirizzo.= ", ".$dativ['CAP'];
}
if ($indirizzo != "") {
  $indirizzo = 'Ci trovi in: <br /> '.$indirizzo;
}
$nome = str_replace("0", " ", $dativ['Nome']);

$titolo = $nome;
$keyword=$nome;
foreach ($keyarr as $key => $value) {
  $keyword .=", Venditore di ".lcfirst($value);
}
$keyword.=', 4Forchette';
$descrizione='Profilo pubblico di ciascun venditore';

include '1header.php';
include 'venditore.html';
include '3footer.html';
?>
