<?php
session_start();

/*
Categoria.php é una pagina dinamica che si occupa di mostrare tutti i prodotti di una singola categoria e li
mostra in base alla regione (e provincia) scelta e poi tutti gli altri.
include header.html venditori.html e 3footer.html inoltre include function.php (il quale richiama function(Giuse).php)
*/

$elementipg = 12;
if (!isset($_GET['cat']) || !isset($_GET['page'])) {
  header('Location: categorie.php');
  die();
}
$all = FALSE; // il controllo su regione é fatto per evitare link con perdita di session

if (isset($_GET['all']) && !empty($_GET['all']) && $_SESSION['regione'] != '-') {
  $all = TRUE;
} // PULSANTE REGIONE

require_once "../function.php";
settaregione();
// Passare piú parametri con un link GET: pizze.php?cat=pizze&pag=2
$temp='<link rel="stylesheet" type="text/css" href="../css/categoria-smartphone.css" media="handheld, screen and (max-width:1023px)"/>
    <link rel="stylesheet" type="text/css" href="../css/categoria-desktop.css" media="screen and (min-width:1024px)"/>
    <link rel="stylesheet" type="text/css" href="../css/categoria(print).css" media="print"/>
    ';

$_GET = striparray($_GET);
// FARE CONTROLLI DI COERENZA SU GET

$sexion = "";
if ($_SESSION['regione'] == "-") {
  $elementiquery ='SELECT * FROM `Prodotti` WHERE Categoria  = '.insertapici(ucfirst($_GET['cat']));
} else {
  if ($_SESSION['provincia'] == "-") {
    $sexion = 'A'.'ND (Raggio.Regione LIKE "%'.$_SESSION['regione'].'%" OR Raggio.ID = 0)';
  } else {
    $sexion = 'A'.'ND (Raggio.Regione LIKE "%'.$_SESSION['regione'].'%" OR Raggio.Province LIKE "%'.$_SESSION['provincia'].'%" OR Raggio.ID = 0 )';
  }
}

if ($all == TRUE) {
  $querycont='SELECT COUNT(Prodotti.ID) AS NUMERO FROM Prodotti WHERE Categoria ='.insertapici(ucfirst($_GET['cat']));
} else {
  $querycont='SELECT COUNT(Prodotti.ID) AS NUMERO FROM Prodotti INNER JOIN Raggio On Prodotti.Raggio = Raggio.ID WHERE Categoria ='.insertapici(ucfirst($_GET['cat'])).'
 '.$sexion;
}

$union="";
$richieste = "Prodotti.ID, Nome, Certificazione, Prezzo, Negozio, Categoria, Descrizione ";
if ($_SESSION['regione'] == "-") {
  $elementiquery ='SELECT '.$richieste.' FROM `Prodotti` WHERE Categoria  = '.insertapici(ucfirst($_GET['cat']));
} else {
  if ($all == TRUE){

    // FLAG mi serve poi per discriminare quali sono della UNION e quali no
    $richieste.= ', regione, province';
    $union = 'SELECT '.$richieste.', Raggio.ID as FLAG FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID WHERE Categoria  = '.insertapici(ucfirst($_GET['cat'])).'A'.'ND Prodotti.ID NOT IN (
      SELECT Prodotti.ID FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID
      WHERE Prodotti.Categoria = '.insertapici(ucfirst($_GET['cat'])).' '.$sexion.'
    )';
    $richieste.= ", Categoria AS FLAG";
  }
  $elementiquery = 'SELECT '.$richieste.' FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID
  WHERE Prodotti.Categoria = '.insertapici(ucfirst($_GET['cat'])).' '.$sexion;
}

if ($_GET['page'] > 1) {
  $array = elementipg($querycont, $elementiquery, $union, $_GET['page'], 8);
  $primipro = "";
} else {
  $array = elementipg($querycont, $elementiquery, $union ,1, 8);
  $altquery = 'SELECT * FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID
  WHERE Prodotti.Categoria = '.insertapici(ucfirst($_GET['cat'])).' AND ( Raggio.Regione '.$sexion.' )
  ORDER BY Prodotti.ID LIMIT 4';
  $where = 'Prodotti.Categoria = '.insertapici(ucfirst($_GET["cat"])).' A'.'ND ( Raggio.Regione '.$sexion.')';
  $primiq = requestquery("*" , "Prodotti" , $where , "ID DESC LIMIT 4");
  $primi = dbrequest($GLOBALS['db'], $primiq);
  $primipro = "";
  if ($primi != FALSE) {
    $contatore = 0;
    foreach ($primi as $key => $value) { // GENERAZIONE PRIMI PRODOTTI
      if (!in_array_r($value['ID'], $array)) {
        $contatore++;
        $nome = str_replace("0", " ", $value['Nome']);
        $img = estraiImmagine("../img/product/", $value['ID']);
        if (!is_numeric($img)) {
          $primipro.='<div>
            <a href="prodotto.php?ID='.$value['ID'].'">
              <div>
                <p>&#8364;'.$value['Prezzo'].'</p>
                <img src="../img/product/'.$img.'" alt="" />
                <p>Scopri di pi&#249;</p>
              </div>
            </a>
              <a href="#1">
                <h1>'.$nome.'</h1>
              </a>
          </div>
          '; // id="margherita"
        }
      }
      if ($contatore != 0) {
        $primipro = '<div class="Row">
        '.$primipro.'
        </div> <!--- chiusura row --->
        ';
      }
    }
  } // FINE GENERAZIONE PRIMI PRODOTTI
}

