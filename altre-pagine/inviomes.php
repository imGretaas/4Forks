<?php
session_start();
if(empty($_GET["fname"]) || empty($_GET["lname"])){
	header("location: contatti.php");
	die();
}
require_once("../basefunction.php");
$get=array();
$get=striparray($_GET);
$_SESSION['vaiaerror']="Contatti";
if($get['fname']!=$_GET['fname'] || $get['lname']!=$_GET['lname']){
	$_SESSION['specificerror']="Nome o Cognome non corretti!";
	$_SESSION['positivo']=FALSE;
}
else {
	$_SESSION['specificerror']="Messaggio inviato con successo!";	
	$_SESSION['positivo']=TRUE;
}
vaia("../index.php");