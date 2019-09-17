<?php
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['noauth']) || $_SESSION['auth'] !== TRUE || $_SESSION['noauth'] != -1) {
  session_unset();$query = 'SELECT * FROM Categorie ORDER BY Gruppo DESC, Nome';
$DB = $GLOBALS['db'];
$ris = dbrequest($DB, $query);
  session_destroy();
  setcookie('4FLogErr', "TRUE", time()+120);
  header('Location: login.php');
}

$titolo = "Inserimento Prodotto";
$middle = '   <script src="js/jquery-3.3.1.min.js" ></script>
      <script src="js/modernizr-2.6.2.min.js"></script>
      <script src="js/jquery.cookie-1.3.1.js"></script>
      <script src="js/jquery.steps.js"></script>
      <link rel="stylesheet" href="css/normalize.css" media="handled, screen">
      <link rel="stylesheet" href="css/main.css" media="handled, screen">
      <link rel="stylesheet" href="css/jquery.steps.css" media="handled, screen" >
      <script src="js/start_wizard.js"></script>
';
$middle .= '<script src="../js/forms-checks-and-slider.js"></script>';

require_once 'inizio.php';
require_once '../basefunction.php';
$flag = FALSE;
$message = "";
$dati = [ // RECUPERO CAMPI GIa INSERITI E RIGETTATI
  'nome' => '',
  'certificazione' => '',
  'prezzo' => 0,
  'desc' => '',
  'Categoria' => FALSE,
  'prov' => "",
  'regioni' => array(),
  'italia' => ''
];
if(array_key_exists('raggio', $_SESSION)) {
  $message = "Errore: Nessun Raggio Inserito";
  unset($_SESSION['raggio']);
}
if(array_key_exists('insproer', $_SESSION) && $_SESSION['insproer'] == 0) {
  $message = "Inserimento Confermato";
  $flag = TRUE;
}
if(!empty($_SESSION['ritornero']) && !empty($_SESSION['insproer']) ){
  switch ($_SESSION['insproer']) {
    case 'giainserito':
      $message = "Errore: esiste giá un prodotto con questo nome venduto da te";
      break;

    case 'server':
      $message = "Errore del server";
      break;

    default:
      if(array_key_exists('Nome',$_SESSION['ritornero'])) {
        $message = "Errore: Esiste gia un prodotto da lei chiamato ".$_SESSION['ritornero']['Nome'];
      }
      break;
  }
    unset($dati);
    $dati = $_SESSION['ritornero'];
    if (is_array($_SESSION['insproer'])) {
      foreach ($_SESSION['insproer'] as $key => $value) {
        if ($value == 0) {
          if(isset($dati[$key])) {
            $dati[$key] = "";
          }
        }
      }
    }
    if(empty($dati['prov'])) {
      $dati['prov'] = "";
    }
    if(empty($dati['regioni'])){
      $dati['regioni'] = array();
      $dati['italia'] = '';
    } else {
      if(in_array('italia',$dati['regioni'])) {
        $dati['italia'] = 'italia';
      } else {
        $dati['italia'] = '';
      }
    }
  }

$sottocategorie = ''; // GENERAZIONE AUTMOMATICA DELLE SOTTOCATEGORIE
$ris = categorie();
$gruppi = array();
foreach ($ris as $key => $value) {
  if (is_array($value)) {
    if (!in_array($value['Gruppo'], $gruppi )) {
      if (!empty($gruppi)) {
        $sottocategorie .= '</div>
        ' ;
      }
      $sottocategorie .= '<div class="SottoCat">
          <p class="sc_p"> '.str_replace("0", " ", $value['Gruppo']).'<span class="Asterix">&#42;</span><SUP>(2)</SUP></p>
      ' ;
      $gruppi[] = $value['Gruppo'];
    }
    $sottocategorie .= '    <input id="'.$value['Nome'];
    $sottocategorie .='" type="radio" name="sottocategoria" value="'.$value['Nome'].'" ' ;

    if ($value['Nome'] == $dati['Categoria']) {
      $sottocategorie.= 'checked="checked" ';
    }
    $sottocategorie.= 'required="required" />
      <label class="sottolabel" for="'.$value['Nome'].'">'.str_replace("0", " ", $value['Nome'] ).'</label>
      ';
  }
}
$sottocategorie .= '</div>
';

$province = ''; // GENERAZIONE AUTMOMATICA DELLE PROVINCE
$rispro = province();
$pro = "";
$contatore = 0;
foreach ($rispro as $key => $value) {

  if (is_array($value)) {
    $nomepro = str_replace("0", " ", $value['regione_province']);
    if ($contatore % 5 == 0) {
      $pro.= '
        <div class="Gruppo">';
    }
    $pro.= '
          <label class="sottolabel" for="'.$value['regione_province'].'">'.$nomepro. '</label><input id="'.$value['regione_province'];
    $pro .='" type="checkbox" name="regioni[]" value="'.$value['regione_province'] . '"';
    if(!empty($dati['regioni']) && in_array($value['regione_province'], $dati['regioni'])) {
      $pro.=' checked="checked" ';
    }
    $pro.=' />';
    if ($contatore % 5 == 4) {
      $pro.= '
        </div>
      ';
    }
    $contatore+=1;
  }
}

if($message != "") {
  $nmessage= '<p class="err"';
  if ($flag == TRUE) $nmessage.= ' class="verde" ';
  $nmessage.='>'.$message.'</p>';
  $message = $nmessage;
}

require 'inserimentopro.html';
require 'end.txt';

//print_r($_SESSION);
//print_r($_SESSION['insproer']);
//print_r($_SESSION['ritornero']);
if (isset($_SESSION['insproer'])) {
  unset($_SESSION['insproer']);
}
if (isset($_SESSION['ritornero'])) {
  unset($_SESSION['ritornero']);
}
?>
