$(function () {
    $("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft"
    });
});

function MiaFunzione () {
  if (document.getElementById('prodotto') != null && document.getElementById('prezzo') != null) {
    var nome = document.getElementById('prodotto').value;
    var prezzo = document.getElementById('prezzo').value;
    if ((prezzo == "") || (prezzo == undefined) || (nome == "") || (nome = undefined)) {
      alert("Nome, prezzo o categoria non inseriti");
    }
  }
}

function ControlloModPro () {
  if (document.getElementById('nomenegozio') != null && document.getElementById('citta') != null && document.getElementById('cap') != null && document.getElementById('via') != null) {
    var nome = document.getElementById('nomenegozio').value;
    var citta = document.getElementById('citta').value;
    var cap = document.getElementById('cap').value;
    var via = document.getElementById('via').value;
    var desc = document.getElementById('descrizioneazienda').value;
    if ((citta == "") || (citta == undefined) || (nome == "") || (nome = undefined) || (cap == "") || (cap = undefined) || (via == "") || (via = undefined) || (desc == "") || (desc = undefined)) {
      alert("Nome, citta, descrizione o sede non inseriti");
    }
  }
}
