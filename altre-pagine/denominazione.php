<?php
session_start();
$titolo='Denominazione';
$keyowrd='denominazione, certificazioni, certificazione';
$descrizione='Informativa sulle certificazioni addottate';
$cate='Denominazione';
$temp='<link rel="stylesheet" type="text/css" href="../css/denominazione-smartphone.css" media="handheld, screen and (max-width:1023px)"/>
    <link rel="stylesheet" type="text/css" href="../css/denominazione-desktop.css" media="screen and (min-width:1024px)"/>
    <link rel="stylesheet" type="text/css" href="../css/denominazione(print).css" media="print"/>';
include '1header.php';
include 'denominazione.html';
include '3footer.html';
?>
