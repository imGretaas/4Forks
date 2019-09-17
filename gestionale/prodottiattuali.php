<?php
$negozio = $_SESSION['negozio'];
$elementipg = 8; //Solo per testing
if (!(array_key_exists("propg", $_SESSION) && array_key_exists("attuale", $_SESSION['propg']) && $_SESSION['propg']['attuale'] <= $_SESSION['propg']['massimo']) ) {
  // CREO IL NUMERO DI PAGINA
  $numero = 0;
  $negozio = str_replace(" ", "0", $negozio);
  $requestn = requestquery("COUNT(ID) AS Numero", "Prodotti", "Negozio =".insertapici($negozio));
  $arrayn = dbrequest($GLOBALS['db'], $requestn);
  if (array_key_exists(0, $arrayn) && array_key_exists("Numero", $arrayn[0])) {
    $numero = (int)$arrayn[0]["Numero"];
  }


  if($numero == 0) {
    vaia("prodotto.php");
  } // NON serve else in quanto vaia termina l'esecuzione
  $_SESSION['propg'] =array();
  $_SESSION['propg']['massimo'] = ceil($numero/$elementipg);
}
if (array_key_exists('page', $_GET) && $_GET['page'] > 0 && $_GET['page'] <= $_SESSION['propg']['massimo']) {
  $attuale = $_GET['page'];
  $_SESSION['propg']['attuale'] = $attuale;
  $query = requestquery("", "Prodotti", "Negozio =".insertapici($negozio), "ID DESC LIMIT $elementipg OFFSET ".($elementipg*($attuale-1)));
} else {
  $_SESSION['propg']['attuale'] = 1;
  $query = requestquery("", "Prodotti", "Negozio =".insertapici($negozio), "ID DESC LIMIT $elementipg");
  $attuale = 1;
}
  $ris = dbrequest($GLOBALS['db'], $query);
  $prodotti = "";
  $massimo = $_SESSION['propg']['massimo'];
foreach ($ris as $key => $value) {
  $prodotti .=stampaprodotto($ris[$key]);
}

// CREO I LINK alle pagine successive
$link = '<div id="succconteiner">';
$i=0;
for (; $i <10 ; $i++) {
  if ($attuale -5 +$i > 0 && $attuale-5+$i<= $massimo) {
    if ($i == 5) {
      $link.='
      <p id="actualpage">'.$attuale.'</p>';
    } else {
      $link.= stampalink($attuale -5 +$i);
    }
  }
}
if ($attuale-5+$i<= $massimo ) {
  $link.='<p>...</p>';
}
$link.='
</div>
';

unset($_SESSION['propg']);

?>
