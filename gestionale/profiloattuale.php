<?php

$negozio = $_SESSION['negozio'];
$queryjoin = requestquery("", "Negozi INNER JOIN Sede ON Negozi.Nome = Sede.Azienda", "Negozi.Nome = ".insertapici($negozio));

$join = dbrequest($GLOBALS['db'], $queryjoin);
if(is_array($join) && !empty($join)){
  $dati = [
    'citta' => $join[0]['Citta'],
    'via' => $join[0]['Via'],
    'cap' => $join[0]['CAP'],
    'desc' => $join[0]['Descrizione']
  ];
  if (isset($join['numTel']) && !empty($join['numTel'])) {
    $dati['tel'] = $join['numTel'];
  } else {
    $dati['tel'] = "";
  }
}
$basedir = 'img/negozi';
// <p id="pprofiloattuale">Foto Profilo Attuale</p>
$monconesx = ' <figure>
<img src="';
$monconedx = '" id="fotoprofiloattuale" title="foto profilo attuale di'.$_SESSION['negozio'].'" alt="foto profilo attuale di'.$_SESSION['negozio'].'" />
  <figcaption>Foto Profilo Attuale</figcaption>
</figure>';
$file = "";
if(is_dir($basedir)) {
  $scan =scandir($basedir);
  foreach ($scan as $key => $value) {
    if(strpos($value, $_SESSION['negozio']) !== FALSE ) {
      $file = $value;
    }
  }
  if ($file != "") {
    $file = $basedir.'/'.$file;
  }
}
?>
