<?php
global $db;
$db="stintupc_prova";
//$db = "Prova";

function in_array_r($needle, $haystack, $strict = false) {
    // Boleano, é un in_array ricorsivo
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

function vaia($location) {
  // servono commenti?
  header('Location:'.$location.'');
  die();
}

function appartienea($categoria) {
  $gruppo = "";
  switch ($categoria) {
    case 'pizze':
      $gruppo = "Piatti0Caldi";
    break;

    case 'primi0Piatti':
      $gruppo = "Piatti0Caldi";
    break;

    case 'secondi0Piatti':
      $gruppo = "Piatti0Caldi";
    break;

    case 'contorni':
      $gruppo = "Piatti0Caldi";
    break;

    case 'dessert':
      $gruppo = "Piatti0Caldi";
    break;

    case 'alcolici':
      $gruppo = "Bevande";
    break;

    case 'analcolici':
      $gruppo = "Bevande";
    break;

    case 'enoteca':
      $gruppo = "Bevande";
    break;

    case 'succhi':
      $gruppo = "Bevande";
    break;

    case 'fornaio':
      $gruppo = "Bottega";
    break;

    case 'latticini':
      $gruppo = "Bottega";
    break;

    case 'salumeria':
      $gruppo = "Bottega";
    break;

    case 'dispensa':
      $gruppo = "Bottega";
    break;
  }
  return $gruppo;
}

function slogan($categoria) {
  $slogan = "";
  switch ($categoria) {
    case 'pizze':
      $slogan = "Il fascino rotondo dell'Italia";
    break;

    case 'primi0Piatti':
      $slogan = "Preparati da mani esperte, con amore";
    break;

    case 'secondi0Piatti':
      $slogan = "Lasciati sorprendere dalla nostra variet&agrave;";
    break;

    case 'contorni':
      $slogan = "L&rsquo;arcobaleno che accompagna ogni tuo piatto";
    break;

    case 'dispensa':
      $slogan = "Quell&apos;ingrediente che ti manca...";
    break;

    case 'dessert':
      $slogan = "Il fine pasto che ti meriti";
    break;

    case 'alcolici':
      $slogan = "Il pizzico di allegria che ti mancava";
    break;

    case 'analcolici':
      $slogan = "Non di solo alcol vive l'uomo...";
    break;

    case 'enoteca':
      $slogan = "Le nostre scelte Superior.";
    break;

    case 'succhi':
      $slogan = "Tutti i colori della natura in un bicchiere.";
    break;

    case 'fornaio':
      $slogan = "Il paradiso appena sfornato";
    break;

    case 'latticini':
      $slogan = "Da verdi pascoli, direttamente a casa tua";
    break;

    case 'salumeria':
      $slogan = "Risveglia il tuo lato carnivoro";
    break;

    case 'farine':
      $slogan = "L&rsquo;origine di tutto ci&oacute; che &eacute; buono";
    break;
  }
  return $slogan;
}

function controlloraggio($province, $arregioni, $strprovince) {
  /*
  Restituisce un array di due valori:
  $result['P'] puó contenere:
                              OK
                              NESSUNA PROVINCIA
                              Un insieme di province inesistenti separate da ,

  $result['R'] puó contenere:
                              OK
                              NESSUNA REGIONE
                              Un insieme di regioni inesistenti separate da ,
  */
  $result = array();
  $risprov = "OK";
  $strprovince = str_replace(' ', '', $strprovince);
  if (empty($strprovince)) {
      $risprov = "NESSUNA PROVINCIA";
  } else {
    $arrprovince = explode("," , $strprovince);
    if (empty($arrprovince)) {
      if (!in_array($strprovince, $province)) {
        $risprov = $strprovince;
      }
    } else {
      $counter = 0;
      foreach ($arrprovince as $key => $value) {
        if (!in_array_r($value, $province)) {
          if ($counter == 0) {
            $risprov = $value;
            $counter = 1;
          } else {
          $risprov .= ",".$value;
          }
        }
      }
    }
  }
  $result["P"] = $risprov;
  $result["R"] = "OK";
  if (empty($arregioni)) {
      $result["R"] = "NESSUNA REGIONE";
  } else {
    $counter = 0;
    foreach ($arregioni as $key => $value) {
      if (!in_array_r($value, $province) && $value != "italia") {
        if ($counter == 0) {
          $result["R"] = $value;
          $counter = 1;
        } else {
          $result["R"] .= ",".$value;
        }
      }
    }
  }
  return $result;
}

function coerenzaraggio($listaprovince, $province, $regioni) {
  /*PRE: $listaprovince contiene la lista di tutte le province italiane e relative regioni
         $province contiene una stringa o vuota o di province separate da ,
         $regioni  é un array che contiene le regioni
  */
  $ritorno = array(1, '', '');
  if (in_array('italia', $regioni)) {
      $ritorno[0] = '4';
      $ritorno[2] = 'italia';
      return $ritorno;
  }
  if (!$province) {
    $ritorno[2] = implode(',' , $regioni);
    return $ritorno;
  }
  if (empty($regioni)) {
    $ritorno[0] = 2;
    return $ritorno;
  }
  $province = str_replace(' ', '', $province);
  echo $province;
  $arrprovince = array();
  if (strpos($province , ',') === FALSE ) {
    $arrprovince = explode(',', $province);
  }
  $milly = FALSE;
  print_r($arrprovince);
  $risultato = 3;

  // CASO >1 regioni e 1 provincia
  if(count($arrprovince) == 1) {
    // controllo provincia in regioni
    for ($i=0; $i<110 && !$milly ; $i++) {
      if ($listaprovince[$i]['sigla_province'] == $province) {
        $milly = TRUE;
        if (in_array($listaprovince[$i]['regione_province'] , $regioni)) {
          //sono nel caso di inserimento regione='Veneto,Liguria,Marche' e provincia = 'VI'
          $risultato = 5;
          $province = '';
        }
      }
    }
    echo $province;
    $ritorno[0] = $risultato;
    $ritorno[1] = $province;
    $ritorno[2] = implode(',' , $regioni);
    return $ritorno;
  }

  $nuoveprovince = array();
  // CASO >1 regioni e >1 provincie
  foreach ($arrprovince as $key => $value) {
    $milly = FALSE;
    for ($i=0; $i<110 && !$milly ; $i++) {
      if ($listaprovince[$i]['sigla_province'] == $value) {
        $milly = TRUE;
        if (in_array($listaprovince[$i]['regione_province'] , $regioni)) {
          //sono nel caso di inserimento regione='Veneto' e provincia = 'VI'

          $risultato = 5;
        } else {
          $nuoveprovince[] = $value;
        }
      }
    }
  }
  $ritorno[0] = $risultato;
  $ritorno[1] = implode(',' , $nuoveprovince);
  $ritorno[2] = implode(',' , $regioni);
  return $ritorno;
  /*
  Valori ritornati:
  abbiamo un array($numero, $province, $regioni).
  $numero puó essere:
  1 Se non ci sono Province
  2 se non ci sono Regioni
  3 se ci sono Province, Regioni e non ci sono errori di coerenza
  4 se la regione é italia: $regioni diventa italia e $province resta vuoto
  5 se 3 ma ci sono stati errori di coerenza corretti

  $province puó essere:
  "" se non ci sono province, o se c'erano province e sono state tolte in quanto errori di coerenza
  "AA" se vi é una sola provincia (con AA sigla di provincia)
  "AA,BB,CC" se vi sono piú Province

  $regioni puó essere:
  "" se non ci sono regioni
  "Abcdefg" se vi é una sola regione (con Abcdefg nome completo e con iniziale maiuscola di regione)
  "Abcdefg,Hijklm,nopqrs" se vi sono piú Regioni
  */
}

function coerenzaprodotto($nome, $negozio){
  /*
  PRECONDIZIONI:
  $nome contiene una stringa NON VUOTA che contiene il nome di un prodotto da inserire
  $negozio contiene una stringa NON VUOTA che contiene il negozio che vorrebbe inserire tale prodotto
  */
  $come = "Nome = ".insertapici($nome)." AND Negozio = ".insertapici($negozio);
  $richiesta = requestquery("Nome", "Prodotti", $come);
  $risultato = dbrequest($GLOBALS['db'], $richiesta);
  if (empty($risultato)) {
  return FALSE;
} else {
  return TRUE;
}
  /*
  VALORI RITORNATI:
  - TRUE se esiste giá tale prodotto nel Database
  - FALSE altrimenti
  */
}

function databaseraggio($province, $regioni){
  /*
  PRECONDIZIONI:
  $province contiene un insieme di sigle di provincia in uno di questi formati:
  - ""
  -"AA"
  -"AA,BB,CC"
  $regioni contiene un insieme di sigle di provincia in uno di questi formati:
  -""
  -"italia"
  -"Umbria"
  -"Umbria,Marche,Molise"
   $province XOR $regioni == ""
  */
  if($regioni == 'italia') {
    return 0;
  }
  $come = "";
  if (!$province) {
    $come = "Regione =".insertapici($regioni);
  } else {
    if (!$regioni) {
      $come = "Province = ".insertapici($province);
    } else {
      $come = "Regione =".insertapici($regioni)." AND Province = ".insertapici($province);
    }
  }
  $richiesta = requestquery("ID", "Raggio", $come);
  $risultato = dbrequest($GLOBALS['db'], $richiesta);
  if (empty($risultato)) {
    return createraggio($province, $regioni);
  } else {
    return $risultato[0]["ID"];
  }
  /*
  VALORI RITORNATI:
  - -1 da createraggio in caso di errori nell'inserimento
  - un nuovo raggio creato da createraggio se non esiste
  - un intero che corrisponde al codice relativo al raggio richiesto (0 se italia)
  */
}

function createraggio($province, $regioni) {
  /*
  PRECONDIZIONI:
  $province contiene un insieme di sigle di provincia in uno di questi formati:
  - ""
  -"AA"
  -"AA,BB,CC"
  $regioni contiene un insieme di sigle di provincia in uno di questi formati:
  -""
  -"Umbria"
  -"Umbria,Marche,Molise"
   $province XOR $regioni == ""
  */
  $what = ' MAX(ID) AS '.insertapici("Nuovo");
  $where = 'Raggio';
  $query = requestquery($what, $where, "");
  $ris = dbrequest($GLOBALS['db'], $query);
  $newraggio= $ris[0]["Nuovo"]+1;
  $cosa = [
    'ID' =>$newraggio
  ];
  echo "Regioni =";
  print_r($regioni);
  echo "<br>$province<br>";
  if(!empty($regioni)) {
    $cosa['Regione'] = $regioni;
  }
  if (!empty($province)) {
    $cosa['Province'] = $province;
  }
  unset($query);
  $query = insertquery($cosa, $where, FALSE);
  echo $query;
  if (!dbinsert($GLOBALS['db'], $query)) {
    return $query;
  } else {
    return $newraggio;
  }
/*
  VALORI RITORNATI:
  -1 se c'é stato un problema nell'inserimento della $query
  un intero >0 che corrisponde al nuovo id del raggio altrimenti
*/
}

function lunghezzacompresa($stringa , $max , $min = 0) {
  if (strlen($stringa) > $max || strlen($stringa) < $min) {
    return 0;
  } else {
    return 1;
  }
}

function insertapici($element) { // No comment
  return '\''.$element.'\'';
}

function province($regioni = FALSE, $where = FALSE) {
  /*
  Province()              restituisce le regioni
  Province(TRUE)          restituisce la tabella con regioni e Province
  Province(TRUE, $where)  restituisce la tabella sopra ristretta dal $where e ordinata in base alla regione
  */
  if($regioni != FALSE){
    $altraquery = 'SELECT * FROM province';
  } else {
    $altraquery = 'SELECT DISTINCT regione_province FROM province';
  }
  if ($where != FALSE) {
    $altraquery.= " WHERE $where";
  }
  $altraquery.= " ORDER BY regione_province";
  $DB = $GLOBALS['db'];
  $rispro = dbrequest($DB, $altraquery);
  return $rispro;
}

function categorie($strict = FALSE) {
  /* RItorna la tabella categorie del DB se strict == False, altrimenti
  se strict == cat allora ritorna le Categorie
  se strict == gruppo allora ritorna solo i gruppi
  ritorna solo le categorie
  */
  $query = "";
  switch ($strict) {
    case FALSE:
      $query = 'SELECT * FROM Categorie ORDER BY Gruppo DESC, Nome';
    break;

    case 'cat':
      $query = 'SELECT Nome FROM Categorie ORDER BY Nome';
    break;

    case 'gruppo':
      $query = 'SELECT DISTINCT Gruppo FROM Categorie ORDER BY Gruppo';
    break;

  }
  $DB = $GLOBALS['db'];
  $ris = dbrequest($DB, $query);
  return $ris;
}

function requestquery($cosa, $dove, $come = "", $order = FALSE, $distinct = FALSE) {
  // Ti prefabbrica una richesta SQL
  $query = "SELECT ";
  if ($distinct !== FALSE) {
    $query.= "DISTINCT ";
  }
  if (is_array($cosa)) {
    foreach ($cosa as $key => $value) {
      $query .= "$value ";
      if ($value != end($cosa)) {
        $query .= ", ";
      }
    }
  } else {
    if (empty($cosa)) {
      $query .= "* " ;
    } else {
      $query .= "$cosa ";
    }
  }
  $query.= "FROM $dove ";
  if ( !empty($come)) {
    $query.="WHERE $come ";
  }
  if ($order != FALSE) {
    $query.= "ORDER BY $order";
  }
  $query.=";";
  return $query;
}

function insertquery($arrayordinato, $dove, $all = TRUE) {
  // Ti prefabbrica una insert query sql
  $query = "INSERT INTO $dove ";
  $campi = "";
  $valori = "";
  foreach ($arrayordinato as $key => $value) {
    $campi .= " $key";
    $valori .= " ".insertapici($value);
    unset($arrayordinato[$key]);
    if (!empty($arrayordinato)) {
      $campi.= ",";
      $valori.= ",";
    }
  }
  if ($all != TRUE) {
    $query.= "( $campi )";
  }
  $query .= " VALUES ( ".$valori." );";
  return $query;
}



function updatequery($arrayordinato, $dove, $come) {
  // Ti prefabbrica una update query sql
  $query = "UPDATE $dove SET ";
  foreach ($arrayordinato as $key => $value) {
    $query.=" $key = ".insertapici($value);
    unset($arrayordinato[$key]);
    if (!empty($arrayordinato)) {
        $query.=",";
    }
  }
  if (!empty($come)) {
    $query.=" WHERE $come ;";
  }
  return $query;
}

function deletequery($dove, $come) {
  // Ti prefabbrica una richesta SQL
  $query = "DELETE ";
  $query.= "FROM $dove ";
  if ( !empty($come)) {
    $query.="WHERE $come ";
  }
  $query.=";";
  return $query;
}

function dbrequest(string $DB, string $query) {
  // RItorna la risposta del Database DB alla $query
  $mysqli = mysqli_connect('localhost', 'root', 'root', $DB);
  if (!$mysqli) {
      die('Errore di connessione (' .mysqli_connect_error(). ')' );
  }
  $result =   mysqli_query ($mysqli, $query);
  if (!$result) {
    return FALSE;
  } else {
    $risultati = array();
    while ($riga = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $risultati[] = $riga;
    }
  }
  mysqli_free_result($result);
  return $risultati;
}

function dbinsert(string $DB , string $query) {
  // Boleano, inserisce la $query nel Database DB
  $mysqli = mysqli_connect('localhost', 'root', 'root', $DB);
  if (!$mysqli) {
      die('Errore di connessione (' .mysqli_connect_error(). ')' );
  }
  $result = mysqli_query($mysqli, $query);
  if (!$result || mysqli_affected_rows($mysqli)<1) {
    return FALSE;
  } else {
    return TRUE;
  }
}

function &striparray(&$array) {
  // La unica funzione passata x riferimento PHP, ricorsiva tra l'altro. Esegue i comandi
  //  strip_tags e htmlentities su tutti gli elementi dell'array dato
  foreach ($array as $key => &$value) {
    if (is_array($value)) {
      $value = striparray($value);
    } else {
      $value = strip_tags(htmlentities($value));
    }
  }
  return $array;
}

function &enfatizza( &$string , string $bold = '', string $enf = '') {
//   Al momento non usata, mette i tag strong ed em dentro alle stringhe date
if ($bold != '' && $bold != ' ' /*&& strpos($string, $bold) != FALSE*/) {
    $string = str_replace($bold , '<strong>'.$bold.'</strong>', $string);
  }
if ($enf != '' && $enf != ' '/* && strpos($string, $enf) != FALSE*/) {
    $string = str_replace($enf , '<em>'.$enf.'</em>', $string);
  }
  return $string;
}

function iscomplete($array) {
  // ritorna falso si da un array vuoto o un array con elementi empty
  if (!is_array($array)) {
    return false;
  }
  foreach ($array as $key => $value) {
    if (empty($value)) {
      return false;
    }
  }
  return true;
}

function controllarray($arr) {
  // Funzione a misura di input, restituisce un array dei risultati
  // delle specifiche funzioni a seconda del nome della chiave di quella funzione
  $result = array();
  if (is_array($arr) && !empty($arr)) {
    foreach ($arr as $key => $value) {
      switch ($key) {
        case 'email':
          $result[$key] = isemail($value);
          break;

        case 'prov':
            $result[$key] = isprov($value);
            break;

        case 'tel':
          $result[$key] = istelefono($value);
          break;

        case 'citta':
          $result[$key] = iscitta($value);
          break;

        case 'certificazione':
          $result[$key] = iscert($value);
          break;

        case 'prezzo':
          $result[$key] = isprezzo($value);
          break;

        case 'desc':
          $result[$key] = (lunghezzacompresa($value, 300) && (in_array(tipostringa($value), array('000','100', '101' ,'110', '111'))))? 1 : 0;
          break;

        case 'pass':
          $result[$key] = (lunghezzacompresa($value, 12, 1))? 1 : 0;
          break;

        case 'nome':
          //(in_array(tipostringa($value), array('110', '100')))
          $temp=str_replace(' ', '', $value);
          $result[$key] = (lunghezzacompresa($temp, 45, 2) && (tipostringa($temp) == '100' || tipostringa($temp) == '110'))? 1 : 0;
          break;

        case 'cognome':
          //(in_array(tipostringa($value), array('110', '100')))
          $temp=str_replace(' ', '', $value);
          $result[$key] = (lunghezzacompresa($temp, 45, 2) && (tipostringa($temp) == '100' || tipostringa($temp) == '110'))? 1 : 0;
          break;

        case 'via':
          $result[$key] = (lunghezzacompresa($value, 30, 2) && (in_array(tipostringa($value), array('100', '101' ,'110', '111'))))? 1 : 0;
          break;

        case 'cap':
          $tipo = tipostringa($value);
          (lunghezzacompresa($value, 10, 2) && ($tipo == '100' || $tipo == '110' || $tipo == '010')) ? $result[$key] = 1: $result[$key] = 0;
          break;
      }
    }
  }
  return $result;
}

function boolregexp($model, $string) {
  // boleana, restituisce true se trova almeno un match tra la stringa $string e il modello di
  // espressione regolare $model
    preg_match($model, $string, $matches);
    if (empty($matches) ) {
      return 0;
    } else {
      return 1;
    }
}

function isimage($array) {
  /* Controllo di integritá di una immagine del $_GET o del $_POST
    Puó restituire:
                  1   Tutto OK
                  -1  Il nome del file non contiene una estensione valida
                  -2  Il tipo del file non é valido
                  -3  Il file é troppo grande (>5MB)
  */
  if (!is_array($array) || empty($array)) {
    return FALSE;
  }
  $nome = strtoupper($array["name"]);
  $type = strtoupper($array["type"]);
  $modelnome = '/^(\S)*.(JPG|PNG|BMP|JPEG)$$/ ';
  $modeltype = '/(JPG|PNG|BMP|JPEG)/ ';
  if( !boolregexp($modelnome, $nome)) {
    return -1;
  } else {
    if( !boolregexp($modeltype, $type)) {
      return -2;
    } else {
      if($array["size"] > "5242880" ) {
        return -3;
      } else {
        return 1;
      }
    }
  }
}

function iscitta($string) {
  $bool = lunghezzacompresa($string, 30, 2);
  if($bool && (tipostringa($string) == '100' || tipostringa($string) == '101') ) {
    return 1;
  } else {
    return 0;
  }
}

function isprov($string) {
  $bool = lunghezzacompresa($string, 60);
  $model = '/^[A-Z]{2}(,( )?[A-Z]{2})*$/ ';
  if( $bool && boolregexp($model, $string) ) {
    return 1;
  } else {
    return 0;
  }
}

function iscert($string) {
  $bool = lunghezzacompresa($string, 30);
  $model = '/^(BIO|IGP|STG|DOC|DOP|IGT|DOCG|SLOW FOOD)((\,|\, )(BIO|IGP|STG|DOC|DOCG|DOP|IGT|SLOW FOOD))?$/ ';
  if( $bool && boolregexp($model, $string) ) {
    return 1;
  } else {
    return 0;
  }
}

function isprezzo($float, $max = 1000.0, $min = 0.0) {
  $model = '/^[0-9]{1,4}([,.]?[0-9]{1,2})?$/ ';
  echo boolregexp($model, $float);
  if(boolregexp($model, $float) && $float < $max && $float > $min ) {
    return 1;
  } else {
    return 0;
  }
}

function isemail($string) {
  $bool = lunghezzacompresa($string, 35);
  $model = '/^[A-Za-z0-9]{3}[A-Za-z0-9]*@[A-Za-z][A-Za-z]+\.[A-Za-z][A-Za-z]+$/ ';
  if( $bool && boolregexp($model, $string) ) {
    return 1;
  } else {
    return 0;
  }
}

function istelefono($string){
  $bool = lunghezzacompresa($string, 20);
  $model =0;
  if(substr( $string , 0 , 0 )=="+"){
    $model=is_numeric(substr( $string , 1 , -1 ));
  }
  else {
    $model=is_numeric(substr( $string , 0 , -1 ));
  }
  if( $bool && $model)  {
    return 1;
  } else {
    return 0;
  }
}

function tipostringa($string){
  /*
  Funzione in base 2: ogni cifra del numero a tre cifre restituisce una tot caratteristica della stringa:
        La cifra in posizione 1 indica se la $string contiene lettere
        La cifra in posizione 2 indica se la $string contiene numeri
        La cifra in posizione 3 indica se la $string contiene caratteri speciali

        per es:

        100 => solo lettere
        011 => numeri e caratteri speciali
        111 => di tutto
  */
  $bin = '0';
  $both = '/^[A-Za-z0-9]+$/ ';
  $num = '/[0-9]+/ ';
  $char = '/[A-Za-z]+/ ';
  $special= !boolregexp($both, $string);
  $numeri = boolregexp($num, $string);
  $lettere = boolregexp($char, $string);
  if ($lettere) {
     $bin = '1';
  }
  if ($numeri) {
    $bin .= '1';
  } else {
    $bin .= "0";
  }
  if ($special) {
    $bin .= "1";
  } else {
    $bin .= "0";
  }
  return $bin;
}

function extensionofimage($nome) {
    $model = '/(JPG|PNG|BMP|JPEG)$/ ';
    preg_match($model, $nome, $matches);
    return $matches;
}

function fileimage($arrfile, $localdir, $nome = "prova", $base = 'img/') {
  /*Tabella dei valori di ritorno:
  1 Tutto bene
  0 $arrfile non é un array oppure é vuoto
  -1 , -2, -3 sono riservati ad isimage
  -4 la combinazione $base.$localdir non é una cartella presente o visibile
  -5 errore nella scansione della cartella (che ci sia un errore in $base o in $localdir?)
  -6 errore nello spostamento del file (i permessi per quella cartella ci sono?)
  -7 errore nel riassegnare i permessi al file appena trasferito
  */
  $upload = isimage($arrfile);
  $argh = extensionofimage(strtoupper($arrfile['name']));
  $estensione = strtolower($argh[0]);
  if($upload != 1) {
    return $upload; // Non é una immagine valida
  }
  $uploaddir = $base.$localdir;
  if (!is_dir($uploaddir)) {
    return -4; // $uploaddir non é una cartella
  }
  $dir = scandir($uploaddir);
  if (!$dir) {
    return -5; // ERRORE NELLA SCANSIONE DELLA CARTELLA
  }
  foreach ($dir as $key => $value) { // Eliminazione Vecchia foto profilo con altra estensione
    if(strpos($value, $nome) !== FALSE ) {
      $file = $uploaddir.$value;
      unlink($file);
    }
  }
  $filename= $uploaddir.$nome.'.'.$estensione;
  if (!move_uploaded_file($arrfile['tmp_name'], $filename)) {
     return -6; // ERRORE NELLO SPOSTAMENTO DEL FILE
  }
  if (chmod($filename, 0777)) {
    return 1;
  } else {
    return -7;
  }
}

function stampaerrore($errore) {
  if(!empty($_SESSION['insproer'])){ // Pagina Prodotto
    switch ($errore) {
      case 'nome':
        if(isset($_SESSION['insproer']['nome']) && !$_SESSION['insproer']['nome']) {
          echo "<p class='err'>Errore nel nome: massimo 30 caratteri e nessun carattere speciale</p>";
        }
        break;

      case 'certificazione':
        if(isset($_SESSION['insproer']['certificazione']) && !$_SESSION['insproer']['certificazione']) {
          echo "<p class='err'>Errore nella certificazione: vedi sopra le certificazioni ammesse</p>";
        }
        break;

      case 'prov':
        if(isset($_SESSION['insproer']['prov']) && $_SESSION['insproer']['prov'] != 1) {
          echo "<p class='err'>Errore nella provincia: usare la sigla della provincia</p>";
        }
        break;

      case 'desc':
        if(isset($_SESSION['insproer']['desc']) &&!$_SESSION['insproer']['desc']) {
          echo "<p class='err'>Errore nella descrizione: ammessi massimo 300 caratteri </p>";
        }
        break;

      case 'prezzo':
        if(isset($_SESSION['insproer']['prezzo']) && !$_SESSION['insproer']['prezzo']) {
          echo "<p class='err'>Errore nel prezzo: sono ammessi solo numeri nel formato 3,35 </p>";
        }
        break;
    }
  }
}
  function erroremodifica($errore) {
    if(!empty($_SESSION['proup']) && $_SESSION['proup'] != 1){ // Pagina Modifica Profilo
      switch ($errore) {
        case 'nome':
          if(!isset($_SESSION['specerror']['nome'])) {
            echo "<p class='err'>Errore nel nome: massimo 30 caratteri e nessun carattere speciale</p>";
          }
          break;
        case 'email':
          if(!empty($_SESSION['ritornero']['email']) && $_SESSION['specerror']['email'] == 0  ) {
            echo "<p class='err'>Errore nella email: deve essere nella forma: esempio@example.it ed 'esempio' deve essere di almeno 3 caratteri</p>";
          }
          break;

        case 'desc':
          if(isset($_SESSION['specerror']['desc']) && $_SESSION['specerror']['desc'] != 1) {
            echo "<p class='err'>Errore nella descrizione: ammessi massimo 300 caratteri </p>";
          }
          break;

        case 'citta':
          if(isset($_SESSION['specerror']['citta']) && $_SESSION['specerror']['citta'] != 1) {
            echo "<p class='err'>Errore nella citta: minimo 3 e massimo 30 caratteri </p>";
          }
          break;

        case 'cap':
          if(isset($_SESSION['specerror']['cap']) && $_SESSION['specerror']['cap'] != 1) {
            echo "<p class='err'>Errore nel cap inserito: minimo 3 caratteri </p>";
          }
          break;

        case 'tel':
          if(isset($_SESSION['ritornero']['tel']) && isset($_SESSION['specerror']['tel']) && $_SESSION['specerror']['tel'] != 1) {
            echo "<p class='err'>Errore nel telefono inserito: massimo 20 cifre</p>";
          }
          break;

        case 'via':
          if(isset($_SESSION['specerror']['via']) && $_SESSION['specerror']['via'] != 1) {
            echo "<p class='err'>Errore nel indirizzo inserito: minimo 2 massimo 30 caratteri</p>";
          }
          break;
      }
    }
}

function erroremodificaprodotto($errore) {
  if(!empty($_SESSION['modproer']) && is_array($_SESSION['modproer'])){ // Pagina Modifica Profilo
    switch ($errore) {
      case 'nome':
        if($_SESSION['modproer']['nome'] == 0) {
          echo "<p class='err'>Errore nel nome: massimo 30 caratteri e nessun carattere speciale</p>";
        }
        break;

      case 'desc':
        if(isset($_SESSION['modproer']['desc']) && $_SESSION['modproer']['desc'] != 1) {
          echo "<p class='err'>Errore nella descrizione: ammessi massimo 300 caratteri </p>";
        }
        break;

      case 'certificazione':
        if(isset($_SESSION['modproer']['certificazione']) && $_SESSION['modproer']['certificazione'] != 1) {
          echo "<p class='err'>Errore nella certificazione: vedi sopra le certificazioni ammesse</p>";
        }
          break;

      case 'prov':
        if(isset($_SESSION['modproer']['prov']) && $_SESSION['modproer']['prov'] != 1) {
          echo "<p class='err'>Errore nella provincia: usare la sigla della provincia</p>";
        }
        break;

      case 'prezzo':
        if($_SESSION['modproer']['prezzo'] != 1) {
          echo "<p class='err'>Errore nel prezzo: sono ammessi solo numeri nel formato 3,35 </p>";
        }
        break;
    }
  }
}

function stampavalue($value, $array) {
  if(!empty($array) && is_array($array) && array_key_exists($value,$array) && $array[$value] != "") {
    echo 'value="'.$array[$value].'"';
  }
}

function stampaprodotto($array) {
  if (is_array($array) && !empty($array)) {
    $Nome = str_replace("0", " ", $array["Nome"]);
    return '<div class="Prodottosingolo">
    <p class="Riga">'.$Nome.'</p>
    <p class="Riga Prezzo">'.$array["Prezzo"].'&euro;</p>
    <form method="post" action="sicuro.php">
      <input type="hidden" name="dati" value="'.implode("O;O",$array).'"/>
      <input class="Riga" type="submit" name="modifica" value="Modifica"/>
      <input class="Riga" type="submit" name="elimina" value="Elimina"/>
    </form>
    </div>';
  }
}
function stampalink($numero, $pagina='modprodotto.php', $altroinput = "", $all = "") {
  if($all != "") $all = "&all=1";
  if ($altroinput != "") {
    $link='
    <a class="Successive" href="'.$pagina.'?'.$altroinput.'&page='.$numero.$all.'">'.$numero.'</a>';
  } else {
    $link='
    <a class="Successive" href="'.$pagina.'?page='.$numero.'">'.$numero.$all.'</a>';
  }
  return $link;
}

function estraiImmagine($percorso, $nome){
  /*
    Valori di ritorno di codesta funzione:
    0  sse $percorso non é una CARTELLA
    -1 sse non esiste un file che ha un nome similare a $nome
    Una stringa nel formato $nome.estensione nel caso esista il file
  */

  if (!is_dir($percorso)) {
    return -2;
  }
  $nomemodel = $nome."\.";
  $nome.=".";
  $dir = scandir($percorso);
  $file = "";
  $model = '/^'.$nomemodel.'/ ';
  foreach ($dir as $key => $value) {
    if(strpos($value, $nome, 0) !== FALSE && boolregexp($model ,$value) != FALSE ) {
      $file = $value;
    }
  }
  if ($file == "" || $file == "." || $file == "..") {
    return -1;
  } else {
    return $file;
  }
}

function elementipg($querycontatore, $queryrichiesta, $unionquery ,$pagina, $numeroperpag ){
/*  NON VENGONO FATTI CONTROLLI DI COERENZA SUI PARAMETRI DI INGRESSO, salvo che il numero di pagina sia coerente
  Valori di ingresso:
  $pagina é un int che contiene la pagina attuale
  $numeroperpag sono il numero di elementi perogni pagina
  $querycontatore é la query per contare il numero di elementi nel db. Il count DEVE avere alias NUMERO
  #$queryrichiesta é la query per gli elmenti
  $unionquery é una eventuale query da mettere in UNION con $queryrichiesta
  PS: eventuali LIMIT e OFFSET di $queryrichiesta vengono calcolato dalla funzione
*/
$ritorno = array();
$ritorno[0] = 0;
$numeroarr = dbrequest($GLOBALS['db'], $querycontatore);
if (empty($numeroarr)) {
  $ritorno[0] = -1;
  return $ritorno;
}
$numero = $numeroarr[0]['NUMERO'];
$ritorno[0] = $numero;

$ritorno[1] = floor($numero/$numeroperpag);
if (($numero%$numeroperpag) != 0 ) {
  $ritorno[1]++;
}

if ($ritorno[1] < $pagina) {
  if ($ritorno[1] == 0) {
    $ritorno[0] = -3;
  } else {
    $ritorno[0] = -2;
  }
  return $ritorno;
}
if (!empty($unionquery)) {
  $queryrichiesta = '( '.$queryrichiesta.') UNION ( '.$unionquery.' )';
}
$queryrichiesta.= " LIMIT $numeroperpag";
if ($pagina > 1) {
  $queryrichiesta.= " OFFSET ".($numeroperpag*($pagina-1));
}
$ritorno[2] = dbrequest($GLOBALS['db'], $queryrichiesta);
//echo "<br> $queryrichiesta <br>";
//print_r ($ritorno);
//die();
return $ritorno;
/* Valori di ritorno: array con:
[0] = numero totale elementi nel db.
      Se -1 indica un errore del server o della query
      Se -2 indica una pagina fuori dal numero massimo di pagine
      Se -3 indica che la query contatore dà risultato 0
[1] = il numero massimo di pagine
[2] = SE PRESENTE, ovvero [0] != 0, continere un array con i $numeroperpag elementi,
      oppure meno a seconda di quanti ce ne sono nel db
*/
}

function ricercapg($query,$pagina, $numeroperpag ){
/*  NON VENGONO FATTI CONTROLLI DI COERENZA SUI PARAMETRI DI INGRESSO, salvo che il numero di pagina sia coerente
  Valori di ingresso:
  $pagina é un int che contiene la pagina attuale
  $numeroperpag sono il numero di elementi perogni pagina
  $numero é la query per contare il numero di elementi nel db. Il count DEVE avere alias NUMERO
  #$queryrichiesta é la query per gli elmenti
  $unionquery é una eventuale query da mettere in UNION con $queryrichiesta
  PS: eventuali LIMIT e OFFSET di $queryrichiesta vengono calcolato dalla funzione
*/
$ritorno = array();
$ritorno[0] = 0;
$contrisultato = dbrequest($GLOBALS['db'], $query);
$query.= " LIMIT $numeroperpag";
if ($pagina > 1) {
  $query.= " OFFSET ".($numeroperpag*($pagina-1));
}
$risultato = dbrequest($GLOBALS['db'], $query);
$numero = count($contrisultato);
$ritorno[0] = $numero;

$ritorno[1] = floor($numero/$numeroperpag);
if (($numero%$numeroperpag) != 0 ) {
  $ritorno[1]++;
}

if ($ritorno[1] < $pagina) {
  if ($ritorno[1] == 0) {
    $ritorno[0] = -3;
  } else {
    $ritorno[0] = -2;
  }
  return $ritorno;
}
$ritorno[2] = $risultato;
return $ritorno;
/* Valori di ritorno: array con:
[0] = numero totale elementi nel db.
      Se -1 indica un errore del server o della query
      Se -2 indica una pagina fuori dal numero massimo di pagine
      Se -3 indica che la query contatore dà risultato 0
[1] = il numero massimo di pagine
[2] = SE PRESENTE, ovvero [0] != 0, continere un array con i $numeroperpag elementi,
      oppure meno a seconda di quanti ce ne sono nel db
*/
}

?>
