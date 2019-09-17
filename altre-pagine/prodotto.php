<?php
session_start();
$model = '/^[0-9]{1,10}$/ ';
preg_match($model, $_GET['ID'], $matches);
if (!isset($_GET['ID']) || empty($matches)) { // SESSION['regione'] ? Dove viene instanziato?
		$_SESSION['vaiaerror'] = 'prodotto';
		$_SESSION['specificerror'] = 'Link non valido';
    header('Location: ../index.php'); // Non c'é id. Come ci é arrivato qui l'utente?
    die();
}
$id = $_GET['ID'];

require_once '../function.php';
$esistenzaregione = FALSE;
$casoparticolare = FALSE;
if (isset($_SESSION['regione']) && isset($_POST['regione'])) $esistenzaregione = TRUE;
if($esistenzaregione == TRUE && (($_POST['provincia'] != $_SESSION['provincia'] && $_SESSION['provincia'] != "-") ||
($_POST['regione'] != $_SESSION['regione'] && $_SESSION['regione'] != "-")) && !isset($_POST['Compra'])) {
	$casoparticolare = TRUE;
}

if ($esistenzaregione == TRUE && !empty($_POST['Compra']) && $_POST['Compra'] == "AGGIUNGI AL CARRELLO" && empty($_GET['err']) ) {
	//if (empty($_SESSION['provincia'])) $_SESSION['provincia'] = $_POST['provincia'];
	if (!empty($_POST['regione']) && ($_SESSION['regione'] != $_POST['regione'] || $_SESSION['provincia'] != $_POST['provincia'])) {
		$link = "prodotto.php?ID=$id&err=1#middleregione";
		vaia($link);
	}
	$_SESSION['cart'][] = array('ID' => $_POST['ID'], 'quantita' => $_POST['quantita']);
	$_SESSION['vaiaerror'] = "prodotto: ";
	$_SESSION['specificerror'] = "Prodotto aggiunto al carrello";
	$_SESSION['positivo'] = TRUE;
	$_SESSION['paga'] = FALSE;

	// questo é relativo a cart.php
	vaia("../index.php");
}

if (isset($_POST['quantita']) && is_numeric($_POST['quantita']) && $_POST['quantita'] < 21) {
	$quantita = $_POST['quantita'];
} else {
	$quantita = 1;
}


$temp='<link rel="stylesheet" href="../css/prodotto-smartphone.css" media="handheld, screen and (max-width:1023px)"/>
<link rel="stylesheet" type="text/css" href="../css/prodotto-desktop.css" media="screen and (min-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../css/foodSlider.css"/>
<link rel="stylesheet" type="text/css" href="../css/prodotto(print).css" media="print" />
<script src="../js/forms-checks-and-slider.js" defer="defer"></script>
';
$noscript = '<link rel="stylesheet" type="text/css" href="../css/prodotto(noscript).css" media="handheld, screen"/>';
$pq = requestquery("*, Prodotti.ID AS proID, Raggio.ID AS raggioID", "Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID", "Prodotti.ID = $id");
$prodotto = dbrequest($GLOBALS['db'], $pq);
if (!empty($prodotto) && array_key_exists(0, $prodotto) ) {
	$prodotto = $prodotto[0];
} else {
	$_SESSION['vaiaerror'] = 'prodotto'; // Non esiste il tale prodotto
	$_SESSION['specificerror'] = 'Prodotto non trovato';
	vaia('../index.php');
}
$immagine = estraiImmagine("../img/product/", $id);
if (is_numeric($immagine)) {
	$_SESSION['vaiaerror'] = 'prodotto'; // Non esiste il tale prodotto
	$_SESSION['specificerror'] = 'Errore del Server';
	vaia('../index.php');
}
$nome = str_replace("0", " ", $prodotto['Nome']);
$titolo = $nome;
$keyword=$nome.", ".str_replace("0", " ", $prodotto['Categoria']).', 4Forchette';
$descrizione='Pagina prodotti di '.$nome;


$querycont = requestquery("COUNT(Prodotti.ID) AS NUMERO", "Prodotti", "Prodotti.ID != ".insertapici($id)." AND Negozio =".insertapici($prodotto['Negozio']));
$richieste = "Prodotti.ID, Nome, Certificazione, Prezzo, Negozio, Categoria, Descrizione";

$union= "";
$sexion = "";
if (isset($_SESSION['regione']) && $_SESSION['regione'] != "-") {
	$richieste.= ", province, regione";
	if(isset($_SESSION['regione']) && $_SESSION['provincia'] != '-') {
		$sexion = ' A'.'ND (Raggio.regione LIKE "%'.$_SESSION['regione'].'%" OR Raggio.province LIKE "%'.$_SESSION['provincia'].'%" OR Raggio.ID = 0  )';
	} else {
		$sexion = ' A'.'ND Raggio.regione LIKE "%'.$_SESSION['regione'].' OR Raggio.ID = 0 %"';
	}
$unionwhere = ' Prodotti.ID != '.insertapici($id).' AND Negozio ='.insertapici($prodotto['Negozio']).' A'.'ND Prodotti.ID NOT IN ( SELECT Prodotti.ID FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID WHERE Negozio ='.insertapici($prodotto['Negozio']).$sexion.') ';
	$union = requestquery($richieste, "Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID", $unionwhere);
}
$queryele = requestquery($richieste, "Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID", "Prodotti.ID != ".insertapici($id)." AND Negozio =".insertapici($prodotto['Negozio']).$sexion, "Prodotti.ID DESC" );
$proarr = elementipg($querycont, str_replace(';', '', $queryele), str_replace(';', '', $union) , 1, 9);
if($proarr[0] == -1 || $proarr[0] == -2) {
  $_SESSION['vaiaerror'] = 'prodotto';
  $_SESSION['specificerror'] = 'Errore del Server';
  vaia("../index.php");
}


