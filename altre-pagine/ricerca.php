<?php
session_start();
require_once('../function.php');
$search = str_replace(" ", "0", trim($_GET['search']));
$search=controllosearch($search);
$titolo='Ricerca';
$temp='<link rel="stylesheet" type="text/css" href="../css/ricerca-desktop.css" media="screen and (min-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../css/ricerca-smartphone.css" media="screen and (max-width:1023px)"/>
<link rel="stylesheet" type="text/css" href="../css/ricerca(print).css" media="print"/>
';

unset($_SESSION['mdp']);

/*------------------------------------------------INIZIO FUNZIONI--------------------------------------------------*/

function ricercaesatta($search, &$queryarray = array()) { // un solo "roba"esatto, UNO, 1
	/*
	//ordine ricerca Prodotto, Venditore, Categoria
	//ritorna un array di array di array se ricerca andata a buon fine ed una flag che specifica le richieste fatte, ritorna false se c'è stato un errore
	*/
	$regprov='';
	$cond='Prodotti.Nome='.insertapici($search);
	if($_SESSION['regione']!='-'){
		if($_SESSION['provincia']!='-'){
			$regprov=' AND (Raggio.Regione LIKE '.insertapici("%".$_SESSION['regione']."%").' OR Raggio.Province LIKE '.insertapici("%".$_SESSION['provincia']."%").' OR Raggio.ID='.insertapici("0").')) UNION ( SELECT Prodotti.ID, Prodotti.Nome, Prodotti.Negozio, Prodotti.Prezzo FROM Prodotti WHERE '.$cond.' AND Prodotti.ID NOT IN (SELECT Prodotti.ID FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio=Raggio.ID WHERE Prodotti.Raggio = '.insertapici("0").' OR Raggio.Regione LIKE '.insertapici("%".$_SESSION['regione']."%").' OR Raggio.Province LIKE '.insertapici("%".$_SESSION['provincia']."%").')';
		}
		else {
			$regprov=' AND (Raggio.Regione LIKE '.insertapici("%".$_SESSION['regione']."%").' OR Raggio.ID='.insertapici("0").')) UNION ( SELECT Prodotti.ID, Prodotti.Nome, Prodotti.Negozio, Prodotti.Prezzo FROM Prodotti WHERE '.$cond.' AND Prodotti.ID NOT IN (SELECT Prodotti.ID FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio=Raggio.ID WHERE Prodotti.Raggio = '.insertapici("0").' OR Raggio.Regione LIKE '.insertapici("%".$_SESSION['regione']."%").')';
		}
	}
	/*
	$query=requestquery("ID, Nome, Negozio, Prezzo", "Prodotti", "Nome=".insertapici($search), "Nome");
	*/
	$query='(SELECT Prodotti.ID, Prodotti.Nome, Prodotti.Negozio, Prodotti.Prezzo FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio=Raggio.ID WHERE '.$cond.' '.$regprov.' LIMIT 8);';

	$queryarray['Prodotti']=$query;
	$array = [
		"prodottiesatto" => dbrequest($GLOBALS["db"], $query)
	];

	if($array["prodottiesatto"]===FALSE) {
		return FALSE;
	}

	$flag3=0;					//flag su quale request ha funzionato

	if(empty($array["prodottiesatto"])) {
		unset($array["prodottiesatto"]);
		$query=requestquery("Nome", "Negozi", "Nome=".insertapici($search));
		$queryarray['Venditori']=$query;
		$array["venditoriesatto"] = dbrequest($GLOBALS["db"], $query);
		if(empty($array["venditoriesatto"])) {
			unset($array["venditoriesatto"]);
			$query=requestquery("Nome", "Categorie", "Nome=".insertapici($search));
			$queryarray['Categorie']=$query;
			$array["categorieesatto"] = dbrequest($GLOBALS["db"], $query);
			if(empty($array["categorieesatto"])) {
				unset($array["categorieesatto"]);
			}
			else {
				$flag3="categorieesatto";
			}

		}
		else {
			$flag3="venditoriesatto";
		}
	}
	else {
		$flag3="prodottiesatto";
	}
	$array["flag"]= $flag3;
	$bool=FALSE;
	if(!array_key_exists("categorieesatto", $array) && strlen($search)>3) {
		$simile=ricercasimile($search, $queryarray);

		if(!empty($simile)) {
			$bool=TRUE;
			$array["simile"]=$simile;
		}
	}
	$like = ricercaLIKE($array, $search, $bool, $queryarray);

	foreach ($like as $key => $value) {
		$array[$key] = $like[$key];
	}
	return $array;
}

