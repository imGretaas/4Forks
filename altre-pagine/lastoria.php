<?php
session_start();
$titolo='La storia';
$keyword='la storia, 4 Forchette';
$descrizione='Pagina dedicata alla storia del sito';
$cate='La0Storia';
$temp='<link rel="stylesheet" type="text/css" href="../css/lastoria-desktop.css" media="handheld, screen"/>
	<link rel="stylesheet" type="text/css" href="../css/lastoria(print).css" media="print"/>';
include '1header.php';
include 'lastoria.html';
include '3footer.html';
?>
