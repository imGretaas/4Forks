<?php
session_start();
$titolo='Registrazione';
$temp='<script src="../js/jquery-3.4.1.min.js" defer="defer" ></script>
	<script src="../js/jquery.steps1.js" defer="defer"></script>
	<script src="../js/jquery.cookie-1.3.1.js" defer="defer"></script>
	<script src="../js/forms-checks-and-slider.js" defer="defer"></script>
	<script src="../js/start_wizard1.js" defer="defer"></script>
	<link rel="stylesheet" href="../css/jquery.steps1.css" media="handled, screen"/>
	<link rel="stylesheet" href="../css/registrazione-smartphone.css" media="handheld, screen and (max-width:700px)"/>
	<link rel="stylesheet" href="../css/registrazione-desktop.css" media="screen and (min-width:700px)"/>
	<link rel="stylesheet" href="../css/registrazione(print).css" media="print"/>';
$noscript='<link rel="stylesheet" href="../css/registrazione(noscript).css" media="handheld, screen"/>';

$message = "";
$dati = array();
if (empty($_SESSION['Ritornero'])) {
	$dati['giorno'] = -1;
	$dati['mese'] = -1;
	$dati['anno'] = -1;
} else {
	$dati = $_SESSION['Ritornero'];
	if (!empty($_SESSION['Specerror']) && is_array($dati)) {
		foreach ($_SESSION['Specerror'] as $key => $value) {
			if (array_key_exists($key, $_SESSION['Ritornero']) && $_SESSION['Specerror'][$key] == 0)
				unset($dati[$key]);
		}
	}
	if (!empty($_SESSION['Numerror'])) {
		switch ($_SESSION['Numerror']) {
			case 0:
				$message = "Email gia registrata";
				break;

			case -1:
				$message = "Email o Password non corrette";
				break;

			case -2:
				$message = "Fallito inserimento cliente";
				break;

			case -3:
				$message = "Fallito inserimento in Recapito";
				break;
		}
	} else if(!empty($_SESSION['Specerror'])) {
		$message = "Inserimento fallito: Errore nei campi: ";
		foreach ($_SESSION['Specerror'] as $key => $value) {
			if ($value == 0) {
				$ins = $key;
				if ($key == "pass") {
					$ins = "password";
				} else if ($key == "tel") {
					$ins = "numero di telefono";
				}
				$message.="$ins, ";
			}
		}
		if (strpos($message, ",")) {
			$message = substr($message, 0, (strlen($message)-2) );
		}
	}
}

if ($message != "") {
	$message = '<p class="Err">'.$message.'</p>';
}
$keyword='form, registrazione, clienti';
$descrizione='Form di Registrazione per Clienti';

include '1header.php';

$option = "";
for($i=1; $i<29; $i++) {
	$j = $i;
	if ($j<10) {
		$j = "0$j";
	}
	$option.= '
	<option value="'.$j.'" '.selected($j, $dati['giorno']).'>'.$j.'</option>';
}

$meseoption = "";
for($i=1; $i<29; $i++) {
	$j = $i;
	if ($j<10) {
		$j = "0$j";
	}
	$meseoption.= '
	<option value="'.$j.'" '.selected($j, $dati['giorno']).'>'.$j.'</option>';
}

include 'registrazione.html';		//sostituire "content" con il nome (estensione compresa, se presente) della vostra pagina
include '3footer.html';
unset($_SESSION['Ritornero']);
unset($_SESSION['Specerror']);
?>