function ricercasimile($search, &$queryarray) {
	/*
	Ritorna un array di array con i nomi ed i tag delle categorie che contengono $search meno l'ultima lettera nel tag

	-prendere tag da database
	-fare explode("segno", stringa) dei tag //non più usato
	-confrontare quei tag con la $search(senza l'ultima lettera)
	*/
	$str =	substr($search, 0, strlen($search)-1);
	$str1 = "%$str%";
	$prova="%_$str%";
	$str1 = str_replace("0", "%0%", $str1);
	$prova = str_replace("0", "%0%", $prova);
	$query=requestquery("Nome, Tag", "Categorie", "Tag LIKE ".insertapici($str1)." AND Tag NOT LIKE ".insertapici($prova));
	$queryarray['Categorie']=$query;
	$array["simile"] = dbrequest($GLOBALS["db"], $query);

	return $array["simile"];
}


function ricercaLIKE($array1, $search, $bool=FALSE, &$queryarray=array()) {
	/*
	Ritorna un array di array con i nomi (dei prodotti/delle categorie/dei venditori che contengono $search meno l'ultima lettera nel nome) meno i risultati della ricerca esatta (if) oppure "falso" se ci sono stati errori
	*/
	$str=$search;
	if (strlen($search)>3){
		$str =	substr($search, 0, strlen($search)-1);
	}
	$str1 = "%$str%";
	$prova="$str";
	$nostr="%_$str%";
	$str1 = str_replace("0", "%0%", $str1);
	$prova = str_replace("0", "%0%", $prova);
	$prova="%0$str%";

	$regge = '';
	$cond="Nome LIKE ".insertapici($str1)." A'.'ND Nome NOT LIKE ".insertapici($prova);
	if($_SESSION['regione']!='-'){
		if($_SESSION['provincia']!='-'){
			$regge = ' A'.'ND (Raggio.Regione LIKE '.insertapici("%".$_SESSION['regione']."%").' O'.'R Raggio.Province L'.'IKE '.insertapici("%".$_SESSION['provincia']."%").' OR Raggio.ID='.insertapici("0").') ';
		}
		else {
			$regge = ' A'.'ND (Raggio.Regione LIKE '.insertapici("%".$_SESSION['regione']."%").' OR Raggio.ID='.insertapici("0").')';
		}
	}

	$query='(SELECT Prodotti.ID, Prodotti.Nome, Prodotti.Negozio, Prodotti.Prezzo FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio=Raggio.ID WHERE Prodotti.Nome LIKE '.insertapici($str1).' AND Nome NOT LIKE '.insertapici($nostr).' '.$regge.') ';
	$query.= 'UNION (SELECT Prodotti.ID, Prodotti.Nome, Prodotti.Negozio, Prodotti.Prezzo FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio=Raggio.ID WHERE Prodotti.Nome LIKE '.insertapici($prova).' '.$regge.') ';
	if ($regge != "") {
		$query.='UNION ( SELECT Prodotti.ID, Prodotti.Nome, Prodotti.Negozio, Prodotti.Prezzo FROM Prodotti WHERE Nome LIKE '.insertapici($str1)." A"."ND Nome NOT LIKE ".insertapici($nostr).' A'.'ND Prodotti.ID NOT IN (SELECT Prodotti.ID FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio=Raggio.ID WHERE '.str_replace(" AND (", "", $regge).' )';
		$query.='UNION ( SELECT Prodotti.ID, Prodotti.Nome, Prodotti.Negozio, Prodotti.Prezzo FROM Prodotti WHERE Nome LIKE '.insertapici($prova).' A'.'ND Prodotti.ID NOT IN (SELECT Prodotti.ID FROM Prodotti INNER JOIN Raggio ON Prodotti.Raggio=Raggio.ID WHERE '.str_replace(" AND (", "", $regge).' )';
	}
	$query.="LIMIT 8;";
	/*

	$query=requestquery("ID, Nome, Negozio, Prezzo", "Prodotti", $cond, "Nome LIMIT 8");
	*/
	$queryarray['Prodotti']=$query;
	$array["prodottiLIKE"] = dbrequest($GLOBALS["db"], $query);

	$query=requestquery("Nome", "Negozi", "Nome LIKE ".insertapici($str1)." LIMIT 8");
	$queryarray['Venditori']=$query;
	$array["venditoriLIKE"] = dbrequest($GLOBALS["db"], $query);

	if($bool==FALSE) {		//se trovati tag, allora ricerca sulla categoria è inutile
		$query=requestquery("Nome", "Categorie", "Nome LIKE ".insertapici($str1)." AND Nome NOT LIKE ".insertapici($nostr)." LIMIT 8");
		$queryarray['Categorie']=$query;
		$array["categorieLIKE"] = dbrequest($GLOBALS["db"], $query);
	}
	if ($array1["flag"]!==0 && !($bool==TRUE && $array1["flag"]=="categorieesatto") ) {
		$flag= str_replace("esatto", "LIKE", $array1["flag"]);
		$str2 = $array1["flag"];

		for ($i = 0; $i < count($array1[$str2]); $i++) {
			for ($j = 0; $j < count($array[$flag]); $j++) {
				if(array_key_exists("Nome", $array[$flag][$j]) && $array[$flag][$j]["Nome"] == $array1[$str2][$i]["Nome"] ) {
					$array[$flag][$j] = array();
				}
			}
		}
		foreach ($array[$flag] as $key => &$value) {
			if (empty($array[$flag][$key])) {
				unset($array[$flag][$key]);
			}
		}
		$array[$flag]=array_values($array[$flag]);	//dopo aver tolto i buchi, rinumerato l'array
	}

	foreach ($array as $key => &$value) {	//unset della $flag.'esatto' se vuoto (che ricordiamo è solo UNO)
		if (empty($array[$key])) {
			unset($array[$key]);
		}
	}
	return $array;

}

