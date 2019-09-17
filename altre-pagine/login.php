<?php
session_start();
$titolo='Login';
$keyword='Login clienti';
$descrizione='Pagina di login dei clienti';
$err = FALSE;
$message = "";
$linker = "";
$temp = '<link rel="stylesheet" type="text/css" href="../css/login.css" media="handheld, screen"/>
		<script src="../js/forms-checks-and-slider.js" defer="defer"></script>
		<link rel="stylesheet" type="text/css" href="../css/login(print).css" media="print"/>
		';
require_once '../function.php';

if (isset($_SESSION['Logerr'])) {
  $err = TRUE;
  switch ($_SESSION['Logerr']) {
    case 0:
      $message = "Link non funzionante";
      break;

    case -1:
      $message = "Link non funzionante";
      if (isset($_SESSION['Specerr'])) {
        if ($_SESSION['Specerr']['email'] == 0) $message = 'La <span lang="en">email</span> inserita non &egrave; valida';
        if ($message != "") $message .= "<br/>";
        if ($_SESSION['Specerr']['email'] == 0) $message .= 'La <span lang="en">Password</span> inserita non &egrave; valida: inserire tra 5 e 12 caratteri';
      } else {
        $message = "Errore nei dati inseriti";
      }
      break;

    case -2:
      $message ='La <span lang="en">email</span> e/o <span lang="en">password</span> non corrispondono ad alcuno dei nostri utenti';
      $linker = '<a href="registrazione.php">Non sei registrato? Registrati</a>';
      break;
  }
}

unset($_SESSION['Logerr']);
unset($_SESSION['Specerr']);

require_once '1header.php';

echo '<ul id="content" class="Breadcrumb"> <!---breadcrumb-->
	  <li><a href="../index.php"><span lang="en">Home</span></a></li>
	  <li>Login</li>
	</ul>
<form method="post" id="small" action="auth.php"> <!--auth.php-->
  <fieldset>
    <legend>Login</legend>
    <h1>Login Clienti</h1>';
if($err == TRUE) {
   echo '<p class="err">'.$message.'</p>'.$linker.'
   <div class="Clearer"></div>
   ';
}
echo '<p class="Float">
	    <label for="email">Inserisci la tua <span lang="en">Email</span></label>
	    <input id="email" onblur="checkEmail();" type="email" name="email" placeholder="Email"/>
		<span class="OnlyDistance"></span>
	  </p>
	  <p class="Float">
	    <label for="password">Inserisci la tua <span lang="en">Password</span></label>
	    <input id ="password" onblur="checkPw();" type="password" name="password" placeholder="Password"/>
		<span class="OnlyDistance"></span>
	  </p>
    <div class="Clearer"></div>
    <p>
		<label for="accedi">Accedi</label>
	    <input id="accedi" onmouseover="checkFormINLGC();" onmouseout="checkFormOUTLGC();" onfocusin="checkFormINLGC();" onfocusout="checkFormOUTLGC();" type="submit" name="invio" value="ACCEDI"/>
		<span class="OnlyDistance1"></span>
	  </p>
    </fieldset>
</form>
  <div>
    <a href="registrazione.php">Non sei ancora registrato? Registrati! </a>
  </div>
';

require '3footer.html';
?>
