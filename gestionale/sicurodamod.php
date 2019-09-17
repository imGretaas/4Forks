<?php
$data = explode("O;O", $dati);
$dati = [ // RECUPERO CAMPI GIa INSERITI E RIGETTATI
  'nome' => str_replace("0", " ", $data[1]),
  'certificazione' => $data[3],
  'prezzo' => $data[4],
  'desc' => '',
  'Categoria' => FALSE,
  'prov' => "",
  'regioni' => array(),
  'italia' => ''
];
$id = $data[0];
if (array_key_exists(8, $data)) {
  $dati['desc'] = $data[8];
}
if (array_key_exists(7, $data)) {
  $dati['Categoria'] = $data[7];
}
// RECUPERO REGIONI DAL Raggio
$regioni = "";
if (array_key_exists(5, $data) && (intval($data[5]) != 0 && $data[5] != 0)  ) {
  $regioni = $data[5];
  $rquery = requestquery('Regione, Province', "Raggio", "ID = $regioni");
  $risp = dbrequest($GLOBALS['db'], $rquery);
  if (!empty($risp)){
    if (array_key_exists('Regione', $risp[0])) {
      $dati['regioni'] = explode(',' , $risp[0]['Regione']);
    }
    if (array_key_exists('Province', $risp[0])) {
      $dati['prov'] = $risp[0]['Province'];
    }
  }
}
if ($regioni != "") {
  $passare = "$id,$regioni";
} else {
  $passare = $id;
}
  if(empty($dati['prov'])) {
    $dati['prov'] = "";
  }
  if(empty($dati['regioni'])){
    $dati['regioni'] = array();
    $dati['italia'] = '';
  } else {
    if(in_array('italia',$dati['regioni'])) {
      $dati['italia'] = 'italia';
    } else {
      $dati['italia'] = '';
    }
  }
?>
