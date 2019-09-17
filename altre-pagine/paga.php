<?php
session_start();

foreach ($_SESSION['pagaBool'] as $key => $value) {
	if($_SESSION['pagaBool'][$key]=='2'){
		$_SESSION["proErr"]='Errore Campo';
		if($key=='tel'){
			$_SESSION["proMes"]='Campo Telefono vuoto!';
		}
		else if($key=='prov'){
			$_SESSION["proMes"]='Campo Provincia vuoto!';
		}
		else {
			$_SESSION["proMes"]='Campo '.ucfirst($key).' vuoto!';
		}
		$_SESSION['proPost']=$_SESSION['pagaPost'];
		unset($_SESSION['pagaPost']);
		header('Location: profilo.php');
		die();
	}
}

if(!in_array($_SESSION['pagaPost']['prov'], $_SESSION['provincecoerenti'])){
	$_SESSION["proErr"]="Errore logistico";
	$_SESSION["proMes"]="Almeno un prodotto non è venduto nella Provincia di spedizione!";
	header('Location: profilo.php');
	die();
}

//pagamento
if($_SESSION['pagaPost']['pagamento']=='paypal'){
	$_SESSION["proErr"]="Successo";
	$_SESSION["proMes"]="Transazione tramite paypal avvenuta con successo!";
}
else {
	$_SESSION["proErr"]="Successo";
	$_SESSION["proMes"]="Transazione tramite carta di credito avvenuta con successo!";
}
unset($_SESSION['cart']);
unset($_SESSION['provincecoerenti']);
unset($_SESSION['paga']);
unset($_SESSION['pagaPost']);
header('Location: profilo.php');
die();

?>
