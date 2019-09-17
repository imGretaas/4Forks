<?php
session_start();
/*
Venditori.php é una pagina dinamica che si occupa di mostrare tutti i Venditori e li
mostra in base alla regione (e provincia) scelta e poi tutti gli altri.
include header.html venditori.html e 3footer.html inoltre include function.php (il quale richiama function(Giuse).php)
*/
$elementipg = 12;
if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
    header('Location: venditori.php?page=1');
    die();
}
require '../function.php';
settaregione();
$_GET = striparray($_GET);

$contquery = requestquery("COUNT(Negozi.Nome) AS NUMERO", "Negozi");
$sexion = "";
$union = "";
if ($_SESSION['regione'] == "-") {
  $elementiquery = 'SELECT * FROM Negozi INNER JOIN Sede ON Negozi.Nome = Sede.Azienda';
} else {
  if ($_SESSION['provincia'] == "-") {
    $sexion = 'LIKE "%'.$_SESSION['regione'].' OR Raggio.ID = 0 %"';
  } else {
    $sexion = 'LIKE "%'.$_SESSION['regione'].'%" OR Raggio.Province LIKE "%'.$_SESSION['regione'].'OR Raggio.ID = 0%"';
  }
  $elementiquery = 'SELECT Negozi.Nome, Negozi.Email, Negozi.Descrizione, Sede.Citta, Sede.Via, Sede.CAP, Sede.numTel
  FROM ((Sede INNER JOIN Negozi ON Sede.Azienda = Negozi.Nome)
  INNER JOIN Prodotti ON Negozi.Nome = Prodotti.Negozio )
  INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID WHERE Raggio.Regione
  '.$sexion;
  $union = 'SELECT DISTINCT Negozi.Nome, Negozi.Email, Negozi.Descrizione, Sede.Citta, Sede.Via, Sede.CAP, Sede.numTel
  FROM Sede INNER JOIN Negozi ON Sede.Azienda = Negozi.Nome WHERE Negozi.Nome NOT IN
  (SELECT DISTINCT Negozi.Nome FROM ((Sede INNER JOIN Negozi ON Sede.Azienda = Negozi.Nome)
  INNER JOIN Prodotti ON Negozi.Nome = Prodotti.Negozio )
  INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID WHERE Raggio.Regione
  '.$sexion.')';
}
$risultato= elementipg($contquery, $elementiquery, $union ,$_GET['page'], 12);

if($risultato[0] < 0) {
  if ($risultato[0] == -2) { // page > max(page)
      vaia('venditori.php?page=1');
  } else {
    $_SESSION['vaiaerror'] = 'venditori';
    $_SESSION['specificerror'] = 'Errore del Server';
    vaia("../index.php");
  }
}
$vendors= "";
$fineelem = FALSE;
$immagine = 0;
$negozi = &$risultato[2];
for ($i=0, $cont=0; $i<3 &&!$fineelem ; $i++) {
  $vendors .= '<div class="Row">
  ';
  for ($j=0; $j <4 && !$fineelem ; $j++, $cont++) {
    $nome = str_replace("0", " ", $negozi[$cont]["Nome"]);
    $immagine = estraiImmagine("../img/negozi/", $negozi[$cont]["Nome"]);
    if (!is_numeric($immagine)) {
      $vendors.='<div>
    	  <a href="venditore.php?Nome='.$negozi[$cont]["Nome"].'">
          <img alt="'.$nome.".".'" src="../img/negozi/'.$immagine.'"/>
        </a>
    		<a href="venditore.php?Nome='.$negozi[$cont]["Nome"].'">
          <h2>'.$nome.'</h2>
        </a>
    	  <p>'.$negozi[$cont]["Citta"].'</p>
    	  <p>'.$negozi[$cont]["CAP"].'</p>';
        if (!empty($negozi[$cont]["numTel"])) {
          $vendors.='
          <p>tel: 049 650645</p>
          ';
        }
        $vendors.='
      </div>
      ';
    } else {
      $j--;
    }
    if ($cont == (count($risultato[2]) -1)) {
      $fineelem = TRUE;
    }
  }
  $vendors .= '</div>
  ';
}


// CREO I LINK alle pagine successive
$link = "";
if ($risultato[1] > 1){
  $link = '<div id="linkcont">
  <div class="succconteiner">';
  for ($i=0; $i <10 ; $i++) {
    if ($_GET['page'] -5 +$i > 0 && $_GET['page']-5+$i<= $risultato[1]) {
      if ($i == 5) {
        $link.='
        <p id="actualpage">'.$_GET['page'].'</p>';
      } else {
        $link.= stampalink($_GET['page'] -5 +$i, "venditori.php");
      }
    }
  }
  $link.='
  </div>
  </div>
  ';
}

$titolo='Venditori';
$keyword='venditori';
$descrizione='Pagina Generale dei Venditori';

$temp='<link rel="stylesheet" type="text/css" href="../css/venditori-smartphone.css" media="handheld, screen and (max-width:1023px)"/>
<link rel="stylesheet" type="text/css" href="../css/venditori-desktop.css" media="screen and (min-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../css/venditori(print).css" media="print"/>
';
include '1header.php';
include 'venditori.html';
include '3footer.html';
/*
echo "Get = ";
print_r($_GET);
echo "<br>risultato = ";
print_r($risultato);
*/
?>
