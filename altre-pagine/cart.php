<?php
session_start();
/*$_SESSION['cart'] = array(); // testing
$_SESSION['cart'][0] = array('ID' => 50 ,'quantita' => 1);
$_SESSION['cart'][1] = array('ID' => 52, 'quantita' => 3);
$_SESSION['cart'][2] = array('ID' => 54, 'quantita' => 2);*/
/*$_SESSION['cart'][3] = array('ID' => 28, 'quantita' => 2);*/

/* Formattazione carrello:
  $_SESSION['cart'] = array (
    ['ID']
    ['numero']
  )
*/
if (empty($_SESSION['cart'])) {
  $_SESSION['vaiaerror'] = 'carrello';
  $_SESSION['specificerror'] = 'Carrello Vuoto';
  header("Location: ../index.php");
  die();
}
require_once('../function.php');

$where = "";
$numbool = FALSE;
for ($i=0; $i < count($_SESSION['cart']); $i++) {
  $value = $_SESSION['cart'][$i];
  if ((empty($value['ID']) || !is_numeric($value['ID']) || !lunghezzacompresa($value['ID'], 10, 1)) || (empty($value['quantita']) || !is_numeric($value['quantita'])
  || $value['quantita'] < 0 || $value['quantita'] > 20 )) {
    $numbool = TRUE;
  } else {
    if ($where != "") {
      $where .= " OR ";
    }
    $where .= "Prodotti.ID = ".insertapici($value['ID']);
  }
}
if ($numbool == TRUE) {
  $_SESSION['cart'] = array();
  $_SESSION['vaiaerror'] = 'carrello';
  $_SESSION['specificerror'] = 'Carrello Vuoto';
  vaia("../index.php");
}

$query = requestquery('Prodotti.ID, Nome, Prezzo, province, regione', "Prodotti INNER JOIN Raggio ON Prodotti.Raggio = Raggio.ID", $where);
$ris = dbrequest($GLOBALS['db'], $query);
if (empty($ris)) {
  $_SESSION['vaiaerror'] = 'carrello';
  $_SESSION['specificerror'] = 'Errore del Server';
  vaia("../index.php");
}

