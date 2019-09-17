<?php
session_start();
$cate="Chi0Siamo";
$titolo='Chi siamo';
$temp='<link rel="stylesheet" type="text/css" href="../css/chisiamo.css" media="handheld, screen"/>
	<link rel="stylesheet" type="text/css" href="../css/chisiamo(print).css" media="print"/>';

$keyword='chi siamo, 4 forchette';
$denominazione='Informativa su 4 Forchette';	
include '1header.php';
include 'chisiamo.html';
include '3footer.html';
?>
