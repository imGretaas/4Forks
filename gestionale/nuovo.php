<?php
session_start();
require_once 'function.php';
print_r($_FILES);
echo "<br<br>";

$risultato = fileimage($_FILES['userfile'], "test/");
if ($risultato == 1) {
  echo "file inserito correttamente ;D ";
} else {
  echo "Errore numero $risultato";
}

 ?>
