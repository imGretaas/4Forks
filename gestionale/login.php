<?php
$err = FALSE;
session_start();
$middle = "";
$titolo = "Login Venditori";
if (isset($_COOKIE['4FLogErr']) && $_COOKIE['4FLogErr'] == "TRUE") {
    setcookie("4FLogErr", "TRUE" , time()-1);
    $middle = '<script src="js/jquery-3.3.1.min.js" ></script>
          <script src="js/errlog.js"></script>';
    $err = TRUE;
}
 $middle .= '<script src="../js/forms-checks-and-slider.js"></script>';

require_once 'inizio.php';
require_once 'login.html';
require 'end.txt';
?>
