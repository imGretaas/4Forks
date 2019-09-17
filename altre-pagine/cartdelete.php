<?php
session_start();
require_once('../basefunction.php');
if (empty($_GET['ID']) || !is_numeric($_GET['ID']) || !in_array_r($_GET['ID'], $_SESSION['cart'])) {
  header("Location: cart.php");
  die();
}
$array  = array();
foreach ($_SESSION['cart'] as $key => $value) {
  if ($value['ID'] != $_GET['ID'])
      $array[] = $value;
}
$_SESSION['cart'] = $array;

header("Location: cart.php");
?>