$numprodotti = count ($_SESSION['cart']);
$cate="Cart";
$regioniA = array();
$compProv = array();
$numbool = FALSE;
$province = province(TRUE);
$finalprov = array();
$l = 0;
// CERCO DI CICLARE PER SCOPRIRE SE OGNI COPPIA DI PRODOTTI HA ALMENO UNA PROVINCIA IN COMUNE
if ($numprodotti > 1) {
  for ($i=count($ris) -1; $i > 0 && $numbool == FALSE; $i--) {
    // comprov é l'insieme di province che al ciclo > 1 i prodotti dei cicli precedenti hanno in comune
    $ris[$i]['quantita'] = $_SESSION['cart'][$i]['quantita'];
    $regioniA = explode(",", $ris[$i]['regione']);
    foreach ($regioniA as $key => &$value7) {
      $regioniA[$key] = trim($value7);
    }
    $provinceA = explode(",", $ris[$i]['province']);
    $ris[$i]['provesplose'] = $provinceA;
    $ris[$i]['regiesplose'] = $regioniA;
    if (!is_array($regioniA)) {
      if (!empty($regioniA)) {
        $regioniA = array(0 => $regioniA);
      } else {
        $regioniA = array();
      }
    }
    if (!is_array($provinceA)) {
      if (!empty($provinceA)) {
        $provinceA = array(0 => $provinceA);
      } else {
        $provinceA = array();
      }
    }
    for ($j=$i-1; $j >=0 && $numbool == FALSE ; $j--) {
      $ris[$j]['quantita'] = $_SESSION['cart'][$j]['quantita'];
      $regioniB = explode(",", $ris[$j]['regione']);
      $provinceB = explode(",", $ris[$j]['province']);
      foreach ($regioniB as $key => &$value8) {
        $regioniB[$key] = trim($value8);
      }
      $ris[$j]['provesplose'] = $provinceB;
      $ris[$j]['regiesplose'] = $regioniB;
      if (!is_array($regioniB)) {
        if (!empty($regioniB)) {
          $regioniB = array(0 => $regioniB);
        } else {
          $regioniB = array();
        }
      }
      if (!is_array($provinceB)) {
        if (!empty($provinceB)) {
          $provinceB = array(0 => $provinceB);
        } else {
          $provinceB = array();
        }
      }
      // CON tuta sta trafila ho ottenuto che sia regioni(A e B) che province(A e B) siano per lo meno degli array

      foreach ($province as $key => $value2) {
        // Aggiungo per comodita tutte le province di ogni regione alle province cosí controllo solo le province
        if (empty($compProv)
        && (in_array('Italia', $regioniA) || in_array($value2['regione_province'], $regioniA))
        && !in_array($value2['sigla_province'], $provinceA, true) ) {
          $provinceA[] = $value2['sigla_province'];
        }
        if ((in_array('Italia', $regioniB) || in_array($value2['regione_province'], $regioniB)) && !in_array($value2['sigla_province'], $provinceB)) {
          $provinceB[] = $value2['sigla_province'];
        }
      }
      for ($k = count($provinceA) -1; $k >0 ; $k--) {
        if (in_array($provinceA[$k], $provinceB)) {
          $compProv[] = $provinceA[$k];
        }
      }
      if (empty($compProv)) {
        $numbool = TRUE;
      } else {
        $finalprov[$l] = $compProv;

        $compProv = array();
        $l++;
      }
    }
  }

  $incompatibili = FALSE;
  $provcomuni = array();
  if ($numbool == TRUE) {
    $incompatibili = TRUE;
  } else {
    $primobool = FALSE;
    $nontrovatoinI = FALSE;
    $errore = array();
    $contrprov = $finalprov;
    $provcomuni = array();
    foreach ($contrprov[0] as $key => $altrovalue) {
      if ($key !== 'A' && $key !== 'B') {
        for ($i=count($contrprov) -1; $i > 0 ; $i--) {
          if (!in_array($altrovalue, $contrprov[$i])){
            $nontrovatoinI = TRUE;
          }
        }
        if ($nontrovatoinI == FALSE) {
          $provcomuni[] = $altrovalue;
        } else {
          $nontrovatoinI = FALSE;
        }
      }
    }
  }
  if (empty($provcomuni)) {
    $incompatibili = TRUE;
  } else {
    $_SESSION["provincecoerenti"] = $provcomuni;
    $_SESSION["paga"] = TRUE;
  }
} else {
  // SE siamo a questo else la possibilitá Cart empty() dovrebbe essere scongiurata, quindi questo else é un
  // $numprodotti == 1
  $provincetotali = array();
  $ris[0]['quantita'] = $_SESSION['cart'][0]['quantita'];
  $singoleregioni = explode(",", $ris[0]['regione']);
  foreach ($singoleregioni as $key => &$value7) {
    $singoleregioni[$key] = trim($value7);
  }
  foreach ($province as $key => $dinuovo) {
    if (in_array("Italia", $ris[0]) || !in_array($dinuovo['regione_province'], $regioniB)) {
        $provincetotali[] = $dinuovo['sigla_province'];
    }
  }
  $_SESSION["provincecoerenti"] = $provincetotali;
  $_SESSION["paga"] = TRUE;
  $incompatibili = FALSE;
}

$messaggio = "";
$disabled = "";
if ($incompatibili == TRUE) {
  $disabled = 'disabled = "disabled" ';
  $messaggio = '<p class="Err">Siamo spiacenti! I prodotti non hanno regioni/o province di vendita compatibili</p>';
}

