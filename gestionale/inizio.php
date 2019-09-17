<!DOCTYPE html>
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">
  <head>
    <meta charset="UTF-8"/>
    <meta name="description" content="Pagina Login per i Venditori del sito Le 4Forchette" />
    <meta name="keywords" content="4Forchette Venditori, 4Forchette Login Venditori" />
    <meta name="author" content="Gruppo Pizzel"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-sale=1.0, user-scalable=0" />
    <?php
    if (isset($middle)) {
      echo $middle;
    }
     ?>
    <link rel="stylesheet" type="text/css" href="css/gestionale.css" media="handheld, screen"/>
    <noscript>
      <link rel="stylesheet" href="css/gestionale(noscript).css"/>
    </noscript>
    <link rel="stylesheet" type="text/css" href="css/gestionale(print).css" media="print"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500|Source+Serif+Pro" rel="stylesheet"/>
    <?php echo "<title>$titolo</title>

";
  if (isset($endl)) {
    echo $endl;
  }

  ?>
  </head>
  <body>
