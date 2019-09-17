/*OnBlur check di campi form*/
var aiuti = ["Il nome deve contenere almeno 3 lettere e non caratteri speciali", 
			"Il cognome deve avere almeno 2 lettere e non caratteri speciali",
			"L'email deve essere di questa forma: esempio@dominio.com",
			"Giorno non esistente", 
			"Mese non esistente", 
			"Età non valida",
			"Inserire minimo 5 e massimo 12 caratteri", 
			"La password deve corrispondere a quella inserita in precedenza",
			"La sigla della provincia deve avere solo due caratteri", 
			"Inserire un paese esistente",
			"Inserire una via e un numero civico validi", 
			"Inserire un cap esistente",
			"Numero di telefono non valido",
			"Accettare i termini e le condizioni",
			"Form non compilato correttamente",
			"Inserire regione",
			"Inserire provincia",
			"La descrizione deve contenere tra i 10 e i 300 caratteri",
			"Città non esistente",
			"Estensione file non valida",
			"Nome prodotto non valido",
			"Prezzo non valido",
			"Province non esistenti, ricordarsi di separare le province con una virgola",
			"Quantità non valida",
			"Numero di carta non valido",
			"Inserire anno",
			"Inserire mese",
			"Inserire CVV corretto",
			"Le note devono avere min 4 caratteri e max 300",
			"Nome di max 20 e min 2 caratteri",
			"Messaggio di max 600 e min 4 caratteri",
			"Inserire una certificazione"]

function checkName(){
	var input=document.getElementById("name"); 
	var pattern=new RegExp('^[a-zA-Zàòèéùì ]{3,25}$');
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
	var pattern=new RegExp('^[a-zA-Zàòèéùì ]{2,25}$');
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

function checkAgency(){
	var input=document.getElementById("azienda"); 
	var pattern=new RegExp('^[a-zA-Zàòèéùì]{2,20}$');
	if(pattern.test(input.value)){ //Input e' l'oggetto attributo value che abbiamo nell'input del codice html
		togliErrore(input);
		return true;
	}
	else{
		//mostrare messaggio errore
		mostraErrore(input, aiuti[29]);
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

function checkEmail1(){
	var input=document.getElementById("email"); 
	var pattern = new RegExp('^(.{2,32}\@)[a-zA-Z]{1,10}\.[a-zA-Z]{2,7}$'); 
	if(pattern.test(input.value) || input.value==""){
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
	if(input.value <= max && input.value!="-"){
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
		if(input.value=="04" || input.value=="06" || input.value=="09" || input.value=="11"){
			document.getElementById("t1").className="LongDateNot";
			document.getElementById("t0").className="LongDate";
			document.getElementById("v9").className="LongDate";
			max=30;
		}
		else if(input.value=="02"){
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
        if(input.value%4 == 0 ){
            maxM=29;
        }
        else {
            maxM=28;
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
	var pattern = new RegExp('^[.?^!,;*/+-€_$?%:=àèéùòì0-9A-Za-z]{4,12}$');
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[6]);
		return false;
	}
}

function checkPw1(){
	var input=document.getElementById("password"); 
	var pattern = new RegExp('^[.?^!,;*/+-€_$?%:=àèéùòì0-9A-Za-z]{4,12}$');
	if(pattern.test(input.value) || input.value==""){
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
	var pattern = new RegExp('^[.?^!,;*/+-€_$?@à#%:=àèéùòì0-9A-Za-z]{5,12}$');
	if(input.value == pass.value && pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[7]);
		return false;
	}
}

function checkCPw1(){
	var input=document.getElementById("confirm-password"); 
	var pass = document.getElementById("password");
	var pattern = new RegExp('^[.?^!,;*/+-€_$?@à#%:=àèéùòì0-9A-Za-z]{0,12}$');
	if(input.value == pass.value && pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[7]);
		return false;
	}
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

function checkCountry(){
	var input=document.getElementById("country");
	var pattern=new RegExp('^[a-zA-Zàòèéùì ]{2,30}$');
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[9]);
		return false;
	}
}

function checkAddress1(){
	var input=document.getElementById("address");
	var pattern=new RegExp('^[a-zA-Zàòèéùì, ]{3,25}[0-9]{1,4}[a-zA-Zàòèéùì, ]{0,25}$');
	if(input.value=="" || pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[10]);
		return false;
	}
}

function checkAddress(){
	var input=document.getElementById("address");
	var pattern=new RegExp('^[a-zA-Zàòèéùì, ]{3,25}[0-9]{1,4}[a-zA-Zàòèéùì, ]{0,25}$');
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[10]);
		return false;
	}
}

function checkCAP1(){
	var input=document.getElementById("cap");
	var pattern=new RegExp('^[0-9]{3,10}$');
	if(input.value=="" || pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[11]);
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
	var pattern=new RegExp('^[a-zA-Zàòèéùì ]{2,30}$');
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[18]);
		return false;
	}
}

