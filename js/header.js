function convertCode(code) {
  var ret = false;
  switch (code) {
    case 9:
      ret = "Tab";
      break;

    case 13:
      ret = "Enter";
      break;

    case 32:
      ret = "Space";
      break;
  }
  return ret;
}

function rechargeClick(form,regione) {
  var primo = "";
  var secondo = "";

  if (regione == true) {
    primo = document.getElementById('regione1').value;
    secondo = document.getElementById('regione2').value;
  } else{
    primo = document.getElementById('province1').value;
    secondo = document.getElementById('province2').value;
  }

  if (primo !== secondo) {
    if (form == 0) {
      document.getElementById("formBarraAlta").submit();
    } else {
      document.getElementById("formSmartphone").submit();
    }
  }
}

function prodottoClick(regione) {
  var primo = "";
  var secondo = "";

  if (regione == true) {
    primo = document.getElementById('regione1').value;
    secondo = document.getElementById('regione3').value;
  } else{
    primo = document.getElementById('province1').value;
    secondo = document.getElementById('province3').value;
  }
  if (primo !== secondo) {
    if (regione) {
      document.getElementById("regione1").value = secondo;
    } else {
      document.getElementById("province1").value = secondo;
    }
    document.getElementById("formBarraAlta").submit();
  }
}

function recharge(event, form, regione) {
  var tasto = event.key;
  var secondo = event.code;
  var terzo = event.which || event.keyCode;
  var script = convertCode(terzo);
  if (tasto != "" && tasto != 0) {
    terzo = tasto;
  } else if(secondo != "" && secondo != 0){
    terzo = secondo;
  } else {
    terzo = script;
  }
  var uno;
  var due;
  if (terzo == "Enter" || terzo == "Tab") {
    if (regione == true) {
        uno = document.getElementById("regione1").value;
        due = document.getElementById("regione2").value;
    } else {
        uno = document.getElementById("province1").value;
        due = document.getElementById("province2").value;
    }
    if (uno != due) {
      if (form == 0) {
        document.getElementById("formBarraAlta").submit();
      } else {
        document.getElementById("formSmartphone").submit();
      }
    }
  }
}

function prodottoRecharge(event, regione) {
  var tasto = event.key;
  var secondo = event.code;
  var terzo = event.which || event.keyCode;
  var script = convertCode(terzo);
  if (tasto != "" && tasto != 0) {
    terzo = tasto;
  } else if(secondo != "" && secondo != 0){
    terzo = secondo;
  } else {
    terzo = script;
  }
  var uno;
  var tre;
  if (regione == true) {
    uno = document.getElementById("regione1").value;
    tre = document.getElementById("regione3").value;
    if (uno != tre) {
      document.getElementById("regione1").value = tre;
      document.getElementById("formBarraAlta").submit();
    }
  } else {
    uno = document.getElementById("province1").value;
    tre = document.getElementById("province3").value;
    if (uno != tre) {
      if (regione == true) {
        document.getElementById("regione1").value = tre;
      } else {
        document.getElementById("province1").value = tre;
      }
      document.getElementById("formBarraAlta").submit();
    }
  }
}
/*When the user clicks on the button,
toggle between hiding and showing the dropdown content*/

  function dropRicerca() {
    document.getElementById("myDropRicerca").classList.toggle('Apri');
  }

  function toggleR(id) {
    var nomeClas=document.getElementById(id).value;
    document.getElementById("regione1").value=nomeClas;
    document.getElementById("regione2").value=nomeClas;
    if(document.getElementById("regione3")!=null) {
      document.getElementById("regione3").value=nomeClas;
    }
    document.getElementById("province1").value="-";
    document.getElementById("province2").value="-";
    if(document.getElementById("province3")!=null) {
      document.getElementById("province3").value="-";
    }
  }

  function setP(id) {
    var nomeProv=document.getElementById(id).value;
    document.getElementById("province1").value=nomeProv;
    document.getElementById("province2").value=nomeProv;
  }

  $(document).ready(function(){
    $(window).scroll(function(){
      if ($(this).scrollTop() > 150) {
        $('#myBtn').fadeIn();
      }
      else {
        $('#myBtn').fadeOut();
      }
    });
    $('#myBtn').click(function(){
      $("html, body").animate({ scrollTop: 0 }, 800);
      return false;
    })
  });