$provend = "";
$cont = 0;
$altercont= "";
$actualid = $prodotto['proID'];

require_once 'sliderorfascia.php';


include '1header.php';

$message = "";
if (isset($_GET['err'])) {
	$message = "Per comprare in un&apos altra;regione, AGGIORNA prima i dati, grazie";
}
$regione = "";
$provincia = "";
$bool = TRUE;
$prodottoreg = explode(", " , $prodotto['Regione']);
if ($prodotto['Raggio'] != 0) {
	if ($_SESSION['regione'] == "-") {
		$message = "Non hai selezionato una regione";
		$bool = FALSE;
	} else {
		if (!in_array($_SESSION['regione'], $prodottoreg)) {
			$arr1 = explode(",", $prodotto['Province']);
			if ($_SESSION['provincia'] == "-") {
				$bool = FALSE;
				$pq = requestquery("*", "province", "1");
				$arrpro = dbrequest($GLOBALS['db'], $pq);
				$milly = FALSE;
				for ($j=0; $j <count($arrpro) && $milly == FALSE ; $j++) {
					if($arrpro[$j]['regione_province'] == $_SESSION['regione'] && in_array($arrpro[$j]['sigla_province'], $arr1)){
						$milly = TRUE;
					}
				}
				if ($milly == FALSE) {
					$message = "Prodotto non disponibile in questa regione";
				} else {
					$message = "Non hai selezionato una provincia";
				}
			} else {
				$contatore = count($arr1);
				$where = "";
				for ($i=0; $i<$contatore ; $i++) {
					$where.= "sigla_province = ".insertapici($arr1[$i]);
					if ($i+1< $contatore) {
						$where.= " OR ";
					}
				}
				$pq = requestquery("nome_province, sigla_province", "province", $where);
				$arrpro = dbrequest($GLOBALS['db'], $pq);
				if (!in_array_r($_SESSION['provincia'], $arrpro)) {
					$message = "Prodotto non disponibile nella tua provincia.";
					$bool = FALSE;
				}
			}
		}
	}
}

if($casoparticolare == TRUE && $message == "") {
	$message = "Cambio regione/provincia effettuato con successo. Per acquistare premere sul tasto Aggiungi al Carrello";
}

$disabled = "";
if ($bool == FALSE) {
	$disabled = 'disabled="disabled"';
}
$regionigiuste = "";
for ($i=0; $i < count($prodottoreg); ++$i) {
	if ($prodottoreg[$i] != "Valle0d0Aosta") {
		$regionigiuste .= str_replace("0", " ", $prodottoreg[$i]);
	} else {
		$regionigiuste .= "Valle d&amp;Aosta";
	}
	if ($i < count($prodottoreg)-1 ) {
		$regionigiuste.= ", ";
	}
}

$middle = "prodotto.php?ID=$id#middleregione";
$vendorlink = "venditore.php?Nome=".$prodotto['Negozio'];
$catlink= "categoria.php?cat=".$prodotto['Categoria']."&page=1";
$denlink= "denominazione.php#".str_replace(" ", "", strtolower($prodotto['Certificazione']));
$imglink = "../img/product/".$immagine;
$negoziante = str_replace("0", " ", $prodotto['Negozio']);
$vendorimg = "../img/negozi/default-user.png";
$extvendorimg = estraiImmagine("../img/negozi/", $prodotto['Negozio']);
if (!is_numeric($extvendorimg)) {
	$vendorimg = "../img/negozi/".$extvendorimg;
}
$gruppo = appartienea(lcfirst($prodotto['Categoria']));
$gruppolink = "categorie.php?cat=".$gruppo;
$gruppo = str_replace("0", " ", $gruppo);
$prodotto['Categoria'] = str_replace("0", " ", $prodotto['Categoria']);

$sliderorfascia = "";
if ($altercont != "" || $provend != "") {
	$sliderorfascia = '
	<div class="StackLine Hide"></div>
	<div id="sliderVend">
		<a href="'.$vendorlink.'"><img src="'.$vendorimg.'" alt="'.str_replace("0", " ", $prodotto['Negozio']).'"/></a>
		<a href="'.$vendorlink.'"><h2> '.str_replace("0", " ", $prodotto['Negozio']).'</h2></a>
		<p>Dallo stesso venditore:</p>
		<!--    Slider                      -->
		<div class="Clearer"></div>
		'.$provend.'
		'.$altercont.'
	</div>
		';
}
include 'prodotto.html';
include '3footer.html';
?>
