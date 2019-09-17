<?php
$provend = "";
$cont = 0;
$altercont= "";
$debugstring = "";
if (empty($actualid)) {
	$actualid = 'nessuno';
}
if (!isset($id)) {
	$id = "";
}
if ($proarr[0] >= 0) { // nessun errore da elementipg
	if ($proarr[0] > 5) { // con >5 elementi usiamo lo slider
		$provend.= '
		<!-- #region Jssor Slider Begin -->
		<!-- Generator: Jssor Slider Maker -->
		<!-- Source: https://www.jssor.com -->
		<div id="jssor_1" class="Prova1 Prova1-5">
			<!-- Loading Screen -->
			<div data-u="loading" class="jssorl-009-spin Prova2 Prova2-5">
				<img class="Prova3" src="../img/spin.svg" alt="caricamento"/>
			</div>
			<div id="altezza" data-u="slides" class="Prova4 Prova1-5">
			';
		foreach ($proarr[2] as $key => $value) {
			$provendimg = estraiImmagine("../img/product/", $value['ID']);
			$debugstring.= "Immagine di ".$value['ID']." : ".$provendimg."<br>";
			if (!is_numeric($provendimg) && strpos($provendimg, "DS_Store") === FALSE && $value['ID'] != $actualid && $cont <9) {
				$cont++;
				$provend.='
				<div>
				<a class="ProdSlider" href="prodotto.php?ID='.$value['ID'].'">
				<img data-u="image" src="../img/product/'.$provendimg.'" alt="" />
				<p class="Prezzo">&#8364;'.$value['Prezzo'].'</p>
				<p class="Sottotitolo">'.str_replace("0", " ", $value['Nome']).'</p>
				</a>
				</div>
				';
				if ($cont < 5) { // SERVE se per caso $cont alla fine del ciclo é <5 per via di estraiImmagine()
					$altercont.= '
					<div>
					<a href="prodotto.php?ID='.$value['ID'].'">
					<div>
					<p>&#8364;'.$value['Prezzo'].'</p>
					<img src="../img/product/'.$provendimg.'" alt="" />
					<p>Scopri di pi&#249;</p>
					</div>
					</a>
					<a href="prodotto.php?ID='.$value['ID'].'">
					<h1>'.str_replace("0", " ", $value['Nome']).'</h1>
					</a>
					</div>
					';
				}
			}
		}
		$provend.='
</div>
<!-- Arrow Navigator -->
	<div data-u="arrowleft" class="jssora056 Prova8" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
		<svg viewbox="0 0 16000 16000">
			<polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
		</svg>
	</div>
	<div data-u="arrowright" class="jssora056 Prova9" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
		<svg viewbox="0 0 16000 16000">
			<polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
		</svg>
	</div>
</div>
<!--#endregion Jssor Slider End -->
';
		$altercont = '
<div class="Row">
'.$altercont.'
</div><!--ROW-->';
	}
	if ($cont <=5 && $cont >0) {
			$provend = '
	<div class="Row">
	'.$altercont.'
	</div><!--ROW-->
			';
	} else {
		if ($proarr[0] <= 5) {
			$provend = '<div class="Row">';
			for ($cont = 0; $cont < 4; $cont++) {
				$ciao = &$proarr[2][$cont];
				$provendimg = estraiImmagine("../img/product/", $ciao['ID']);
				if (!is_numeric($provendimg) && strpos($provendimg, "DS_Store") === FALSE) {
					$provend.= '
			<div>
				<a href="prodotto.php?ID='.$ciao['ID'].'">
					<div>
						<p>&#8364;'.$ciao['Prezzo'].'</p>
						<img src="../img/product/'.$provendimg.'" alt="" />
						<p>Scopri di pi&#249;</p>
					</div>
				</a>
				<a href="prodotto.php?ID='.$ciao['ID'].'" >
					<h1>'.str_replace("0"," ", $ciao['Nome']).'</h1>
				</a>
			</div>
					';
			}
			}
			$provend .='</div><!--ROW-->
			';
		} else {
			$temp.='
					<link rel="stylesheet" type="text/css" href="../css/foodSlider.css"/>
					<script src="../js/jssor.slider-27.5.0.min.js"></script>
					<script src="../js/slider.js"></script>
					<script src="../js/sliderstart.js" defer="defer"></script>';
		}
	}
}
if ($cont == 0 ) {
	$provend = "";
	$altercont = "";
}
 ?>
