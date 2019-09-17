<?php
if (empty($_GET) || empty($_GET['id']) || empty($_GET['quantita'])) {
  $_SESSION['vaiaerror'] = "carrello";
  $_SESSION['specificerror'] "Link non disponibile";
  $_SESSION['positivo'] = FALSE;
  header("Location: ../index.php");
  die();
}

$_SESSION['cart'] = array('ID' => $_GET['id'], 'quantita' => $_GET['quantita']);
$_SESSION['vaiaerror'] = "carrello";
$_SESSION['specificerror'] "Prodotto aggiunto al carrello";
$_SESSION['positivo'] = TRUE;
header("Location: ../index.php");
?>