function outputricerca($array, &$arrayquery=array(), $search='') {
	/*
	Stampa le ricerche se c'è qualcosa da stampare, stampa qualcosa se l'array è vuoto, ritorna falso se ci sono stati errori prima.
	input: array con chiavi "flag", "simile", roba."LIKE" o roba."esatto"
	*/

	if($array==FALSE) {
		return FALSE;
	}
	$flag=$array['flag'];

	//conteggio delle sezioni visualizzate
	$nothing=count($array);
	$ret=array();
	//definizione variabili per ricerca esatta
	if($flag!==0) {
		$ret['contes'.$flag]=stampaesatta($array['flag'], $array[$flag]);
		/*if($ret['contes'.$flag]['rimasti']>0) {
			$ret['mdpes'.$flag]="";
			$ret['mdpes'.$flag]='<form action="ricercamdp.php" method="post" class="Clearer">
			<fieldset>
				<input class="Mdp" name="prodotti o categorie o venditori" type="submit" value="Mostra di più"/>
				<input name="query" type="hidden" value="'.$arrayquery[$catquery].'"/>
			</fieldset>
		</form>
		';
		}*/
		unset($array[$flag]);
		//nessuno "mostra di più" perchè la ricerca esatta dovrebbe restituire solo un risultato
		$ret['fsezionees']='</div>
		';
		unset($ret['contes'.$flag]['rimasti']);
		if(count($array)>1) {
			$ret['linea'.$flag]='<div class="Divx"></div>
			';
		}
		if(empty($ret['contes'.$flag]['cont'])){
			unset($ret['linea'.$flag]);
			unset($ret['contes'.$flag]);
			unset($ret['fsezionees']);
			--$nothing;
		}
	}
	//definizioni variabili per ricerca tag
	if(array_key_exists("simile", $array)) {
		$ret['contsim'.$flag]=stampasimile($array["simile"]);
		//nessuno "mostra di più" perchè la ricerca per tag dovrebbe restituire solo un risultato
		unset($array['simile']);
		$ret['fsezionesim']='</div>
		';
		unset($ret['contsim'.$flag]['rimasti']);
		if(!empty($array)) {
			$ret['linea'.$flag]='<div class="Divx"></div>
			';
		}
		//controllo per cancellare intera sezione se contenuto è vuoto
		if(empty($ret['contsim'.$flag]['cont'])){
			unset($ret['linea'.$flag]);
			unset($ret['contsim'.$flag]);
			unset($ret['fsezionesim']);
			//togliere la sezione dal conteggio di quelle visualizzate
			--$nothing;
		}
	}
	unset($array['flag']);
	//definizione variabili ricerca generale
	if(!empty($array)){
		foreach ($array as $key => $value) {
			$flag=ucfirst(substr($key, 0, strlen($key)-4));
			$str = ucfirst(substr($flag, 0, strlen($flag)-6));
			$catquery=$flag;

			if($str==$flag) {
				$flag.=' simili';
				$catquery=substr($flag, 0, strlen($flag)-6);
			}
			$ret['contgen'.$flag]=stampagenerale($flag, $array[$key]);
			if($ret['contgen'.$flag]['rimasti']>0) {
                $ret['mdpgen'.$flag]="";
                $ret['mdpgen'.$flag]='<form action="ricercamdp.php" method="post" class="Clearer">
                <fieldset>
                    <label for="'.$catquery.'1" class="RicercaVia">1</label>
                    <input id="'.$catquery.'1" class="Mdp" name="'.$catquery.'" type="submit" value="Mostra di più"/>
                    <label for="'.$catquery.'2" class="RicercaVia">2</label>
                    <input id="'.$catquery.'2" name="query" type="hidden" value="'.substr($arrayquery[$catquery], 0, strlen($arrayquery[$catquery])-8).'"/>
                    <label for="'.$catquery.'3" class="RicercaVia">3</label>
                    <input id="'.$catquery.'3" name="ricerca" type="hidden" value="'.$search.'"/>
                </fieldset>
            </form>
            ';
            }
			unset($array[$key]);
			unset($ret['contgen'.$flag]['rimasti']);
			$ret['fsezionegen'.$flag]='</div>
		';
			if(!empty($array)) {
				$ret['linea'.$flag]='<div class="Divx"></div>
				';
			}
			//controllo per cancellare intera sezione se contenuto è vuoto
			if(empty($ret['contgen'.$flag]['cont'])){
				unset($ret['linea'.$flag]);
				unset($ret['contgen'.$flag]);
				unset($ret['mdpgen'.$flag]);
				unset($ret['fsezionegen'.$flag]);
				//togliere la sezione dal conteggio di quelle visualizzate
				--$nothing;
			}
		}
	}
	if($nothing==1) {
		$ret['niente']='<h1 id="notFind">Ci spiace, il prodotto che stai cercando non &#232; stato trovato!</h1>';
	}
	return $ret;
	//NOME PREZZO NEGOZIO
}