function checkCertification(){
	var input=document.getElementById("certificazione");
	if(input.value!="empty"){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[31]);
		return false;
	}
}

function checkDescription1(){
	var input=document.getElementById("descrizioneprodotto");
	if(input.value.length==0 || (input.value.length <= 300 && input.value.length >=10)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[17]);
		return false;
	}
}

function checkDescription(){
	var input=document.getElementById("descrizione");
	if(input.value.length==0 || (input.value.length <= 300 && input.value.length >=10)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[17]);
		return false;
	}
}

function checkNote(){
	var input=document.getElementById("rettNote");
	if(input.value=="" || (input.value.length <= 300 && input.value.length >=4)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[28]);
		return false;
	}
}

function checkMess(){
	var input=document.getElementById("rettNote");
	if(input.value.length <= 600 && input.value.length >=4){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[30]);
		return false;
	}
} 

function checkFile() {
	var file=document.getElementById("foto");
	if(file.value!=""){
		var extension = file.value.split(".")[1];
		//controllare che sia l'ultimo punto della parola
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
		mostraErrore(file, aiuti[19]);
		return false;
	}
}

function checkFile1() {
	var file=document.getElementById("foto");
	if(file.value!=""){
		var extension = file.value.split(".")[1];
		//controllare che sia l'ultimo punto della parola
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
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[20]);
		return false;
	}
}

function checkProvinces(){
	var input=document.getElementById("province");
	if(input.value!=""){
		var str=input.value.split(",");
		//var pattern=new RegExp('^[A-Z]{2}$');
		var i=0;
		var err=false;
		while(i<str.length && err==false){
			str[i]=str[i].trim();
			if(str[i].length!=2){
				err=true;
			}
			i=i+1;
		}
		if(err==false){
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

function checkQuantity(){
	var input=document.getElementById("quantity");
	var pattern=new RegExp('^[0-9]{1,2}$');
	if(input.value>=0 && input.value<=20 && pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[23]);
		return false;
	}
}

function checkRegion(){
	var region=document.getElementById("regione3");
	if(region.value!="-"){
		togliErrore(region);
		return true;
	}
	else{
		mostraErrore(region, aiuti[15]);
		return false;
	}
}

function checkProvince1(){
	var province=document.getElementById("province3");
	if(province.value!="-"){
		togliErrore(province);
		return true;
	}
	else{
		mostraErrore(province, aiuti[16]);
		return false;
	}
}

function checkCardNumber(){
	var input=document.getElementById("numCred");
	var pattern=new RegExp('^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$');
	if(pattern.test(input.value) || input.value==""){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[24]);
		return false;
	}
}

function checkCardNumber1(){
	var input=document.getElementById("numCred");
	var pattern=new RegExp('^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$');
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[24]);
		return false;
	}
}

function checkExpirationYear(){
	var input=document.getElementById("annoScad");
	if(input.value!="-"){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[25]);
		return false;
	}
}

function checkExpirationMonth(){
	var input=document.getElementById("meseScad");
	if(input.value!="-"){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[26]);
		return false;
	}
}

function checkCVV(){
	var input=document.getElementById("cvv");
	var pattern=new RegExp('^[0-9]{3,4}$');
	if(pattern.test(input.value)  || input.value==""){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[27]);
		return false;
	}
}

function checkCVV1(){
	var input=document.getElementById("cvv");
	var pattern=new RegExp('^[0-9]{3,4}$');
	if(pattern.test(input.value)){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[27]);
		return false;
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
		mostraErrore(input,aiuti[14]);
		input.type="button";
	}
}

function checkForm3(){
	var buy=document.getElementById("buy");
	togliErrore(buy);
	buy.type="submit";
}

function checkForm4(){
	var buy=document.getElementById("buy");
	var q=checkQuantity();
	if(q){
		buy.type="submit";
		togliErrore(buy);
	}
	else{
		buy.type="button";
		mostraErrore(buy,aiuti[14]);
	}
}

function checkForm5(){
	var input=document.getElementById("send");
	if(checkEmail1() && checkPw1() && checkCPw1() && checkDescription() && checkCity() && checkCAP() && checkAddress() && checkTel() && checkFile()){
		togliErrore(input);
		input.type="submit";
	}
	else{
		input.type="button";
		mostraErrore(input,aiuti[14]);
	}
}

function checkForm6(){
	var input=document.getElementById("send");
	if(checkProductName() && checkCertification() && checkPrice() && checkProvinces() && checkDescription1() && checkFile()){
		togliErrore(input);
		input.type="submit";
	}
	else{
		mostraErrore(input,aiuti[14]);
		input.type="button";
	}
}

