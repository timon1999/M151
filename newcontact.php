<?php
include('database.php');
session_start();
session_regenerate_id(true);

$error = '';
$message = '';

if (isset($_SESSION['user_id'])) {

    if ($_POST) {
        // vorname vorhanden, mindestens 1 Zeichen und maximal 30 Zeichen lang
        if (isset($_POST['confirstname']) && !empty(trim($_POST['confirstname'])) && strlen(trim($_POST['confirstname'])) <= 30) {
            // Spezielle Zeichen Escapen > Script Injection verhindern
            $firstname = htmlspecialchars(trim($_POST['confirstname']));
        } else {
            // Ausgabe Fehlermeldung
            $error .= "Geben Sie bitte einen korrekten Vornamen ein.<br />";
        }

        if (isset($_POST['conlastname']) && !empty(trim($_POST['conlastname'])) && strlen(trim($_POST['conlastname'])) <= 30) {
            // Spezielle Zeichen Escapen > Script Injection verhindern
            $lastname = htmlspecialchars(trim($_POST['conlastname']));
        } else {
            // Ausgabe Fehlermeldung
            $error .= "Geben Sie bitte einen korrekten Nachnamen ein.<br />";
        }

        if (isset($_POST['conemail']) && !empty(trim($_POST['conemail'])) && strlen(trim($_POST['conemail'])) <= 30) {
            // Spezielle Zeichen Escapen > Script Injection verhindern
            $email = htmlspecialchars(trim($_POST['conemail']));
        } else {
            // Ausgabe Fehlermeldung
            $error .= "Geben Sie bitte einen korrekte Mail ein.<br />";
        }

        if (isset($_POST['contel']) && !empty(trim($_POST['contel'])) && strlen(trim($_POST['contel'])) <= 30) {
            // Spezielle Zeichen Escapen > Script Injection verhindern
            $tel = htmlspecialchars(trim($_POST['contel']));
        } else {
            // Ausgabe Fehlermeldung
            $error .= "Geben Sie bitte einen korrekte Telefonnummer ein.<br />";
        }

        if (isset($_POST['contype']) && !empty(trim($_POST['contype'])) && strlen(trim($_POST['contype'])) <= 30) {
            // Spezielle Zeichen Escapen > Script Injection verhindern
            $type = htmlspecialchars(trim($_POST['contype']));
        } else {
            // Ausgabe Fehlermeldung
            $error .= "Geben Sie bitte einen korrekten Typ ein.<br />";
        }

        if (isset($_POST['connote']) && !empty(trim($_POST['connote'])) && strlen(trim($_POST['connote'])) <= 100) {
            // Spezielle Zeichen Escapen > Script Injection verhindern
            $note = htmlspecialchars(trim($_POST['connote']));
        } else {
            // Ausgabe Fehlermeldung
            $error .= "Geben Sie bitte einen Notiz mit max 100 Zeichen ein.<br />";
        }

        $user = $_SESSION['user_id'];

        if (empty($error)) {
            // INPUT Query erstellen, welches firstname, lastname, username, password, email in die Datenbank schreibt
            $query = "INSERT INTO `contacts` (`firstname`, `lastname`, `email`, `tel`, `type`, `note`, `user`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            // Query vorbereiten mit prepare();
            $stmt = $mysqli->prepare($query);
            // Parameter an Query binden mit bind_param();
            $stmt->bind_param('ssssssi', $firstname, $lastname, $email, $tel, $type, $note, $user);
            // Query ausführen mit execute();

            if ($stmt->execute()) {
                // Verbindung schliessen
                $stmt->close();
                $message = 'Kontakt gespeichert!';
            } else {
                $error = "Fehler beim speichern. Bitte erneut versuchen!";
            }
        }
    }
} else {
    header('location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Neuer Kontakt erstellen</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="dist/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="dist/css/style.css" rel="stylesheet">
</head>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark primary-color">
        <a class="navbar-brand" href="index.php"><strong>Kontaktbuch</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Kontakte</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="newcontact.php">Neuer Kontakt</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto nav-flex-icons">
                <li class="nav-item">
                    <a class="nav-link" href="changepwd.php"><i class="fas fa-cog"> <small><?php echo $_SESSION['email']; ?></small></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Abmelden</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<body>
    <main>
        <div class="container" style="height:1500px;">
            <div class="row mt-3">
                <div class="col">
                    <form class="border border-light p-5" action="newcontact.php" method="post">

                        <p class="h4 mb-4 text-center">Kontakt erstellen</p>

                        <?php
                        if (!empty($message)) {
                            echo "<br><div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
                        } else if (!empty($error)) {
                            echo "<br><div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
                        }
                        ?>

                        <input type="text" id="textInput" class="form-control mb-4" placeholder="Vorname" name="confirstname" minlength="1" maxlength="30" <?php if (isset($_POST['confirstname'])) {echo 'value="' . $_POST['confirstname'] . '"';} ?>>

                        <input type="text" id="defaultContactFormName" class="form-control mb-4" placeholder="Nachname" name="conlastname" minlength="1" maxlength="30" <?php if (isset($_POST['conlastname'])) {echo 'value="' . $_POST['conlastname'] . '"';} ?>>

                        <input type="email" id="defaultContactFormEmail" class="form-control mb-4" placeholder="E-Mail" name="conemail" minlength="1" maxlength="100" <?php if (isset($_POST['conemail'])) {echo 'value="' . $_POST['conemail'] . '"';} ?>>

                        <input type="text" id="textInput" class="form-control mb-4" placeholder="Telefon" name="contel" minlength="1" maxlength="30" <?php if (isset($_POST['contel'])) {echo 'value="' . $_POST['contel'] . '"';} ?>>

                        <label for="defaultSelect">Typ</label>
                        <input type="text" id="textInput" class="form-control mb-4" placeholder="z.B Familie, Firma" name="contype" minlength="1" maxlength="30" <?php if (isset($_POST['contype'])) {echo 'value="' . $_POST['contype'] . '"';} ?>>


                        <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" rows="3" placeholder="Notiz" name="connote" minlength="1" maxlength="100" <?php if (isset($_POST['connote'])) {echo 'value="' . $_POST['connote'] . '"';} ?>></textarea>

                        <button class="btn btn-info btn-block mt-4" type="submit">Speichern</button>
                        <button class="btn btn-danger btn-block mt-4" type="reset">Abbrechen</button>
                    </form>
                </div>
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