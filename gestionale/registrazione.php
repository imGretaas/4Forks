<?php
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['noauth']) || $_SESSION['auth'] !== TRUE || $_SESSION['noauth'] != -1) {
  session_unset();
  session_destroy();
  setcookie('4FLogErr', "TRUE", time()+120);
  header('Location: login.php');
}
$message = "";
$middle = '';
$verde = FALSE;
if (!empty($_SESSION['regresult'])) {
  switch ($_SESSION['regresult']) {
    case 1:
      $message = "Venditore Registrato con successo";
      $verde = TRUE;
      $erro= $_SESSION['regresult'];
      $_SESSION['regresult'] = 0;
      break;

    case -1:
      $message = "Registrazione Fallita:<br /> Email già registrata";
      $middle = '<script src="js/jquery-3.3.1.min.js" ></script>
            <script src="js/reggerGR.js"></script>';
            $erro= $_SESSION['regresult'];
            $_SESSION['regresult'] = 0;
      break;

    case -2:
      $message = "Registrazione Fallita:<br /> Nome Azienda già registrato";
      $middle = '<script src="js/jquery-3.3.1.min.js" ></script>
            <script src="js/reggerGR.js"></script>';
            $erro= $_SESSION['regresult'];
            $_SESSION['regresult'] = 0;
      break;

    case -3:
      $message = "Registrazione Fallita:<br /> Errore del server<br /> Errore 3";
      $middle = '<script src="js/jquery-3.3.1.min.js" ></script>
              <script src="js/reggerS.js"></script>';
              $erro= $_SESSION['regresult'];
              $_SESSION['regresult'] = 0;
      break;

    case -4:
      $message = "Registrazione Fallita:<br /> Errore del server<br /> Errore 4";
      $middle = '<script src="js/jquery-3.3.1.min.js" ></script>
              <script src="js/reggerS.js"></script>';
              $erro= $_SESSION['regresult'];
              $_SESSION['regresult'] = 0;
      break;

      case -5:
        $message = "Registrazione Fallita:<br /> Errore del server<br /> Errore 5";
        $middle = '<script src="js/jquery-3.3.1.min.js" ></script>
                <script src="js/reggerS.js"></script>';
                $erro= $_SESSION['regresult'];
                $_SESSION['regresult'] = 0;
        break;
  }
}
$middle .= '<script src="../js/forms-checks-and-slider.js" ></script>';
$titolo = "Registrazione Venditore";

if ($message != "") {
  $nmessage = '<p id="err"';
  if ($verde == TRUE) {
    $nmessage.=' class = "verde" ';
  }
  $nmessage.= '>'.$message.'</p>';
  $message = $nmessage;
}

require_once 'inizio.php';
require_once 'registrazione.html';
require 'end.txt';
?>
