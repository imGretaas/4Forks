<?php
session_start();
require_once('../function.php');


if (empty($_SESSION['mdp']) && empty($_POST['query'])) {
	$_SESSION['vaiaerror'] = 'ricerca: ';
	$_SESSION['specificerror'] = 'Link non valido';
	header("Location: ../index.php");
  die();
}
if (empty($_POST['query'])) {
	$query = $_SESSION['mdp']['query'];
} else {
	$query = $_POST['query'];
}

$cercato ="../index.php";
if (!empty($_POST['search'])) {
	$cercato = "ricerca.php?search=".$_POST['search'];
}
require_once('../function.php');
settaregione();

$ricercaoriginale = "";
if (!empty($_SESSION['mdp'])) {
	$ricercaoriginale = $_SESSION['mdp']['ricerca'];
	if (strpos($cercato, "index") !== FALSE) {
		$cercato = "ricerca.php?search=".$_SESSION['mdp']['ricerca'];
	}
	if( !empty($_SESSION['mdp']['regione']) && !empty($_SESSION['mdp']['provincia']) ) {
		if ($_SESSION['mdp']['regione'] != $_SESSION['regione'] || ($_SESSION['mdp']['provincia'] != $_SESSION['provincia'] &&
				$_SESSION['provincia'] != "-")) {
				vaia($cercato);
		}
	}
}


if (strpos($query, "SELECT") === FALSE || strpos($query, "FROM") === FALSE || strpos($query, "WHERE") === FALSE) {
	$_SESSION['vaiaerror'] = 'ricerca: ';
	$_SESSION['specificerror'] = 'Link non valido';
	header("Location: ../index.php");
  die();
}

$ricerca = " la tua ricerca";
$ricercalink = "";
if(!empty($_POST['ricerca'])) {
	$ricerca= ": ".$_POST['ricerca'];
	$ricercaoriginale = $_POST['ricerca'];
	$ricercalink = '
	<li><a href="ricerca.php?search='.$ricerca.'">Ricerca</a></li>
	';
}
$page = 1;
if (!empty($_POST['page'])) {
	$page = $_POST['page'];
}
if (!empty($_SESSION['mdp']) && !empty($_SESSION['mdp']['tipologia'])) {
	$tipologia = $_SESSION['mdp']['tipologia'];
} else {
	$tipologia = "Prodotti";
	if (!empty($_POST['categorie'])) {
		$tipologia = "Categorie";
	} else if(!empty($_POST['venditori'])) {
		$tipologia = "Negozi";
	} else if(!empty($_POST['tipologia'])) {
		$tipologia = $_POST['tipologia'];
	}
}

$tab = "Prodotti.ID";
$continizio = "COUNT(Prodotti.ID) AS NUMERO ";
$from = "Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID ";
switch ($tipologia) {
	case 'Categorie':
	$continizio = "COUNT(Categorie.Nome) AS NUMERO ";
	$tab = "Categorie.Nome";
	$from = $tipologia;
	break;

	case 'Negozi':
	$tab = "Negozi.Nome";
	$continizio = "COUNT(Negozi.Nome) AS NUMERO ";
	$from = $tipologia;
	break;
}

$whereregione = strpos($query, "Raggio.Regione");
if ($whereregione !== FALSE) {
	$lenght = ($whereregione-5) - (strpos($query, "WHERE")+5);
	$fromwhere = substr($query, strpos($query, "WHERE")+5, $lenght);
} else {
	$fromwhere = substr($query, strpos($query, "WHERE")+5);
}
$fromwhere = str_replace(")","",$fromwhere);
$sexion = "";
if ($_SESSION['provincia'] != "-") {
	// Provincia e regione
	$sexion = " A"."ND (Raggio.ID = ".insertapici(0).' OR Raggio.Regione LIKE "%'.$_SESSION['regione'].'%" OR
	Raggio.Province LIKE  "%'.$_SESSION['provincia'].'%" )';
} else if($_SESSION['regione'] != "-") {
	// solo regione
	$sexion = " A"."ND (Raggio.ID = ".insertapici(0).' OR Raggio.Regione LIKE "%'.$_SESSION['regione'].'%")';
}

$ris = ricercapg($query, $page, 12);

