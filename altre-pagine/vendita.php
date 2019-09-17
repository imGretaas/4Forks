<?php
session_start();
if(empty($_POST)){
	header("location: Profilo.php");
	die();
}
require_once("../basefunction.php");

$_POST=striparray($_POST);
$temp=array();


foreach ($_POST as $key => $value) {
	if($key=="nome" || $key=="cognome" || $key=="tel" || $key=="email" || $key=="pass" || $key=="citta" || $key=="prov" || $key=="cap" || $key=="via") {
		$temp["$key"]="$value";
	}
}

$_SESSION["proErr"]="";
$_SESSION["proMes"]="";

$maxM="31";
if($_POST["mese"]==2){
	if($_POST["anno"]%4 == 0 && ($_POST["anno"]%100 != 0 || $_POST["anno"]%400 == 0)){
		$maxM="29";
	}
	else {
		$maxM="28";
	}
}
else if ($_POST["mese"]==4 || $_POST["mese"]==6 || $_POST["mese"]==9 ||$_POST["mese"]==11) {
	$maxM="30";
}

if($_POST["giorno"]>$maxM){
	$_SESSION["proPost"]=$_POST;
	$_SESSION["proErr"]="Data";
	$_SESSION["proMes"]="Data non esistente";
	vaia("Profilo.php");
}


$bool=controllarray($temp);

/*
campi da dare alla funzione controllarray() (con i nomi della funzione, non di POST):
nome, cognome, telefono, email, password, città, provincia, cap e via.

ritorno è array di booleani su controllo di ogni input
*/

$validate=TRUE;
for ($i=count($bool); $i>0 && $validate; --$i) {
	if($value==FALSE){
		$validate=FALSE;
	}
}

if($validate==FALSE){
	$_SESSION["proPost"]=$_POST;
	$_SESSION["proCont"]=$temp;
	$_SESSION["proBool"]=$bool;
	vaia("Profilo.php");
}

if($_FILES["foto"]["error"]==0){

	$boolimage=fileimage($_FILES["foto"], "users/", $_POST["email"], "../img/");

	if($boolimage==-1){
		$_SESSION["proErr"]="Estensione";
		$_SESSION["proMes"]="Estensione del file non corretta!";
		vaia("Profilo.php");
	}
	else if($boolimage==-2) {
		$_SESSION["proErr"]="File non valido";
		$_SESSION["proMes"]="Estensione del file mancante!";
		vaia("Profilo.php");
	}
	else if($boolimage==-3) {
		$_SESSION["proErr"]="File grande";
		$_SESSION["proMes"]="File troppo grande (max 5MB).";
		vaia("Profilo.php");
	}
	else if($boolimage==-4) {
		$_SESSION["proErr"]="Destinazione";
		$_SESSION["proMes"]="La destinazione non è una cartella!";
		vaia("Profilo.php");
	}
	else if($boolimage==-5) {
		$_SESSION["proErr"]="Destinazione";
		$_SESSION["proMes"]="Destinazione non esistente!";
		vaia("Profilo.php");
	}
	else if($boolimage==-6) {
		$_SESSION["proErr"]="Spostamento";
		$_SESSION["proMes"]="Errore nello spostamento del file!";
		vaia("Profilo.php");
	}
	else if($boolimage==-7) {
		$_SESSION["proErr"]="Permessi";
		$_SESSION["proMes"]="Permessi insufficienti per completare l'operazione!";
		vaia("Profilo.php");
	}
}

if($_POST["pagamento"]=="credito"){
	$arrayquery["Paypal"]=0;
}
else {
	$arrayquery["Paypal"]=1;
}

if(!empty($_POST["numCred"])){
	$model='/^[0-9]{4}(-)?[0-9]{4}(-)?[0-9]{4}(-)?[0-9]{4}$/ ';
	if(boolregexp($model, $_POST["numCred"])){
		$arrayquery["NCarta"]=$_POST["numCred"];
	}
	else {
		$_SESSION["proPost"]=$_POST;
		$_SESSION["proErr"]="Carta credito";
		$_SESSION["proMes"]="Formato numero carta non valido!";
		vaia("Profilo.php");
	}
}
else {
	$arrayquery["NCarta"]="";
}

$_SESSION["vaiaerror"]="Carta credito";
$_SESSION["specificerror"]="Formato numero carta non valido!";
$_SESSION["positivo"]=TRUE;

unset($_SESSION["cart"]);

vaia("Profilo.php");
?>