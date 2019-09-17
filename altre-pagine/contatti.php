<?php
session_start();
$titolo='Contatti';
$temp='
    <link rel="stylesheet" type="text/css" href="../css/contatti.css" media="handheld, screen"/>
	<link rel="stylesheet" href="../css/contatti(print).css" media="print"/>
	<script src="../js/forms-checks-and-slider.js" defer="defer"></script>';
$keyword='contatti, form, domande';
$descrizione='Pagina contenente il Form Contatti';	
include '1header.php';
include 'contatti.html';
include '3footer.html';
?>