if ($ris[0] < 0) {
	$_SESSION['vaiaerror'] = 'ricerca avanzata: ';
	$_SESSION['specificerror'] = 'Errore del Server';
	vaia("../index.php");
}
$bool = FALSE;
$elementi = "";
$k =0;
if($tipologia =="Prodotti") {
	for ($i=0; $i <3 && $bool == FALSE ; $i++) {
		$elementi.='<div class="Row">
	';
		for ($j=0; $j <4 && $bool == FALSE ; $j++,$k++) {
			$id = $ris[2][$k]['ID'];
			$img = estraiImmagine("../img/product/",$id);
			if (!is_numeric($img) ) {
				$elementi.='<div>
		<a href="prodotto.php?ID='.$id.'">
			<div>
				<img src="../img/product/'.$img.'" alt=""/>
				<p>&#8364;'.$ris[2][$k]['Prezzo'].'</p>
				<p>Scopri di pi&#249;</p>
			</div>
		</a>
		<a href="prodotto.php?ID='.$id.'">
			<h2>'.str_replace("0", " ", $ris[2][$k]['Nome']).'</h2>
		</a>
		<a href="venditore.php?Nome='.$ris[2][$k]['Negozio'].'">
			Venditore: '.str_replace("0", " ", $ris[2][$k]['Negozio']).'
		</a>
	</div>
	';
			} else {
				$j--;
			}
			if ($k == count($ris[2])-1) {
				$bool = TRUE;
			}
		}
		$elementi.='
		</div>
		';
	}
} else {
	// CATEGORIA e VENDITORE
	if ($tipologia == "Categorie") {
		$percorso = "../img/categorie/";
	} else {
		$percorso = "../img/negozi/";
	}
	for ($i=0; $i <3 && $bool == FALSE ; $i++) {
		$elementi.='<div class="Row">';
		for ($j=0; $j <4 && $bool == FALSE ; $j++,$k++) {
			$id = $ris[2][$k]['Nome'];
			$img = estraiImmagine($percorso,$id);
			if (!is_numeric($img) ) {
				$elementi.='<div>
				<a href="venditore.php?Nome='.$id.'">
				<div>
					<img src="'.$percorso.$img.'" alt=""/>
					<p>Scopri di pi&#249;</p>
				</div>
				</a>
				<a href="negozio.php?Nome='.$id.'">
				<h2>'.str_replace("0", " ", $id).'</h2>
				</a>
				</div>
				';
			} else {
				$j--;
			}
			if ($k == count($ris[2])-1) {
				$bool = TRUE;
			}
		}
		$elementi.='</div>
		';
	}
}

$successive = "";
if ($ris[1] > 1) {
	$successive = '<form action="ricercamdp.php" method="post">
<fieldset>
<legend>Tipologia ricerca<legend>
	<label for="search">Query di ricerca</label>
	<input id="search" type="hidden" name="ricerca" value="'.$ricercaoriginale.'" />
	<label for="query">Query di ricerca</label>
	<input id="query" type="hidden" name="query" value="'.$query.'" />
	<label for="tipologia">Tipologia di ricerca</label>
	<input type="hidden" name="tipologia" value="'.$tipologia.'" />
	';
	$i=($page-5);
	if ($i > 1) {
		$successive.="
		<p>...</p>";
	}
	for (; $i <($page+5) ; $i++) {
		if ($i >0 && $i <= $ris[1]) {
				if ($i == $page) {
					$successive.= "
					<p>$i</p>";
				} else {
					$successive.= '<label for="submit'.$i.'" >Bottone alla pagina '.$i.'</label>
					<input type="submit" name="page" value="'.$i.'" />
					';
				}
		}
	}
	if ($i < $ris[1]) {
		$successive.="
		<p>...</p>";
	}
	$successive .= "</fieldset>
	</form>";
}

$_SESSION['mdp'] = array();
$_SESSION['mdp']['query'] = $query;
$_SESSION['mdp']['tipologia'] = $tipologia;
$_SESSION['mdp']['ricerca'] = $ricercaoriginale;
$_SESSION['mdp']['regione'] = $_SESSION['regione'];
$_SESSION['mdp']['provincia'] = $_SESSION['provincia'];

$titolo='Pagina di Ricerca';
$keyword='';
$descrizione='Pagina di Ricerca Approfondita';
$temp='<link rel="stylesheet" type="text/css" href="../css/ricercamdp-desktop.css" media="screen and (min-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../css/ricercamdp-smartphone.css" media="screen and (max-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../css/ricercamdp(print).css" media="print"/>
';

include '1header.php';
include 'ricercamdp.html';
include '3footer.html';

?>