$prodotti = array();
for ($i=0; $i < count($ris) ; $i++) {
  $alias = &$ris[$i];
  $file = estraiImmagine("../img/product/", $alias['ID']);
  if (is_numeric($file)) {
    $file = "../img/nophoto.png";
  } else {
    $file = "../img/product/".$file;
  }
  $nome = str_replace("0", " ", $alias['Nome']);
  $prodlink = "prodotto.php?ID=".str_replace("0", " ", $alias['ID']);
  $listaregioni = "";
  $listaprovince = "";
  $prodotti[$i] = '
  <fieldset>
    <legend>Prodotto: '.$nome.'</legend>
    <div class="Det">
      <div class="Column">
    <a href="'.$prodlink.'" class="Desc">'.$nome.'</a>
        <img class="Image" src="'.$file.'" alt="" onload="changeTotPrice();" />
      </div>
      <div class="Column" id="ColumMobile1">
        <div>
            <p>
              <label for="quantity'.$i.'" class="Pz">pz.</label>
              <input type="number" class="Quantity" name="quantita'.$i.'" id="quantity'.$i.'" onkeyup="changePrice('.$i.');
              checkQuantityCart('.$i.'); changeTotPrice();" onchange="changePrice('.$i.'); checkQuantityCart('.$i.'); changeTotPrice();" min="1" max="20" value="'.$_SESSION['cart'][$i]['quantita'].'"  />
              <span class="Change Price">x &#8364;'.$alias['Prezzo'].'</span>
            </p>
            <p>
              <label for="aggiorna'.$i.'">Aggiorna</label>
              <input class="Update" id="aggiorna'.$i.'" type="submit" value="Aggiorniamo" />
              <span></span>
            </p>
        </div>
      </div>
      <div class="Column" id="ColumMobile2">
            <p class="Dispnone">Costo: </p>
            <p id="cPrice'.$i.'" class="Price">&#8364;'.$alias['Prezzo'].'</p>
            <a class="Bin" title="Elimina prodotto dal carrello" href="cartdelete.php?ID='.$alias['ID'].'"><img src="../img/512px/trash.png" alt="cestina"></a>
          </div>

          <div class="Clearer"></div>
          <a href="'.$prodlink.'" class=" Desc">'.str_replace("0", " ", $alias['Nome']).'</a>
          ';
          if (!empty($alias['regiesplose'])) {
            foreach ($alias['regiesplose'] as $key => $value4) {
              $listaregioni.= str_replace("0", " ", $value4);

              if ($key == (count($alias['regiesplose']) -1)) {
                $listaregioni .= " ";
              } else {
                $listaregioni .= ", ";
              }
            }
            if (trim($listaregioni) != "") {
              $prodotti[$i] .= '<p><span class="Onlybold">Regioni di vendita:</span> ';
              $prodotti[$i] .= $listaregioni;
              $prodotti[$i] .= '</p>
            ';
            }
          }
          if (!empty($alias['provesplose'])) {
            foreach ($alias['provesplose'] as $key => $value5) {
              $listaprovince .= str_replace("0", " ", $value5);
              if ($key == (count($alias['provesplose']) -1)) {
                $listaprovince .= " ";
              } else {
                $listaprovince .= ", ";
              }
            }
            if (trim($listaprovince) != "") {
              $prodotti[$i] .= '<p><span class="Onlybold">Province di vendita:</span> ';
              $prodotti[$i] .= $listaprovince;
              $prodotti[$i] .= '</p>

            ';
          }
    }
          $prodotti[$i] .='</div>
        </fieldset>
        <div class="Clearer"></div>
        <div class="StackLine"></div>
  ';

}
/*
  cosa deve fare questa pagina:
  1) stampare il Carrello
    a) permettere modifica quantita / eliminazione prodotto OK
    b) segnalare i prodotti incompatibili OK
    c) segnalare le province di destinazione OK

  2) controllare la coerenza del carrello nei seguenti casi:
    a) se prodotti incompatibili tra loro non permettere di continuare OK
    b) se prodotti compatibili e profilo prov vuota o != da compatibilitá => si va al Profilo
    c) se prodotti compatibili e profilo compatibile => si va al profilo
  */

$temp='<link rel="stylesheet" type="text/css" href="../css/cart-smartphone.css" media="handheld, screen and (max-width:700px)"/>
    <link rel="stylesheet" type="text/css" href="../css/cart-desktop.css" media="screen and (min-width:701px)"/>
    <script src="../js/forms-checks-and-slider.js"></script>
  <link rel="stylesheet" href="../css/cart(print).css" media="print"/>';
$noscript = ' <link rel="stylesheet" type="text/css" href="../css/cart(noscript).css"/>';
$keyword='carrello, articoli da acquistare';
$descrizione='Pagina del carrello contenente gli articoli da acquistare';
include '1header.php';
include 'cart.html';
include '3footer.html';

/*echo "<br>ris = $where <br>";
print_r($ris);
echo "<br>finalprov =";
var_dump($finalprov);
echo "<br>provcomuni =";
print_r($provcomuni);
echo "<br>Sessione =";
print_r($_SESSION);
*/
?>
