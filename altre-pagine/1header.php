<?php
require_once('../function.php');
  
settaregione();

if(!empty($_GET['logout']) && $_GET['logout']==TRUE){
  unset($_SESSION['email']);
  if(isset($cate) && $cate=='Profilo'){
    vaia('../index.php');
  }
}

if(empty($titolo)){
  $titolo='<title>4 Forchette</title>';
}
else {
  $titolo='<title>'.$titolo.'</title>';
}

if(empty($keyword)){
  $keyword='<meta name="keywords" content="4 Forchette, food delivery, da asporto, ecommerce"/>';
}
else {
  $keyword='<meta name="keywords" content="'.$keyword.'"/>';
}

if(empty($descrizione)){
  $descrizione='<meta name="description" content="Food delivery, spediamo cibo di qualità"/>';
}
else {
  $descrizione='<meta name="description" content="'.$descrizione.'"/>';
}

if(empty($temp)){
  $temp='';
}
if(empty($noscript)){
  $noscript='';
}

$reg=stampaProv($_SESSION["regione"], $_SESSION["provincia"]);

if(!isset($cate)){
  $cate='';
}
$linkCirc=array();
if(isset($_GET['cat'])){
  $cate=$_GET['cat'];
}
$linkCirc=linkCircolare($cate);
$prova=array('Profilo','Cart',
              'Azienda',
                'La0Storia', 'Chi0Siamo', 'Denominazione',
              'Piatti0Caldi',
                'Primi0Piatti', 'Secondi0Piatti', 'Pizze', 'Contorni', 'Dessert',
              'Bottega',
                'Latticini', 'Salumeria', 'Fornaio', 'Dispensa',
              'Bevande',
                'Alcolici', 'Analcolici');
$itProva=0;

$defIm='';
if(!empty($_SESSION["email"])){
  $defIm=$_SESSION["email"];
}

$dis=getimagesize(userIm($defIm, 'Pro'));
$quadImg='Larghezza';

if(!empty($dis) && $dis[0]<=$dis[1]) {
  $quadImg='Altezza';
}

$login='';
if(!empty($_SESSION['email'])){
  $login='<a href="?logout=TRUE" title="Esci dal profilo">Logout</a>
  ';
}
else {
  $login='<a href="registrazione.php" title="Non hai ancora un account? Registrati!">Registrazione</a>
      <a href="login.php" target="_blank" title="Accedi al profilo">Login</a>
      ';
}

/*
echo $nomefile;
die();
*/
/*Il nome del file corrente è in $_SERVER['PHP_SELF']

Per estrarre solo il nome del file si usa:
$nome = basename($_SERVER['PHP_SELF']);

Per estrarre solo il percorso si usa:
$path = dirname($_SERVER['PHP_SELF']); */

include '1header.html';
?>