<?php
session_start();
$titolo='Spedizione';
$keyword='medodi di spedizione, spedizioni';
$descrizione='Pagina descrittiva con i metodi di spedizione';
$temp='
    <link rel="stylesheet" type="text/css" href="../css/ship-desktop.css" media="handheld, screen and (min-width:1024px)"/>
    <link rel="stylesheet" type="text/css" href="../css/ship-smartphone.css" media="handheld, screen and (max-width: 1023px)"/>
    <link rel="stylesheet" type="text/css" href="../css/ship(print).css" media="print"/>';
include '1header.php';
include 'ship.html';
include '3footer.html';
?>