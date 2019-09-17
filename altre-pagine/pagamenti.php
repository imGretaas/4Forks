<?php
session_start();
$titolo='Pagamenti';
$keyword='metodi di pagamento, pagamento, informativa, pagamenti';
$descrizione='Informativa sui metodi di pagamento';
$temp='<link rel="stylesheet" type="text/css" href="../css/pagamenti.css" media="handheld, screen"/>
	<link rel="stylesheet" type="text/css" href="../css/pagamenti(print).css" media="print"/>';
include '1header.php';
include 'pagamenti.html';
include '3footer.html';
?>