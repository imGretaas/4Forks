<?php
session_start();
require_once('function.php');

settaregione();

if(!empty($_GET['logout']) && $_GET['logout']==TRUE){
  unset($_SESSION['email']);
}

$defIm="";
if(!empty($_SESSION["email"])){
  $defIm=$_SESSION["email"];
}

$dis=getimagesize(userIm($defIm, 'Pro', ""));
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
  $login='<a href="altre-pagine/registrazione.php" target="_blank" title="Non hai ancora un account? Registrati!">Registrazione</a>
      <a href="altre-pagine/login.php" title="Accedi al profilo">Login</a>
      ';
}

$err=array();
$err[0]='';
$err[1]='<img id="logo" src="img/logo.png" alt="Logo aziendale"/>';
$err[2]='';

if(!empty($_SESSION["vaiaerror"]) && !empty($_SESSION["specificerror"])) {
  if(empty($_SESSION["positivo"])){
    $_SESSION["positivo"]=FALSE;
  }
  $err=homeError($_SESSION["vaiaerror"], $_SESSION["specificerror"], $_SESSION["positivo"]);
  unset($_SESSION["vaiaerror"]);
  unset($_SESSION["specificerror"]);
  unset($_SESSION["positivo"]);
}

$reg=stampaProv($_SESSION["regione"], $_SESSION["provincia"]);

require_once('casa.html');
?>