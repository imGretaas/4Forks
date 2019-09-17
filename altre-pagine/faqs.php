<?php
session_start();
$titolo='Faqs';
$keyword='informativa, domande, faqs';
$descrizione='Informativa sul sito';
$temp='<link rel="stylesheet" type="text/css" href="../css/faqs-desktop.css" media="handheld, screen and (max-width:1023px)"/>
    <link rel="stylesheet" type="text/css" href="../css/faqs-desktop.css" media="screen and (min-width:1024px)"/>
    <link rel="stylesheet" type="text/css" href="../css/faqs(print).css" media="print"/>
    <noscript>
    	<link rel="stylesheet" type="text/css" href="../css/faqs(noscript).css" media="handheld, screen"/>
    </noscript>';
include '1header.php';
include 'faqs.html';
include '3footer.html';
?>
