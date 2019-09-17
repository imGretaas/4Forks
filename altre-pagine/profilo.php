<?php
session_start();
if(empty($_SESSION["email"])){
   header("Location: login.php");
   die();
}
$cate='Profilo';
$titolo='Profilo-4Forchette';
$temp='<link rel="stylesheet" type="text/css" href="../css/profilo-smartphone.css" media="handheld, screen and (max-width:1023px)"/>
<link rel="stylesheet" type="text/css" href="../css/profilo-desktop.css" media="screen and (min-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../css/profilo(print).css" media="print"/>
<script type="text/javascript" src="../js/profilo.js" defer="defer" onload="resetta()"></script>
<script src="../js/forms-checks-and-slider.js" defer="defer"></script>
';
$noscript='<link rel="stylesheet" type="text/css" href="../css/profilo(noscript).css" media="handheld, screen"/>
';


/*
controllare se $_SESSION['paga']==TRUE, in quel caso mostrare il pulsante "PAGA", quindi ora "salva" non è un submit, ma un button, insieme a "paga"
*/

require_once('../function.php');

$ciao=$_SESSION["email"];
$richiesta=requestquery("", "Cliente INNER JOIN Recapito ON Cliente.Email=Recapito.Proprietario", "Email=".insertapici($ciao));
$richiestaDB=dbrequest($GLOBALS['db'], $richiesta);
$richiestaDB[0]['cmese']=substr($richiestaDB[0]['Scadenza'], 5, 2);
$richiestaDB[0]['canno']=substr($richiestaDB[0]['Scadenza'], 2, 2);

$data=nascita($richiestaDB[0]['Datanascita']);
$err=array();
$err[3]="";
if(!empty($_SESSION["proErr"])){
	if($_SESSION["proErr"]=="Successo") {
  		$_SESSION["positivo"]=TRUE;
	}
	else {
  		$_SESSION["positivo"]=FALSE; 
	}
	$err=homeError($_SESSION["proErr"], $_SESSION["proMes"], $_SESSION["positivo"]);
	unset($_SESSION["proErr"]);
	unset($_SESSION["proMes"]);
	unset($_SESSION["positivo"]);
}

$arrayPost=array('nome',
                'cognome',
                'tel',
                'citta',
                'cap',
                'prov',
                'via',
                'numCred');
$arrayProf=array('Nome',
                'Cognome',
                'numTel',
                'Citta',
                'CAP',
                'Provincia',
                'Via',
                'NCarta');

$checked=array('', 'checked="checked"', '');
if(empty($_SESSION["proPost"])){
	$_SESSION["proPost"]=array();
	foreach($arrayPost as $key=>$value){
	  	$_SESSION["proPost"][$value]="";
	}
	$cdata=dataCredito($richiestaDB[0]['cmese'], $richiestaDB[0]['canno']);
}
else {
	if($_SESSION['proPost']['pagamento']=='credito'){
		$checked[0]='checked="checked"';
		$checked[1]='';
		$checked[2]=' Mostra';
	}
	$cdata=dataCredito($_SESSION['proPost']['cmese'], $_SESSION['proPost']['canno']);
}

for($i = 0; $i < count($arrayPost); $i++){
	if($_SESSION["proPost"][$arrayPost[$i]]!=""){
	  	$_SESSION["proPost"][$arrayProf[$i]]=$_SESSION["proPost"][$arrayPost[$i]];
	  	unset($_SESSION["proPost"][$arrayPost[$i]]);
	}
}

foreach($_SESSION["proPost"] as $key=>$value){
	if(!empty($_SESSION["proPost"][$key])){
	  	$richiestaDB[0][$key]=$_SESSION["proPost"][$key];
	}
}

unset($_SESSION['proPost']);

$paga='';
if(!empty($_SESSION['paga']) && $_SESSION['paga']==TRUE){
	$paga='<p id="pagap">
    <label for="paga">Paga</label>
    <input type="submit" name="paga" value="PAGA" id="paga" onfocusin="checkFormProIn(1);" onfocusout="checkFormProOut(1);" onmouseover="checkFormProIn(1);" onmouseout="checkFormProOut(1);" />
    <span></span>
  </p>
';
}

$keyword='profilo, profilo utente, profilo cliente, cliente, impostazioni';
$descrizione='Pagina Profilo Utente';

include '1header.php';
include 'profilo.html';
include '3footer.html';
?>