function checkFormProOut(t){
	var input;
	if(t==2){
		input=document.getElementById("salva");
	}
	else{
		input=document.getElementById("paga");
	}
	input.type="submit";
	togliErrore(input);
}

function checkFormProIn(t){
	var input;
	var c1=document.getElementById("numCred");
	var c2=document.getElementById("meseScad");
	var c3=document.getElementById("annoScad");
	var c4=document.getElementById("cvv");
	var res=false;
	if(t==2){
		input=document.getElementById("salva");
		if(checkAddress1()){
			if(c1.value=="" && c2.value=="-" && c3.value=="-" && c4.value==""){
				res=true;
			}
			else if(checkCardNumber() && checkCVV()){
				res=true;
			}
			else{
				res=false;
			}
		}
		else{
			res=false;
		}
	}
	else{
		input=document.getElementById("paga");
		if(checkAddress() && checkCardNumber1() && checkExpirationMonth() && checkExpirationYear() && checkCVV1()){
			res=true;
		}
		else{
			res=false;
		}
	}
	if(checkName() && checkSurname() && checkFile1() && checkEmail() && checkDay() && checkMonth() && checkYear() && checkPw1() && checkProvince() && checkCountry()
		&& checkCAP() && checkTel() && res){
		togliErrore(input);
		input.type="submit";
		togliErrore(c1);
		togliErrore(c2);
		togliErrore(c3);
		togliErrore(c4);
	}
	else{
		mostraErrore(input,aiuti[14]);
		input.type="button";
	}
}

function checkFormCartOut(){
	var input=document.getElementById("pay");
	togliErrore(input);
	input.type="submit";
}

function checkFormCartIn(){
	var input=document.getElementById("pay");
	var s=changeTotPrice();
	if(s > 0.00){
		togliErrore(input);
		input.type="submit";
	}
	else{
		input.type="button";
		mostraErrore(input,aiuti[14]);
	}
}

function checkFormLIn(){
	var input=document.getElementById("registrazione");
	if(checkEmail() && checkPw() && checkAgency()){
		togliErrore(input);
	}
	else{
		mostraErrore(input,aiuti[14]);
	}
}

function checkFormLOut(){
	var input=document.getElementById("registrazione");
	input.type="submit";
	togliErrore(input);
}

function checkFormINLGC(){
	var input=document.getElementById("accedi");
	if(checkEmail() && checkPw()){
		togliErrore(input);
		input.type="submit";
	}
	else{
		mostraErrore(input,aiuti[14]);
		input.type="button";
	}
}

function checkFormOUTLGC(){
	var input=document.getElementById("accedi");
	input.type="submit";
	togliErrore(input);
}

function checkFormINCont(){
	var input=document.getElementById("invio");
	if(checkName() && checkSurname() && checkMess()){
		togliErrore(input);
		input.type="submit";
	}
	else{
		input.type="button";
		mostraErrore(input,aiuti[14]);
	}
}

function checkFormOUTCont(){
	var input=document.getElementById("invio");
	input.type="submit";
	togliErrore(input);
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

function checkPrice(){
	var input=document.getElementById("prezzo");
	var pattern=new RegExp('^[0-9.,]{1,6}$');
	if(pattern.test(input.value) && input.value>0 && input.value<301){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[21]);
		return false;
	}
}

function checkQuantityCart(n){
	var q="quantity"+n;
	var input=document.getElementById(q);
	if(input.value>0 && input.value<=20){
		togliErrore(input);
		return true;
	}
	else{
		mostraErrore(input, aiuti[23]);
		return false;
	}
}

//nella pagina cart modifica sia il prezzo del singolo prodotto, sia il totale
function changePrice(n){
	var pr=document.getElementsByClassName("Change");
	var c=pr[n].innerHTML.split("€");
	c=c[1];
	var q="quantity"+n;
	var input=document.getElementById(q);
	var d="cPrice"+n;
	var p=document.getElementById(d);
	if(input.value > 20 || input.value < 1){
		p.innerHTML="&#8364;"+"0";
		return false;
	}
	else{
		//var m=(input.value*k).toFixed(3);
		p.innerHTML="&#8364;"+(input.value*c).toFixed(2);
		//p.innerHTML="&#8364;"+m;
		return true;
	}
}


function changeTotPrice(){
	var pr=document.getElementsByClassName("Change");
	var span=document.getElementById("tot");
	var somma=0;
	if(pr.length > 0){
		var i=0;
		while((i < pr.length) && (checkQuantityCart(i) == true)){
			var q="quantity"+i;
			var quan=document.getElementById(q);
			var c=pr[i].innerHTML.split("€");
			c=c[1];
			somma=somma+(quan.value*c);
			i=i+1;
		}
		if(i < pr.length)
			somma=0;
	}
	span.innerHTML=somma.toFixed(2);
	return somma.toFixed(2);
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
