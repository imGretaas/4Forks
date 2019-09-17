<?php
session_start();

if(empty($_POST) || !empty($_POST['ANNULLA'])){
	header("location: profilo.php");
	die();
}
require_once("../basefunction.php");

$_POST=striparray($_POST);
$temp=array();

foreach ($_POST as $key => $value) {
	if($key=="nome" || $key=="cognome" || $key=="tel"  || $key=="email" || $key=="citta" || $key=="prov" || $key=="cap" || $key=="via") {
		$temp[$key]=$value;
	}
	else if($key=="password" && !empty($_POST[$key])){
		$temp['pass']=$value;
	}
	else if($key=="pagamento"){
		$temp[$key]=$value;
		if($_POST[$key]=='credito'){
			$temp['numCred']=str_replace(' ', '', str_replace('-', '', $_POST['numCred']));
			$temp['cmese']=$_POST['cmese'];
			$temp['canno']=$_POST['canno'];
			$temp['scadenza']=(2000+$temp['canno']).'-'.$temp['cmese'].'-28';
			$temp['cvv']=$_POST['cvv'];
		}/*
		else if($_POST[$key]=='paypal'){
		}*/
	}
}

$_SESSION["proErr"]="";
$_SESSION["proMes"]="";

$maxM="31";
if($_POST["mese"]==2){
	if($_POST["anno"]%4 == 0 && ($_POST["anno"]%100 != 0 || $_POST["anno"]%400 == 0)){
		$maxM="29";
	}
	else {
		$maxM="28";
	}
}
else if ($_POST["mese"]==4 || $_POST["mese"]==6 || $_POST["mese"]==9 ||$_POST["mese"]==11) {
	$maxM="30";
}

if($_POST["giorno"]>$maxM){
	$_SESSION["proErr"]="Data";
	$_SESSION["proMes"]="Data non esistente";
	vaia("profilo.php");
}

$bool=controllarray($temp);
if(empty($temp['tel'])){
	$bool['tel']=2;
}
if(empty($temp['citta'])){
	$bool['citta']=2;
}
if(empty($temp['via'])){
	$bool['via']=2;
}
if(empty($temp['cap'])){
	$bool['cap']=2;
}
if(empty($temp['prov'])){
	$bool['prov']=2;
}


if(tipostringa(str_replace(" ", "", $temp["nome"])) == '100'){
	$bool["nome"]=1;
}
else {
	$bool["nome"]=0;
}

if(tipostringa(str_replace(" ", "", $temp["cognome"])) == '100'){
	$bool["cognome"]=1;
}
else {
	$bool["cognome"]=0;
}

/*
if(!(tipostringa($temp['pass']) == '110' && $bool['pass']=1)) {
	$bool['pass']=0;
}
*/

if(empty(province(TRUE, 'sigla_province='.insertapici($temp['prov'])))){
	$bool['prov']=2;
}

if($temp['pagamento']=='credito'){
	$bool['pagamento']=1;
	$model='^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$^';
	if(boolregexp($model, $temp['numCred'])){
		$bool['numCred']=1;
		if($temp['cmese']=='-' || $temp['canno']=='-'){
			$bool['cmese']=0;
		}
		else{
			if($temp['canno']>date('y')){
				$bool['cmese']=1;
			}
			else if($temp['cmese']>date('m')){
				$bool['cmese']=1;
			}
			else {
				$bool['cmese']=0;
			}
		}
		if(!empty($_POST['cvv'])){
			$model='^[0-9]{3,4}$^';
			if(boolregexp($model, $temp['cvv'])){
				$bool['cvv']=1;
			}
			else {
				$bool['cvv']=0;
			}
		}
		else {
			$bool['cvv']=2;
		}
	}
	else {
		$bool['numCred']=0;
	}
}
else if($temp['pagamento']=='paypal'){
	$bool['pagamento']=1;
}
else {
	$bool['pagamento']=0;
}

/*
campi da dare alla funzione controllarray() (con i nomi della funzione, non di POST):
nome, cognome, telefono, email, password, città, provincia, cap e via.

ritorno è array di booleani su controllo di ogni input
*/


$errTemp=array('Errore nel Nome!',
				'Errore nel Cognome!',
				'Errore nel Numero di Telefono!',
				'Errore nell\'Email!',
				//'Password non abbastanza sicura!',
				'Errore nella Città!',
				'Errore nel CAP!',
				'Errore nella Provincia!',
				'Errore nella Via!',
				'Errore modalità di pagamento!');
$mesTemp=array("Nome non corretto o mancante!",
				"Cognome non corretto o mancante!",
				"Numero non corretto!",
				"Email non corretta o mancante!",
				//"La Password deve essere compresa fra 8 e 12 caratteri e contenere almeno un carattere speciale!",
				"Città non corretta!",
				"CAP non corretto!",
				"Provincia inesistente!",
				"Via non corretta!",
				"Modalità di pagamento non corretta o mancante!");
