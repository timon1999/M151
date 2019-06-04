<?php

// TODO: Verbindung zur Datenbank einbinden
include('database.php');
// Initialisierung
$error = $message =  '';
$firstname = $lastname = $email = $password = '';


if ($_SERVER['REQUEST_METHOD'] == "POST") {
  // Ausgabe des gesamten $_POST Arrays
  echo "<pre>";
  echo "</pre>";

  // vorname vorhanden, mindestens 1 Zeichen und maximal 30 Zeichen lang
  if (isset($_POST['firstname']) && !empty(trim($_POST['firstname'])) && strlen(trim($_POST['firstname'])) <= 30) {
    // Spezielle Zeichen Escapen > Script Injection verhindern
    $firstname = htmlspecialchars(trim($_POST['firstname']));
  } else {
    // Ausgabe Fehlermeldung
    $error .= "Geben Sie bitte einen korrekten Vornamen ein.<br />";
  }

  // nachname vorhanden, mindestens 1 Zeichen und maximal 30 zeichen lang
  if (isset($_POST['lastname']) && !empty(trim($_POST['lastname'])) && strlen(trim($_POST['lastname'])) <= 30) {
    // Spezielle Zeichen Escapen > Script Injection verhindern
    $lastname = htmlspecialchars(trim($_POST['lastname']));
  } else {
    // Ausgabe Fehlermeldung
    $error .= "Geben Sie bitte einen korrekten Nachnamen ein.<br />";
  }

  // emailadresse vorhanden, mindestens 1 Zeichen und maximal 100 zeichen lang
  if (isset($_POST['email']) && !empty(trim($_POST['email'])) && strlen(trim($_POST['email'])) <= 100) {
    $email = htmlspecialchars(trim($_POST['email']));
    // korrekte emailadresse?
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      $error .= "Geben Sie bitte eine korrekte Email-Adresse ein<br />";
    }
  } else {
    // Ausgabe Fehlermeldung
    $error .= "Geben Sie bitte eine korrekte Email-Adresse ein.<br />";
  }


  // passwort vorhanden, mindestens 8 Zeichen
  if (isset($_POST['password']) && !empty(trim($_POST['password']))) {
    $password = trim($_POST['password']);
    //entspricht das passwort unseren vorgaben? (minimal 8 Zeichen, Zahlen, Buchstaben, keine Zeilenumbrüche, mindestens ein Gross- und ein Kleinbuchstabe)
    if (!preg_match("/(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
      $error .= "Passwort: Mindestlänge 8, min. 1 Gross- und Kleinbuchstabe, Zahl und ein Zeichen";
    }
  } else {
    // Ausgabe Fehlermeldung
    $error .= "Geben Sie bitte ein korrektes Passwort ein.<br />";
  }

  // wenn kein Fehler vorhanden ist, schreiben der Daten in die Datenbank
  if (empty($error)) {
    // TODO: INPUT Query erstellen, welches firstname, lastname, username, password, email in die Datenbank schreibt
    $query = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
    // TODO: Query vorbereiten mit prepare();
    $stmt = $mysqli->prepare($query);
    // TODO: Parameter an Query binden mit bind_param();
    $stmt->bind_param('ssss', $firstname, $lastname, $email, $password);
    // TODO: Query ausführen mit execute();
    $stmt->execute();
    // TODO: Verbindung schliessen
    $stmt->close();
    // TODO: Weiterleitung auf login.php
    header('location: login.php');
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Registrieren</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="dist/css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="dist/css/style.css" rel="stylesheet">
</head>

<body>
  <main>
    <div class="container">
      <div class="card-body px-lg-5 pt-0 mx-auto mt-5" style="max-width: 650px">
        <!-- Default form register -->
        <form action="register.php" method="post" class="text-center border border-light p-5 mx-auto mt-5" style="max-width: 600px">

          <p class="h4 mb-4">Registrieren</p>

          <div class="form-row mb-4">
            <div class="col">
              <!-- First name -->
              <input type="text" id="firstname" class="form-control" name="firstname" placeholder="Vorname" minlength="1" maxlength="30" required="true">
            </div>
            <div class="col">
              <!-- Last name -->
              <input type="text" id="lastname" class="form-control" name="lastname" placeholder="Nachname" minlength="1" maxlength="30" required="true">
            </div>
          </div>

          <!-- E-mail -->
          <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-Mail" minlength="1" maxlength="100" required="true">

          <!-- Password -->
          <input type="password" id="password" name="password" class="form-control mb-4" placeholder="********" minlength="8" required="true">

          <!-- Sign up button -->
          <button class="btn btn-primary my-4 btn-block" type="submit">Registrieren</button>

          <div class="text-center">
            <p>Bereits ein Konto?
              <a href="login.php">Login</a>
            </p>
          </div>

        </form>
        <!-- Default form register -->

        <?php
        // Ausgabe der Fehlermeldungen
        if (!empty($error)) {
          echo "<br><div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
        } else if (!empty($message)) {
          echo "<br><div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
        }
        ?>
      </div>
    </div>
  </main>

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="dist/js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="dist/js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="dist/js/mdb.min.js"></script>
</body>

</html>