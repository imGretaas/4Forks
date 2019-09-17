/*OnBlur check di campi form*/
var aiuti = ["Il nome deve contenere almeno 3 lettere e non caratteri speciali", "Il cognome deve avere almeno 2 lettere e non caratteri speciali",
			"L'email deve essere di questa forma: esempio@dominio.com",
			"Giorno non esistente", "Mese non esistente", "Età non valida",
			"Inserire minimo 1 e massimo 12 caratteri", 
			"La password deve corrispondere a quella inserita in precedenza",
			"La sigla della provincia deve avere solo due caratteri", "Inserire un paese esistente",
			"Inserire una via e un numero civico validi", "Inserire un cap esistente",
			"Numero di telefono non valido","Accettare i termini e le condizioni","Form non compilato correttamente","Inserire regione","Inserire provincia",
			"La descrizione deve contenere tra i 10 e i 300 caratteri","Città non esistente","Estensione file non valida","Nome prodotto non valido",
			"Prezzo non valido","Province non esistenti, ricordarsi di separare le province con una virgola"]

function checkName(){
	var input=document.getElementById("name"); 
	var pattern=new RegExp('^[a-zA-Z]{3,25}$');
	if(pattern.test(input.value)){ //Input e' l'oggetto attributo value che abbiamo nell'input del codice html
		togliErrore(input);
		return true;
	}
	else{
		//mostrare messaggio errore
		mostraErrore(input, aiuti[0]);
		return false;
	}
}

function checkSurname(){
	var input=document.getElementById("surname"); 
	var pattern=new RegExp('^[a-zA-Z]{2,25}$');
	if(pattern.test(input.value)){ //Input e' l'oggetto attributo value che abbiamo nell'input del codice html
		togliErrore(input);
		return true;
	}
	else{
		//mostrare messaggio errore
		mostraErrore(input, aiuti[1]);
		return false;
	}
}

function checkEmail(){
	var input=document.getElementById("email"); 
	var pattern = new RegExp('^(.{2,32}\@)[a-zA-Z]{1,10}\.[a-zA-Z]{2,7}$'); 
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[2]);
		return false;
	}
}

var maxM=29;
var max=31;

function checkDay(){
	var input=document.getElementById("day");
	if(input.value <= max){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[3]);
		return false;
	}
}

function checkMonth(){
	var input=document.getElementById("month");
	if(input.value=="-"){
		mostraErrore(input, aiuti[4]);
		return false;
	}
	else{
		togliErrore(input);
		if(input.value=="4" || input.value=="6" || input.value=="9" || input.value=="11"){
			document.getElementById("t1").className="LongDateNot";
			document.getElementById("t0").className="LongDate";
			document.getElementById("v9").className="LongDate";
			max=30;
		}
		else if(input.value=="2"){
			document.getElementById("t1").className="LongDateNot";
			document.getElementById("t0").className="LongDateNot";
			if(maxM == 28){
				document.getElementById("v9").className="LongDateNot";
			}
			max=maxM;
		}
		else{
			document.getElementById("t1").className="LongDate";
			document.getElementById("t0").className="LongDate";
			document.getElementById("v9").className="LongDate";
			max=31;
		}
		checkDay();
		return true;
	}
}

function checkYear(){
	var input=document.getElementById("year");
	if(input.value=="-"){
		mostraErrore(input, aiuti[5]);
		return false;
	}
	else{
		togliErrore(input);
		if(input.value%4 != 0){
			maxM=28;
		}
		else{
			maxM=29;
		}
		checkMonth();
		return true;
	}
}

function mostraErrore1(input, testo){
	togliErrore1(input);
	var div = input.parentNode; //restituisce il padre di quell'elemento
	var p = document.createElement("p");
	p.className="Errors";
	p.appendChild(document.createTextNode(testo));
	div.appendChild(p);
}

function togliErrore1(input){
	var div = input.parentNode;
	if(div.children.length > 3){ //children e' un array e se contiene 7 figli (label input e p)
		div.removeChild(div.children[3]); //rimuovo il terzo figlio (p)
	}
}

//imporre password conteneti almeno un carattere speciale, lettera minuscola e maiuscola
function checkPw(){
	var input=document.getElementById("password"); 
	var pattern = new RegExp('^[.?^!,;*/+-€_$?%:=àèéùòì0-9A-Za-z]{1,12}$');
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[6]);
		return false;
	}
}

