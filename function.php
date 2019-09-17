<?php
require_once('basefunction.php');

function nascita($data) {
	$input=array();
	$input['tutto']=$data;
	$input['giorno']=substr($data, 8, 2);
	$input['mese']=substr($data, 5, 2);
	$input['anno']=substr($data, 0, 4);
	$data=array();
	$data['giorno']='';
	for ($i=1; $i<10; ++$i) {
		$data['giorno'].='<option value="0'.$i.'" '.selected($i, $input['giorno']).'>'.$i.'</option>
		';
	}
	for ($i=10; $i<29; ++$i) {
		$data['giorno'].='<option value="'.$i.'" '.selected($i, $input['giorno']).'>'.$i.'</option>
		';
	}
	$data['giorno'].='<option value="29" id="v9" class="LongDate" '.selected(29, $input['giorno']).'>29</option>
		<option value="30" id="t0" class="LongDate" '.selected(30, $input['giorno']).'>30</option>
		<option value="31" id="t1" class="LongDate" '.selected(31, $input['giorno']).'>31</option>
		';
	$data['mese']='';
	for ($i=1; $i<13; ++$i) {
		$temp='';
		if($i<10) {
			$temp='0';
		}
		$data['mese'].='<option value="'.$temp.$i.'" '.selected($i, $input['mese']).'>'.$i.'</option>
		';
	}
	$data['anno']='';
	$oggi=date('Y')-17;
	for ($i=$oggi; $i>=$oggi-100; --$i) {
		$data['anno'].='<option value="'.$i.'" '.selected($i, $input['anno']).'>'.$i.'</option>
		';
	}
	return $data;
}

function dataCredito($mese = -1, $anno = -1){
	$data['cmese']='';
	for ($i=1; $i<13; ++$i) {
		$temp='';
		if($i<10) {
			$temp='0';
		}
		$data['cmese'].='<option value="'.$temp.$i.'" '.selected($i, $mese).'>'.$temp.$i.'</option>
		';
	}
	$data['canno']='';
	for ($i=0; $i<6; ++$i){
		$bho=substr(date('y')+$i, -2, 2);
		$data['canno'].='<option value="'.$bho.'" '.selected($bho, $anno).'>'.$bho.'</option>
		';
	}
	return $data;
}

function selected($input, $selected) {
	/*
	Ritorna lato client la selezione se l'input è stato selezionato
	*/
	if ($input == $selected) {
		return 'selected="selected"';
	} else {
		return "";
	}
}

function linkCircolare($categoria) {
	$ris=array();
	$proCart=["Profilo"=>'', "Cart"=>''];
	$sottoAzienda=["La0Storia"=>'', "Chi0Siamo"=>'',"Denominazione"=>''];
	$cat=["Piatti0Caldi"=>'', "Bottega"=>'', "Bevande"=>''];
	$sottoCat=["Primi0Piatti"=>'',"Secondi0Piatti"=>'',"Pizze"=>'',"Contorni"=>'',"Dessert"=>'',
				"Latticini"=>'',"Salumeria"=>'',"Fornaio"=>'',"Dispensa"=>'',
				"Alcolici"=>'',"Analcolici"=>''];
	
	foreach ($proCart as $key => $value) {
		if($categoria==$key){
			$ris[$key][0]='<div';
			$ris[$key][1]='</div>
		';
		}
		else{
			$ris[$key][0]='<a href="'.strtolower($key).'.php"';
			$ris[$key][1]='</a>
		';
		}
	}

	if($categoria=="Azienda"){
		$ris["Azienda"][0]='<p';
		$ris["Azienda"][1]='</p>
		';
	}
	else {
		$ris["Azienda"][0]='<a href="azienda.php"';
		$ris["Azienda"][1]='</a>
		';
	}

	foreach ($sottoAzienda as $key => $value) {
		if($categoria==$key){
			$ris[$key][0]='<p';
			$ris[$key][1]='</p>
		';
		}
		else{
			$ris[$key][0]='<a href="'.str_replace("0", "", strtolower($key)).'.php"';
			$ris[$key][1]='</a>
		';
		}
	}

	foreach ($cat as $key => $value) {
		if($categoria==$key){
			$ris[$key][0]='<p';
			$ris[$key][1]='</p>
		';
		}
		else{
			$ris[$key][0]='<a href="categorie.php?cat='.$key.'"';
			$ris[$key][1]='</a>
		';
		}
	}

	foreach ($sottoCat as $key => $value) {
		if($categoria==$key){
			$ris[$key][0]='<p';
			$ris[$key][1]='</p>
		';
		}
		else{
			$ris[$key][0]='<a href="categoria.php?cat='.$key.'&page=1"';
			$ris[$key][1]='</a>
		';
		}
	}

	return $ris;
}

function userIm($email, $quale="Des", $dove="../"){
	/*
		$quale="Des" se immagine desktop, "Sma" se immagine smartphone, "Pro" se immagine profilo
	*/
	$user=$dove."img/users/";

	$user.=estraiImmagine($dove."img/users/", $email);
	
  	if($user==($dove."img/users/-1") || $user==($dove."img/users/0")){
    	if($quale=="Des"){
    		$user=$dove."img/512px/User.png";
    	}
    	else if($quale=="Sma"){
    		$user=$dove."img/512px/UserWhite2.png";
    	}
    	else if($quale=="Pro"){
    		$user=$dove."img/users/default-user.png";
    	}
  	}
  	return $user;
}