if($array[0] < 0) {
  if ($array[0] == -2) { // pag > max(pag)
      $link = "categoria.php?cat=".$_GET['cat']."&page=1";
      vaia($link);
  } else { // cat é inesistente
    vaia("categorie.php");
  }
}

$prodotti=""; // GENERAZIONE STRINGA DI PRODOTTI NORMALI
$nome = "";
$end = FALSE;
$altriunion= FALSE;

foreach ($array[2] as $key => $value) {
  if ($key % 4 == 0) {
    if ($key != 0) {
      $prodotti .= '</div> <!--- chiusura row --->
    ';
      $end = FALSE;
    }
    //if ($key != floor($key/4) ) {
      $prodotti .= '<div class="Row">
      ';
      $end = TRUE;
  }
  $nome = str_replace("0", " ", $value['Nome']);
  $img = estraiImmagine("../img/product/", $value['ID']);
  if (!is_numeric($img)) {
    $prodotti.='<div>
      <a href="prodotto.php?ID='.$value['ID'].'">
        <div>
          <p>&#8364;'.$value['Prezzo'].'</p>
          <img src="../img/product/'.$img.'" alt="" />
          <p>Scopri di pi&#249;</p>
        </div>
      </a>
        <a href="prodotto.php?ID='.$value['ID'].'">
          <h1>'.$nome;
    if($all == TRUE && is_numeric($value['FLAG'])) {
      $prodotti.='<span>*</span>';
      $altriunion = TRUE;
    }
    $prodotti.='</h1>
        </a>
    </div>
  '; // id="margherita"
  }
}
if ($end == TRUE) {
  $prodotti .= '</div> <!--- chiusura row --->
  ';
} // FINE GENERAZIONE PRODOTTI NORMALI

// CREO I LINK alle pagine successive
$link ="";
if ($array[1] > 1){
  $link = '<div id="linkcont">
  <div id="succconteiner">';
  for ($i=0; $i <10 ; $i++) {
    if ($_GET['page'] -5 +$i > 0 && $_GET['page']-5+$i<= $array[1]) {
      if ($i == 5) {
        $link.='
        <p id="actualpage">'.$_GET['page'].'</p>';
      } else {
        if ($all == TRUE) {
          $link.= stampalink($_GET['page'] -5 +$i, "categoria.php", 'cat='.$_GET['cat'], TRUE);
        } else {
          $link.= stampalink($_GET['page'] -5 +$i, "categoria.php", 'cat='.$_GET['cat']);
        }
      }
    }
  }
  $link.='
  </div>
  </div>
  ';
}
$titolo = str_replace("0", " ", $_GET['cat']);
if ($altriunion == TRUE) {
  $link.="<p><span>*</span> Prodotti non disponibili nella tua regione";
  if ($_SESSION['provincia'] != "-") $link.= " e provincia";
  $link.="</p>";
}

$linkall = "";
if ($_SESSION['regione'] != "-") {
  if ($all == TRUE) {
    $linkall = '<a href="categoria.php?cat='.$_GET['cat']."&page=".$_GET['page'].'" >
    Visualizza prodotti disponibili solo nella tua regione/provincia</a>';
  } else {
    $linkall = '<a href="categoria.php?cat='.$_GET['cat']."&page=".$_GET['page'].'&all=1" >
    Visualizza prodotti non disponibili nella tua regione/provincia</a>';
  }
}
$cat = ucfirst(str_replace("0", " ", $_GET['cat']));
$gruppo = appartienea(lcfirst($_GET['cat']));

$keyword=$titolo.', 4Forchette';
$descrizione='Pagina relativa alla categoria '.strtolower($titolo);

include '1header.php'; // richiama function
include 'categoria.html';
include '3footer.html';
?>
