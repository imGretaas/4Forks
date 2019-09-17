<?php
session_start();
$cat = "";
if (isset($_GET['cat']) ) {
  $cat = $_GET['cat'];
}
$titolo = "Categorie";
if ($cat != "") {
  $titolo = $cat;
}
$keyword = "Categorie, Piatti Caldi, Bevande, Bottega";
$descrizione = "Pagina delle varie macrocategorie di prodotti. Contiene le macrocategorie Piatti Caldi, Bevande e Bottega";
$piatticaldi = "DispBlock";
$bottega = "DispBlock";
$bevande = "DispBlock";

switch ($cat) {
  case "Piatti0Caldi":
    $bottega = "DispNone";
    $bevande = "DispNone";
    $cat = "Piatti Caldi";
    $titolo = $cat;
    $keyword = "Piatti Caldi, Primi Piatti, Secondi Piatti, Pizze, Contorni, Dessert";
    $descrizione = "Pagina della macrocategoria Piatti Caldi. Contiene le relative sottocategorie";
    break;

  case "Bevande":
    $piatticaldi = "DispNone";
    $bottega = "DispNone";
    $keyword = "Bottega, Latticini, Salumeria, Fornaio, Dispensa";
    $descrizione = "Pagina della macrocategoria Bottega. Contiene le relative sottocategorie";
    break;

  case "Bottega":
    $piatticaldi = "DispNone";
    $bevande = "DispNone";
    $keyword = "Bevande, Alcolici, Analcolici";
    $descrizione = "Pagina della macrocategoria Bevande. Contiene le sottocategorie Alcolici e Analcolici";
    break;
}

$temp='<link rel="stylesheet" type="text/css" href="../css/categorie-smartphone.css" media="handheld, screen and (max-width:1023px)"/>
    <link rel="stylesheet" type="text/css" href="../css/categorie-desktop.css" media="screen and (min-width:1024px)"/>
    <link rel="stylesheet" type="text/css" href="../css/categorie(print).css" media="print"/>';

include '1header.php';
include 'categorie.html';
include '3footer.html';
?>
