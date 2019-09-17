<?php
session_start();
$titolo='Pagina 404';
$keyword='404, non trovato, nessun risultato, errore';
$descrizione='Pagina 404';
$temp='<link rel="stylesheet" href="../css/pagina404.css" media=""/>
		<link rel="stylesheet" type="text/css" href="../css/pagina404(print).css" media="print"/>';
include '1header.php';
include 'pagina404.html';		//sostituire "content" con il nome (estensione compresa, se presente) della vostra pagina
include '3footer.html';
?>