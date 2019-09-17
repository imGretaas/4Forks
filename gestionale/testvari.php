<?php
session_start();
echo hash('sha256', 'root');
die();
var_dump(is_numeric('1.gpj'));
die();
$middle = '
<style>
#X:checked+div{
  display: none !important;
}

#X:checked ~ label{
  display: none !important;
}

div {
  width: 200px;
  height: 100px;
  background-color:#000;
}
</style>
';
require 'inizio.php';
echo '
<input id="X" type="checkbox" style="visibility:hidden;">
<div></div>
<label id="labelx" for="X">X</label>';
require 'end.txt';
die();
require_once 'function.php';
var_dump ('07' == 7);
$string1 = "BZ";
$string2 = "BZ,PD,NA";
$arr1 = explode(",", $string1);
$arr2 = explode(",", $string2);
echo "arr1 = ";
print_r($arr1);
echo "<br> arr2 = ";
print_r($arr2);

die();
$model = '/^[0-9]*$/ ';
var_dump(strlen($_GET['ID']));
var_dump((int)'ciao');
var_dump((int)$_GET['ID']);
echo "<br>";
var_dump(12%8);

die();
var_dump(str_replace("1", " 0", "abcdef"));
//var_dump(estraiImmagine("img/negozi", "Delta"));


print_r (count(explode(',', $province)));

die();
$regioni = province(TRUE);
/*foreach ($regioni as $key => $value) {
  print_r($regioni[$key]);
  echo '<br>';
}*/
$bool = FALSE;
for ($i=0; $i <109 && !$bool ; $i++) {
  $act = $regioni[$i]["regione_province"];
  echo "Inizio Regione: ".$act."<br>";
  while ($act == $regioni[$i]["regione_province"] && $i<109) {
      echo $regioni[$i]["sigla_province"]."<br>";
      $i++;
  }
  $i--;
  echo "Fine Regione: ".$act."<br>";
}
die();
var_dump(is_dir('img'));
var_dump(is_dir('img/negozi'));
$scan =scandir('img/negozi');
$nome = 'Deltasimmons';
foreach ($scan as $key => $value) {
  if(strpos($value, $nome) !== FALSE ) {
    unlink('img/negozi/'.$value);
  }
}
die();

require_once 'function.php';
$value = 'aaa!';
var_dump(lunghezzacompresa($value, 30, 2) && (tipostringa($value) == '100' || tipostringa($value) == '110'));
(lunghezzacompresa($value, 30, 2) && (tipostringa($value) == '100' || tipostringa($value) == '110')) ? $arr['a'] = 1 : $arr['a'] = 0;
print_r($arr);

die();








$_SESSION['acs'] = 1;
$titolo = "Pagina Test";
require_once "inizio.php";

$arr =scandir("/home/tertius/Scrivania/html/project/img");
print_r($arr);
echo "<br><br>";
?>

<form action="nuovo.php" method="post" enctype="multipart/form-data">
  <input typ<?php
require_once "end.txt";
 ?>e="hidden" name="MAX_FILE_SIZE" value="2097152" />
  <input type="file" name="userfile" value="userfile"/>
  <input type="text" name="regexp" />
  <input type="submit" name="carica" value="Adrianaaaaaa"/>
</form>
<a href="nuovo.php?id='vodka'">Clicca Qui</a>
<?php
require_once "end.txt";
 ?>
