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