if($temp['pagamento']=='credito'){
	$errTemp[]='Errore carta di Credito!';
	$errTemp[]='Errore scadenza Carta di Credito!';

	$mesTemp[]='Numero carta non corretto o mancante!';
	$mesTemp[]='Scadenza carta non corretta o mancante!';

	if(!empty($_POST['cvv'])){
		$errTemp[]='Errore CVV Carta di Credito!';
		$mesTemp[]='CVV carta non corretto!';
	}
}


$cont=0;
unset($_SESSION["proErr"]);
unset($_SESSION["proMes"]);
unset($_SESSION["proPost"]);
unset($_SESSION["proCont"]);
unset($_SESSION["proBool"]);

foreach ($bool as $key => $value) {
 	if($bool[$key]==0){
		$_SESSION["proErr"]=$errTemp[$cont];
		$_SESSION["proMes"]=$mesTemp[$cont];

		$_SESSION["proPost"]=$_POST;
		$_SESSION["proPost"][$key]="";
		$_SESSION["proCont"]=$temp;
		$_SESSION["proBool"]=$bool;
		vaia("profilo.php");
	}
	$cont++;
}

$temp['Datanascita']=$_POST["anno"].'-'.$_POST["mese"].'-'.$_POST["giorno"];
if(!empty($_POST['pagamento']) && $_POST['pagamento']=='credito' && !empty($_POST['numCred'])){
	$temp['numCred']=$_POST['numCred'];
}
if(!empty($_POST['pagamento']) && $_POST['pagamento']=='paypal'){
	$temp['Paypal']=1;
}

/*controlli data di nascita*/


/*controlli coerenza (anche immagine, es: isimage(); fileimage(); estraiImmagine();*/

if($_FILES["foto"]["error"]==0){

	$boolimage=fileimage($_FILES["foto"], "users/", $_POST["email"], "../img/");

	if($boolimage==-1){
		$_SESSION["proErr"]="Estensione";
		$_SESSION["proMes"]="Estensione del file non corretta!";
		vaia("profilo.php");
	}
	else if($boolimage==-2) {
		$_SESSION["proErr"]="File non valido";
		$_SESSION["proMes"]="Estensione del file mancante!";
		vaia("profilo.php");
	}
	else if($boolimage==-3) {
		$_SESSION["proErr"]="File grande";
		$_SESSION["proMes"]="File troppo grande (max 5MB).";
		vaia("profilo.php");
	}
	else if($boolimage==-4) {
		$_SESSION["proErr"]="Destinazione";
		$_SESSION["proMes"]="La destinazione non è una cartella!";
		vaia("profilo.php");
	}
	else if($boolimage==-5) {
		$_SESSION["proErr"]="Destinazione";
		$_SESSION["proMes"]="Destinazione non esistente!";
		vaia("profilo.php");
	}
	else if($boolimage==-6) {
		$_SESSION["proErr"]="Spostamento";
		$_SESSION["proMes"]="Errore nello spostamento del file!";
		vaia("profilo.php");
	}
	else if($boolimage==-7) {
		$_SESSION["proErr"]="Permessi";
		$_SESSION["proMes"]="Permessi insufficienti per completare l'operazione!";
		vaia("profilo.php");
	}
}

$arrayqueryCliente["Nome"]=$_POST["nome"];
$arrayqueryCliente["Cognome"]=$_POST["cognome"];
$arrayqueryCliente["Datanascita"]=$_POST["anno"].'-'.$_POST["mese"].'-'.$_POST["giorno"];

if($_POST["pagamento"]=='credito'){
	$arrayqueryCliente["Paypal"]=0;
	$arrayqueryCliente["NCarta"]=$temp["numCred"];
	$arrayqueryCliente["Scadenza"]=(2000+$temp['canno']).'-'.$temp['cmese'].'-28';
}
else {
	$arrayqueryCliente["Paypal"]=1;
}

if(!empty($_POST['citta'])){
	$arrayqueryRecapito["Citta"]=$_POST["citta"];
}
else {
	$arrayqueryRecapito["Citta"]='';
}
if(!empty($_POST['via'])){
	$arrayqueryRecapito["Via"]=$_POST["via"];
}
else {
	$arrayqueryRecapito["Via"]='';
}
if(!empty($_POST['cap'])){
	$arrayqueryRecapito["CAP"]=$_POST["cap"];
}
else {
	$arrayqueryRecapito["CAP"]='';
}
if(!empty($_POST['prov'])){
	$arrayqueryRecapito["Provincia"]=$_POST["prov"];
}
else {
	$arrayqueryRecapito["Provincia"]='';
}
if(!empty($_POST['tel'])){
	$arrayqueryRecapito["numTel"]=$_POST["tel"];
}
else {
	$arrayqueryRecapito["numTel"]='';
}

