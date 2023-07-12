<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="bootstrap-5.2.3-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
    <script src="bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>
    <title>Registration</title>
  </head>

  <body>
  <!-- Navigation -->
  <script>
    function getCookie(name) {
      var cookieString = document.cookie;
      var cookies = cookieString.split("; ");
  
      for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].split("=");
        var cookieName = cookie[0];
        var cookieValue = cookie[1];
    
        if (cookieName === name) {
          return cookieValue;
        }
      }
      return null;
    }
    var username = getCookie("admin");
    if(username = null) {
      document.getElementById("navigation").innerHTML = "<script src='JavaScript/HTML_Importe/Navigation.js' type='text/javascript'></script>";
    } else if(username = "admin") {
      document.getElementById("navigation").innerHTML = "<script src='JavaScript/HTML_Importe/NavigationMitAdmin.js' type='text/javascript'></script>";
    } else if((username = "katerer")) {
      document.getElementById("navigation").innerHTML = "<script src='JavaScript/HTML_Importe/NavigationMitCat.js' type='text/javascript'></script>";
    }
  </script>
  <div id="navigation"></div>
  <!-- Navigation End -->
    <!-- Main -->
    <div class="wrapper">
      <div class="text-center mt-4 name">Registration</div>
      <form
        class="p-3 mt-3"
        method="post"
        action="PHP/RegistrationInDatenbank.php"
      >
      <div class="form-floating mb-3 mt-3">
          <input
            type="text"
            class="form-control"
            id="vorname"
            placeholder="Enter name"
            name="vorname"
          />
          <label for="vorname">Vorname</label>
        </div>
        <div class="form-floating mb-3 mt-3">
          <input
            type="text"
            class="form-control"
            id="nachname"
            placeholder="Enter surname"
            name="nachname"
          />
          <label for="nachname">Nachname</label>
        </div>
        <div class="form-floating mb-3 mt-3">
          <input
            type="text"
            class="form-control"
            id="email"
            placeholder="Enter email"
            name="email"
          />
          <label for="email">E-Mail</label>
        </div>
        <div class="form-floating mt-3 mb-3">
          <input
            type="text"
            class="form-control"
            id="pwd"
            placeholder="Enter password"
            name="pswd"
          />
          <label for="pwd">Passwort</label>
        </div>
        <div class="form-floating mt-3 mb-3">
          <input
            type="text"
            class="form-control"
            id="pwd-repetition"
            placeholder="Enter password"
            name="wdhPswd"
          />
          <label for="pwd">Passwort wiederholen</label>
        </div>
        <!-- Klassen auswählen -->
        <!-- Platzhalter - wär über DB wahrscheinlich besser -->
        <?php
          include "PHP/KlassenDBAuslesen.php";
          KlassenAuslesen();
        ?>
        <button class="btn mt-3" type="submit">Registrieren</button>
      </form>
      <div class="text-center fs-6">
        Bereits ein Konto? <a href="login.html">Login</a>
      </div>
    </div>
    <!-- Main End -->
  </body>
</html>