function checkCPw(){
	var input=document.getElementById("confirm-password"); 
	var pass = document.getElementById("password");
	var pattern = new RegExp('^[.?^!,;*/+-€_$?@à#%:=àèéùòì0-9A-Za-z]{1,12}$');
	if(input.value == pass.value && pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[7]);
		return false;
	}
}

function toUpper(){
	var input=document.getElementById("province"); 
	input.value=input.value.toUpperCase();
}

function checkProvince(){
	var input=document.getElementById("province");
	var pattern=new RegExp('^[A-Z]{2}$');
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[8]);
		return false;
	}
}

function firsToUpper(field){
	var input;
	switch(field){
		case "name": var input=document.getElementById("name");
		break;
		case "surname": var input=document.getElementById("surname");
		break;
		case "country": var input=document.getElementById("country");
		break;
		default:
		break;
	}
	input.value = input.value.charAt(0).toUpperCase() + input.value.substr(1);
}

function checkCountry(){
	var input=document.getElementById("country");
	var pattern=new RegExp('^[a-zA-Z ]{2,30}$');
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[9]);
		return false;
	}
}

function checkAddress(){
	var input=document.getElementById("address");
	var pattern=new RegExp('^[a-zA-Z, ]{3,30}[0-9]{1,4}$');
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[10]);
		return false;
	}
}

function checkAddress1(){
	var input=document.getElementById("address");
	var pattern=new RegExp('^[a-zA-Z, ]{3,30}[0-9]{1,4}$');
	if(pattern.test(input.value) || input.value==""){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[10]);
		return false;
	}
}

function checkCAP(){
	var input=document.getElementById("cap");
	var pattern=new RegExp('^[0-9]{3,10}$');
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[11]);
		return false;
	}
}

function checkCAP1(){
	var input=document.getElementById("cap");
	var pattern=new RegExp('^[0-9a-zA-Z]{3,10}$');
	if(pattern.test(input.value) || input.value==""){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[11]);
		return false;
	}
}

function checkTel(){
	/*var input=document.getElementById("telephone");
	var pattern1=new RegExp('^[0][0-9]{8}$');
	var pattern2=new RegExp('^[3][0-9]{9}$');
	var pattern3=new RegExp('^[+][3][9][0-9]{10}$');
	var pattern4=new RegExp('^[+][3][9][ ][0-9]{10}$');
	if(pattern1.test(input.value) || pattern2.test(input.value) || pattern3.test(input.value) || pattern4.test(input.value) || input.value==""){*/
	var input=document.getElementById("telephone");
	var pattern=new RegExp('^[0-9+-.]{8,20}$');
	if(pattern.test(input.value) || input.value==""){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[12]);
		return false;
	}
}

function checkTerms(){
	var checkBox = document.getElementById("terms");
	if(checkBox.checked == true){
		togliErrore(checkBox);
		return true;
	}
	else{
		mostraErrore(checkBox, aiuti[13]);
		return false;
	}
}

function checkCity(){
	var input=document.getElementById("citta");
	var pattern=new RegExp('^[a-zA-Z ]{2,30}$');
	if(pattern.test(input.value) || input.value==""){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[18]);
		return false;
	}
}

function checkDescription(){
	var input=document.getElementById("descrizione");
	if(input.value.length <= 300 && input.value.length >=10){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[17]);
		return false;
	}
}

function checkDescription1(){
	var input=document.getElementById("descrizioneprodotto");
	if(input.value=="" || (input.value.length <= 300 && input.value.length >=10)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[17]);
		return false;
	}
}

function checkFile() {
	var file=document.getElementById("foto");
	if(file.value!=""){
		var extension = file.value.split(".")[1];
		if(extension=="jpeg" || extension=="jpg" || extension=="png" || extension=="bmp" || extension=="BMP" || extension=="PNG" || extension=="JPG" ||
		extension=="JPEG") {
			togliErrore(file);
			return true;
		}
		else{
			mostraErrore(file, aiuti[19]);
			return false;
		}
	}
	else{
		togliErrore(file);
		return true;
	}
}

function checkProductName(){
	var input=document.getElementById("prodotto");
	var pattern=new RegExp('^[a-zA-Z0-9x/+*,;.:-_#=éèàòùì€£&" ]{2,30}$');
	if(pattern.test(input.value) || input.value==""){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[20]);
		return false;
	}
}

function checkPrice(){
	var input=document.getElementById("prezzo");
	var pattern=new RegExp('^[0-9]{1,3}$');
	if(pattern.test(input.value) && input.value>0 && input.value<301){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[21]);
		return false;
	}
}