function stampaesatta($flag, $array) {
	$flag=ucfirst(substr($flag, 0, strlen($flag)-6));
	$ret=array();
	$ret['flagesa']=$flag;
	$ret['isezesa']='<h1 class="Hric">'.$flag.'</h1>
	<div class="Row">
	';
	$ret['cont']='';
	if($flag=="Prodotti"){
		$ret['cont']=stampaprodotti($array);
	}
	else {
		$ret['cont']=stampaaltri($flag, $array);
	}
	//separazione del contenuto html dal numero che mi indica quanti oggetti avrei ancora potuto stampare
	$ret['rimasti']=substr($ret['cont'], 0, 1);
	$ret['cont']=substr($ret['cont'], 1, strlen($ret['cont']));
	return $ret;
}

function stampasimile($array) {
	$ret['isezsim']='<h1 class="Hric">Categorie</h1>
	<div class="Row">
	';
	$ret['cont']=stampaaltri('Categorie', $array);
	//separazione del contenuto html dal numero che mi indica quanti oggetti avrei ancora potuto stampare
	$ret['rimasti']=substr($ret['cont'], 0, 1);
	$ret['cont']=substr($ret['cont'], 1, strlen($ret['cont']));
	return $ret;
}

function stampagenerale($flag, $array) {
	$ret=array();
	$ret['flaggen']=$flag;
	$ret['isezgen']='<h1 class="Hric">'.$flag.'</h1>
	<div class="Row">
	';
	$ret['cont']='';
	if($flag=="Prodotti simili"| $flag=="Prodotti"){
		$ret['cont']=stampaprodotti($array);
	}
	else {
		$ret['cont']=stampaaltri($flag, $array);
	}
	//separazione del contenuto html dal numero che mi indica quanti oggetti avrei ancora potuto stampare
	$ret['rimasti']=substr($ret['cont'], 0, 1);
	$ret['cont']=substr($ret['cont'], 1, strlen($ret['cont']));
	return $ret;
}

