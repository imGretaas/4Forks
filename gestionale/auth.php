<?php
session_start();
$titolo = "Login Venditori";

if (!isset($_POST['nome']) || !$_POST['nome'] || !isset($_POST['password']) || !$_POST['password'] || $_POST['nome'] == '' || $_POST['password'] == '' ) {
  session_unset();
  session_destroy();
  header('Location: login.php');
  die();
} else {
  require_once '../basefunction.php';
  $auth = hash('sha256', $_POST['password']);
  $Query = 'SELECT LogghinV.Nome , Negozi.Nome AS proprietario FROM LogghinV LEFT JOIN Negozi ON LogghinV.Nome = Negozi.Email WHERE Credenziali = \''.$auth.' \' ;' ;
  $Database = $GLOBALS['db'];
  $arr = dbrequest($Database, $Query);
  if(is_array($arr)) {
    $bool = false;
    foreach ($arr as $key => $value) {
      if (is_array($value) && in_array($_POST['nome'], $value)) {
        $bool = true;
      }
    }
    if ($bool == true) {
      $_SESSION['auth'] = TRUE;
      $_SESSION['noauth'] = -1;
      $_SESSION['proprietario'] = $_POST['nome'];
      $_SESSION['negozio'] = str_replace("0", " ", $arr[0]['proprietario']);
      header('Location: profilonegozio.php');
    } else {
      session_unset();
      session_destroy();
      setcookie('4FLogErr', "TRUE", time()+120);
      header('Location: login.php');
    }
  }
}
?>