function homeError($provenienza, $messaggio, $positivo=FALSE) {
  $temp=array();
  $class='';
  if($positivo==TRUE){
  	$class="Verde";
  }
  else {
  	$class="Rosso";
  }
  $temp[0]=
  '<form id="err1">
	  	<fieldset>
	  		<legend>Chiusura messaggio errore</legend>
		  	<input id="xcheck1" type="checkbox"/>
		  	<label for="xcheck1">X</label>
		  	<div class="'.$class.'">
	  			<h1>Proveniente dalla pagina '.$provenienza.'</h1>
	  			<p>'.$messaggio.'</p>
	  			<button type="submit">Chiudi</button>
	  		</div>
	  	</fieldset>
  	</form>
';
	$temp[1]='<img id="logoError" src="img/logo.png" alt="Logo aziendale"/>
';
	$temp[2]=
  '<form id="err2">
	  	<fieldset>
	  		<legend>Chiusura messaggio errore</legend>
		  	<input id="xcheck2" type="checkbox"/>
		  	<label for="xcheck2">X</label>
		  	<div class="'.$class.'">
	  			<h1>Proveniente dalla pagina '.$provenienza.'</h1>
	  			<p>'.$messaggio.'</p>
	  			<button type="submit">Chiudi</button>
	  		</div>
	  	</fieldset>
  	</form>
';
	$temp[3]=
  '<form id="err3">
	  	<fieldset>
	  		<legend>Chiusura messaggio errore</legend>
		  	<input id="xcheck3" type="checkbox"/>
		  	<label for="xcheck3">X</label>
		  	<div class="'.$class.'">
	  			<h1>'.$provenienza.'</h1>
	  			<p>'.$messaggio.'</p>
	  			<button type="submit">Chiudi</button>
	  		</div>
	  	</fieldset>
  	</form>
';
  return $temp;
};

function settaregione() {
	/*
	Setta nella SESSION la regione scelta dall'utente
	*/
	if(empty($_POST["regione"])) $_POST["regione"]="-";
	if(empty($_POST["provincia"])) $_POST["provincia"]="-";
	if(empty($_SESSION["regione"])) $_SESSION["regione"]="-";
	if(empty($_SESSION["provincia"])) $_SESSION["provincia"]="-"; 

	if($_POST["regione"]!="-" && $_POST["regione"]!=$_SESSION["regione"]){
		$_SESSION["provincia"]="-";
		if(!empty($_POST["provincia"])){
			$_POST["provincia"]="-";
		}
	}

	if($_POST["regione"]!="-"){
		$_SESSION['regione']=$_POST['regione'];
		if($_POST["provincia"]!="-"){
			$_SESSION['provincia']=$_POST['provincia'];
		}
		else {
			$_SESSION['provincia']="-";
		}
	}
}

function stampaProv($regione, $provincia) {
	$a=array();
	$reg = province();
	$regio='<option value="-" '.selected($regione, "-").'>-</option>
	';
	$flag="";
	for ($i=0; $i <count($reg); $i++) {
		$flag=selected($regione, $reg[$i]["regione_province"]);
		$nome=str_replace("0", " ", $reg[$i]["regione_province"]);
		if($i!=count($reg)-2) {
			$regio.= '<option value="'.$reg[$i]["regione_province"].'" '.$flag.'>'.$nome.'</option>
			  ';
		}
		else {
			$regio.= '<option value="'.$reg[$i]["regione_province"].'" '.$flag.'>Valle d&apos;Aosta</option>
			  ';	
		}
	}
	$provy ="";
	$prov=province(TRUE);
	$provy='<option value="-" '.selected($provincia, "-").'>-</option>
	';
	for ($i=0; $i <count($prov) ; $i++) {
		$flag=selected($provincia, $prov[$i]["sigla_province"]);
		$mostra="";
		if($prov[$i]["regione_province"]==$regione) {
			$mostra=" MostraR";
			$nome=str_replace("0", " ", $prov[$i]["nome_province"]);
			if($nome!='L Aquila') {
				$provy.= '<option value="'.$prov[$i]["sigla_province"].'" class="'.$prov[$i]["regione_province"].$mostra.'" '.$flag.'>'.$nome.'</option>
					  ';
			}
			else {
				$provy.= '<option value="'.$prov[$i]["sigla_province"].'" class="'.$prov[$i]["regione_province"].$mostra.'" '.$flag.'>'."L'Aquila".'</option>
					  ';
			}
		}
	}
	$a[0] = $regio;
	$a[1] = $provy;
	return $a;
}

function controllosearch($search) {
	/*
	Ritorna la ricerca minuscola col primo carattere maiuscolo se formata da caratteri o numeri, altrimenti rimanda alla home
	*/
	if(!(tipostringa($search)=="100" || tipostringa($search)=="110") || !(lunghezzacompresa($search, 35))){
		$_SESSION["proErr"]="Errore Ricerca!";
		$_SESSION["proMes"]="Caratteri speciale non ammessi o ricerca troppo lunga!";
		vaia("../index.php");
	}
	return ucfirst(strtolower($search));
}

?>