function stampaprodotti($array) {
	$sezione="";
	$trovati=count($array);
	//$trovati rimane invariato (per la conduzione di uscita del for), mentre $rimasti cambia
	$rimasti=$trovati;
	for($i=0, $ciclo=4; $i<min($trovati, $ciclo); ++$i, --$rimasti) {
		$prodid=$array[$i]["ID"];
		$prezzo=$array[$i]["Prezzo"];
		$prodnome=str_replace("0", " ", $array[$i]["Nome"]);
		$vendnome=str_replace("0", " ", $array[$i]["Negozio"]);
		$scan =scandir('../img/product/');
		$file="";
		$file=estraiImmagine('../img/product/', $array[$i]["ID"]);
		if(is_numeric($file)){
			//qualcosa
			++$ciclo;
		}
		else {
			$sezione.='<div class="H">
				<a href="./prodotto.php?ID='.$prodid.'">
			    	<div class="Prduct">
			      		<p class="Price">&#8364;'.$prezzo.'</p>
			      		<img src="../img/product/'.$file.'" alt="'.$prodnome.'"/>
			      		<p class="Sdp">Scopri di pi&#249;</p>
			    	</div>
			  	</a>
			  	<a href="./prodotto.php?ID='.$prodid.'">
			   		<h2 class="Tit">'.$prodnome.'</h2>
			  	</a>
			  	<a href="./venditore.php?Nome='.$array[$i]["Negozio"].'">
				    Venditore: '.$vendnome.'
				</a>
			</div>
		';
		}
	}
	return $rimasti.$sezione;

}

function stampaaltri($flag, $array){
	$ret=array();
	$ret['flagaltr']=$flag;
	$sezione="";
	$folder="";
	$suff1="";
	$suff2="";
	if($flag=="Venditori") {
		$flag="venditore.php";
		$folder="negozi";
		$suff1="Nome=";
	}
	else {
		$flag="categoria.php";
		$folder="categorie";
		$suff1="cat=";
		$suff2="&page=1";
	}
	$file = "";
	$trovati=count($array);
	//$trovati rimane invariato (per la conduzione di uscita del for), mentre $rimasti cambia
	$rimasti=$trovati;
	for($i=0, $ciclo=4; $i<min($trovati, $ciclo); ++$i, --$rimasti) {
		$nome=$array[$i]["Nome"];
		$file=estraiImmagine("../img/".$folder, $nome);
		if(is_numeric($file)){
			//qualcosa
			++$ciclo;
		}
		else{
			$indirizzo=$flag.'?'.$suff1.$nome.$suff2;
			$nome=str_replace("0", " ", $nome);
			$sezione.='<div class="H">
				<a href="'.$indirizzo.'">
			    	<div class="Prduct">
			      		<img src="../img/'.$folder.'/'.$file.'" alt="'.$nome.'"/>
			      		<p class="Sdp">Scopri di pi&#249;</p>
			    	</div>
			  	</a>
			  	<a href="'.$indirizzo.'">
			   		<h2 class="Tit">'.$nome.'</h2>
			  	</a>
			</div>
		';
		}
	}
	return $rimasti.$sezione;
}
/*----------------------------------------FINE FUNZIONI-------------------------------*/
$keyword='';
$descrizione='Pagina Generale di ricerca';
include '1header.php';
include 'ricerca.html';
include '3footer.html';
?>