unset($_SESSION['pagaPost']);
unset($_SESSION['pagaBool']);
if(!empty($_SESSION['paga']) && $_SESSION['paga']==TRUE && !empty($_POST['paga']) && $_POST['paga']=='PAGA'){
	$_SESSION['pagaPost']=$_POST;
	$_SESSION['pagaBool']=$bool;
	vaia('paga.php');
}

$dentroPass=true;
$updatequeryPass='';
if(!empty($temp['pass'])){
	$queryPass['Credenziali']=hash('sha256', $temp['pass']);
	$updatequeryPass=updatequery($queryPass, "LogghinC", "Nome=".insertapici($_POST["email"]));
	$requestqueryPass=requestquery("*", "LogghinC", "Nome=".insertapici($_POST["email"]));
	$arraypass=dbrequest($GLOBALS["db"], $requestqueryPass);
	$errorepass=updatequery($arraypass[0], "LogghinC", "Nome=".insertapici($_POST["email"]));
	foreach ($arraypass[0] as $key => $value) {
		if(!in_array($arraypass[0][$key], $temp)){
			$dentroPass=false;
		}
	}
}

/*updatequery e poi dbinsert(restituisce bool)*/

$updatequeryCliente=updatequery($arrayqueryCliente, "Cliente", "Email=".insertapici($_POST["email"]));
$requestqueryCliente=requestquery("*", "Cliente", "Email=".insertapici($_POST["email"]));
$arraycliente=dbrequest($GLOBALS["db"], $requestqueryCliente);
if($temp['pagamento']=='paypal'){
	unset($arraycliente[0]['NCarta']);
	unset($arraycliente[0]['Scadenza']);
}
else {
	unset($arraycliente[0]['PayPal']);
}
$errorecliente=updatequery($arraycliente[0], "Cliente", "Email=".insertapici($_POST["email"]));

$updatequeryRecapito=updatequery($arrayqueryRecapito, "Recapito", "Proprietario=".insertapici($_POST["email"]));
$requestqueryRecapito=requestquery("*", "Recapito", "Proprietario=".insertapici($_POST["email"]));
$arrayrecapito=dbrequest($GLOBALS["db"], $requestqueryRecapito);
$errorerecapito=updatequery($arrayrecapito[0], "Recapito", "Proprietario=".insertapici($_POST["email"]));

$dentroCliente=true;
foreach ($arraycliente[0] as $key => $value) {
	if(!in_array($arraycliente[0][$key], $temp)){
		$dentroCliente=false;
	}
}

$dentroRecapito=true;
foreach ($arrayrecapito[0] as $key => $value) {
	if(!in_array($arrayrecapito[0][$key], $temp)){
		$dentroRecapito=false;
	}
}

if($dentroCliente && $dentroRecapito && $dentroPass){
	$_SESSION["proErr"]="Errore";
	$_SESSION["proMes"]="Nessun campo da modificare!";
	$_SESSION["proPost"]=$_POST;
	vaia("profilo.php");
}

$liscio=true;
if(!$dentroCliente){
	if(dbinsert($GLOBALS["db"], $updatequeryCliente)==TRUE ){
		$_SESSION["proPost"]=$_POST;
		$_SESSION["proErr"]="Successo";
		$_SESSION["proMes"]="Profilo aggiornato con successo!";
	}
	else {
		$_SESSION["proErr"]="Errore del server";
		$_SESSION["proMes"]="E' avvenuto un errore del server!";
		$liscio=false;
	}
}
if(!$dentroRecapito){
	if ($liscio && dbinsert($GLOBALS["db"], $updatequeryRecapito)==TRUE){
		$_SESSION["proPost"]=$_POST;
		$_SESSION["proErr"]="Successo";
		$_SESSION["proMes"]="Profilo aggiornato con successo!";
	}
	else {
		$_SESSION["proErr"]="Errore del server";
		$_SESSION["proMes"]="E' avvenuto un errore del server!";
		dbinsert($GLOBALS["db"], $errorecliente[0]);
		$liscio=false;
	}
}
if (!empty($updatequeryPass) && !$dentroPass && $liscio){
	if($liscio && dbinsert($GLOBALS["db"], $updatequeryPass)==TRUE){
		$_SESSION["proPost"]=$_POST;
		$_SESSION["proErr"]="Successo";
		$_SESSION["proMes"]="Profilo aggiornato con successo!";
	}
	else {
		$_SESSION["proErr"]="Errore del server";
		$_SESSION["proMes"]="E' avvenuto un errore del server!";
		dbinsert($GLOBALS["db"], $errorecliente[0]);
		dbinsert($GLOBALS["db"], $errorerecapito[0]);
		$liscio=false;
	}
}

vaia("profilo.php");
?>