function checkProvinces(){
	var input=document.getElementById("province");
	if(input.value!=""){
		var str=input.value.replace(/ /g,"");
		str=str.split(",");
		var pattern=new RegExp('^[A-Z]{2}$');
		var i=0;
		while(i<str.length && pattern.test(str[i])){
			i=i+1;
		}
		if(pattern.test(str[i-1])){
			togliErrore(input);
			return true;
		}
		else{
			mostraErrore(input, aiuti[22]);
			return false;
		}
	}
	else{
		togliErrore(input);
		return true;
	}
}

function printVal(){
	var input=document.getElementById("jsalert");
	alert(input.value);
}

function checkForm1(){
	var input=document.getElementById("send");
	togliErrore(input);
	input.type="submit";
}

function checkForm2(){
	var input=document.getElementById("send");
	if(checkName() && checkSurname() && checkEmail() && checkDay() && checkMonth() && checkYear() && checkPw() && checkCPw() && checkProvince() && checkCountry()
		&& checkAddress() && checkCAP() && checkTel() && checkTerms()){
		togliErrore(input);
		input.type="submit";
	}
	else{	
		if(!checkName()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkSurname()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkEmail()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkDay()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkMonth()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkYear()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkPw()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkCPw()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkProvince()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkCountry()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkAddress()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkCAP()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkTel()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkTerms()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
	}
}

function checkForm3(){
	var buy=document.getElementById("buy");
	buy.type="submit";
}

function checkForm4(){
	var region=document.getElementById("region");
	var province=document.getElementById("province");
	var buy=document.getElementById("buy");
	if(region.value!="-" && province.value!="-" && changePrice()==true){
		buy.type="submit";
	}
	else{
		if(region.value == "-"){
			mostraErrore(region, aiuti[15]);
		}
		else{
			togliErrore(region);
		}
		if(province.value == "-"){
			mostraErrore(province, aiuti[16]);
		}
		else{
			togliErrore(province);
		}
		buy.type="button";
	}
}

function checkForm5(){
	var input=document.getElementById("send");
	if(checkEmail() && checkPw() && checkCPw() && checkDescription() && checkCity1() && checkCAP1() && checkAddress1() && checkTel() && checkFile()){
		togliErrore(input);
		input.type="submit";
	}
	else{
		if(!checkEmail()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkPw()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkCPw()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkDescription()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkCity1()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkCAP1()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkAddress1()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkTel()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkFile()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
	}
}

function checkForm6(){
	var input=document.getElementById("send");
	if(checkProductName() && checkPrice() && checkProvinces() && checkDescription1() && checkFile()){
		togliErrore(input);
		input.type="submit";
	}
	else{
		if(!checkProductName()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkPrice()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkProvinces()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkDescription1()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
		if(!checkFile()){
			mostraErrore(input,aiuti[14]);
			input.type="button";
		}
	}
}

function mostraErrore(input, testo){
	togliErrore(input);
	var p = input.parentNode; //restituisce il padre di quell'elemento
	var span = document.createElement("span");
	span.className="Errors";
	span.appendChild(document.createTextNode(testo));
	p.appendChild(span);
}

function togliErrore(input){
	var p = input.parentNode;
	if(p.children.length > 3){ //children e' un array e se contiene 3 figli (label input e span)
		p.removeChild(p.children[3]); //rimuovo il terzo figlio (lo span)
	}
}

/*Pagina prodotto: select cambia prezzo in base la quantità restituita*/

function changePrice(){
	var input=document.getElementById("quantity");
	var p=document.getElementById("cPrice");
	if(input.value > 20 || input.value < 1){
		p.innerHTML="Non disponibile";
		p.style.color="red";
		return false;
	}
	else{
		p.style.color="rgb(90,19,35)";
		p.innerHTML="€"+(input.value*10);
		return true;
	}
}

/*Pagina prodotto: select regione => provincia di quella regione*/


function prova() {
    var prova=document.getElementById("region").value;
    var ciao=prova.substr(0,1).toUpperCase()+prova.substr(1,prova.length).toLowerCase();
    var prova2=document.getElementsByClassName(ciao);
    for (var i = 0; i<prova2.length; i++) {
        prova2[i].toggleClass("NotDisplay");
    }
}

function prova2() {
    var prova=document.getElementById("region").value;
    var ciao=prova.substr(0,1).toUpperCase()+prova.substr(1,prova.length).toLowerCase();
    var prova2=document.getElementsByClassName(ciao);
    for (var i = 0; i<prova2.length; i++) {
		prova2[i].style.display="none";
    }
	document.getElementById("province").value="-";
}

/*aggiunge un nuovo stile all'inizio del tag head
function addNewStyle(newStyle, region){
	var styleElement = document.getElementById('styles_js');
	if (!styleElement) {
		styleElement = document.createElement('style');
		styleElement.type = 'text/css';
		styleElement.id = 'styles_js';
		document.getElementsByTagName('head')[0].appendChild(styleElement);
	}
	else{
		styleElement.parentNode.removeChild(styleElement);
		styleElement = document.createElement('style');
		styleElement.type = 'text/css';
		styleElement.id = 'styles_js';
		document.getElementsByTagName('head')[0].appendChild(styleElement);
	}
	styleElement.appendChild(document.createTextNode(newStyle));
}

function displayProvince(){
	var region = document.getElementById('region');
	switch(region.value){
		case "abruzzo":addNewStyle('select[id=province] .Abruzzo{display:inline !important;}');
		break;
		case "basilicata":addNewStyle('select[id=province] .Basilicata{display:inline !important;}');
		break;
		case "calabria":addNewStyle('select[id=province] .Calabria{display:inline !important;}');
		break;
		case "campania":addNewStyle('select[id=province] .Campania{display:inline !important;}');
		break;
		case "emilia-romagna":addNewStyle('select[id=province] .Emilia{display:inline !important;}');
		break;
		case "friuli":addNewStyle('select[id=province] .Friuli{display:inline !important;}');
		break;
		case "lazio":addNewStyle('select[id=province] .Lazio{display:inline !important;}');
		break;
		case "liguria":addNewStyle('select[id=province] .Liguria{display:inline !important;}');
		break;
		case "lombardia":addNewStyle('select[id=province] .Lombardia{display:inline !important;}');
		break;
		case "marche":addNewStyle('select[id=province] .Marche{display:inline !important;}');
		break;
		case "molise":addNewStyle('select[id=province] .Molise{display:inline !important;}');
		break;
		case "piemonte":addNewStyle('select[id=province] .Piemonte{display:inline !important;}');
		break;
		case "puglia":addNewStyle('select[id=province] .Puglia{display:inline !important;}');
		break;
		case "sardegna":addNewStyle('select[id=province] .Sardegna{display:inline !important;}');
		break;
		case "sicilia":addNewStyle('select[id=province] .Sicilia{display:inline !important;}');
		break;
		case "toscana":addNewStyle('select[id=province] .Toscana{display:inline !important;}');
		break;
		case "trentino":addNewStyle('select[id=province] .Trentino{display:inline !important;}');
		break;
		case "umbria":addNewStyle('select[id=province] .Umbria{display:inline !important;}');
		break;
		case "valle":addNewStyle('select[id=province] .Valle{display:inline !important;}');
		break;
		case "veneto":addNewStyle('select[id=province] .Veneto{display:inline !important;}');
		break;
		default:
		break;
	}
	var province = document.getElementById('province');
	province.value="-";
}*/

/*Slider basso di pagina prodotto*/

function jssor_1_slider_init(){
			var w=document.documentElement.clientWidth || document.body.clientWidth;
			if (w<700) {
				document.getElementById("jssor_1").classList.toggle("Smartphone");
				document.getElementById("altezza").classList.toggle("Smartphone");
			}
            var jssor_1_options = {
              $AutoPlay: 0,
              $AutoPlaySteps: 5,
              $SlideDuration: 160,
              $SlideEasing: $Jease$.$Linear,
              $Loop: 2,
              $SlideWidth: 249,
              $SlideSpacing: 10,
              $Align: 0,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $Steps: 2
              }
            };
			
			var w = document.documentElement.clientWidth || document.body.clientWidth;
            if(w<700){
                jssor_1_options.$SlideWidth= 505;
            }

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*#region responsive code begin*/

            var MAX_WIDTH = 1400; //1023

            function ScaleSlider() {
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {

                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                    jssor_1_slider.$ScaleWidth(expectedWidth);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*#endregion responsive code end*/
        };
	
//pagina Profilo 	
function dropCredito() {
  document.getElementById("formCredito").classList.toggle('Mostra');
}

function funPwd() {
  var x = document.getElementById("password");
  if (x.type === "password") {
  x.type = "text";
  } else {
  x.type = "password";
  }
}

function resetta() {
  x=document.getElementsByTagName("form");
  var i;
  for(i=1; i<x.length; i++) {
    x[i].reset();
  }
}