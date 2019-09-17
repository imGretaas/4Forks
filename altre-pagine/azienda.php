<?php
session_start();
$titolo='Azienda';
$cate="Azienda";
$temp='<link rel="stylesheet" type="text/css" href="../css/azienda-desktop.css" media="screen and (min-width:1024px)"/> <link rel="stylesheet" type="text/css" href="../css/azienda-smartphone.css" media="screen and (max-width:1023px)"/> 
	<link rel="stylesheet" type="text/css" href="../css/azienda(print).css" media="print"/>';
$keyword='azienda, la storia, denominazione, certificazioni, 4 Forchette';
$descrizione='Introduzione alle pagine: La Storia, Chi Siamo, Denominazione Prodotti';	
include '1header.php';
include 'azienda.html';
include '3footer.html';
?>
