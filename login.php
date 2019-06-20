<?php

session_start();

if (!isset($_SESSION['user_id'])){
    $error = "Sie sind noch nicht angemeldet. Bitte melden Sie sich an.";
}
// Verbindung zur Datenbank einbinden
include('database.php');

$error = '';
$message = '';
$login = '';


// Formular wurde gesendet und Besucher ist noch nicht angemeldet.
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error)) {
    // email
    if (!empty(trim($_POST['email']))) {

        $email = trim($_POST['email']);

        // prüfung email
        if (strlen($email) > 100) {
            $error .= "E-Mail falsch.<br />";
        }
    } else {
        $error .= "Geben Sie bitte die E-Mail an.<br />";
    }
    // password
    if (!empty(trim($_POST['password']))) {
        $password = trim($_POST['password']);

    } else {
        $error .= "Geben Sie bitte das Passwort an.<br />";
    }

    

    // kein fehler
    if (empty($error)) {
        // SELECT Query erstellen, email und passwort mit Datenbank vergleichen
        $query = 'SELECT * FROM users WHERE email=?';
        // prepare()
        $stmt = $mysqli->prepare($query);
        // bind_param()
        $stmt->bind_param('s', $email);
        // execute()
        $stmt->execute();
        // Passwort auslesen und mit dem eingegeben Passwort vergleichen
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id']=$row['id'];
            $_SESSION['email']=$row['email'];
            header('location: index.php');
        } else {
            $error = "E-Mail oder Kennwort falsch";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login</title>

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
    <div class="container">

        <?php if (isset($_GET['error'])) {
            $error = $_GET['error'];
        }?>

        <div class="card-body px-lg-5 pt-0 mx-auto mt-5" style="max-width: 500px">
            <!-- Default form login -->
            <form class="text-center border border-light p-5" method="POST" action="login.php">

                <p class="h4 mb-4">Login</p>

                <!-- Email -->
                <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail" <?php if (isset($_POST['email'])) {echo 'value="' . $_POST['email'] . '"';} ?>>

                <!-- Password -->
                <input type="password" id="password" name="password" class="form-control mb-4" placeholder="********">

                <div class="d-flex justify-content-around">
                    <div>
                        <!-- Remember me -->
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember">
                            <label class="custom-control-label" for="defaultLoginFormRemember">Daten merken</label>
                        </div>
                    </div>
                    <div>
                        <!-- Forgot password -->
                        <a href="forgot.php">Passwort vergessen?</a>
                    </div>
                </div>

                <!-- Sign in button -->
                <button class="btn btn-primary btn-block my-4" type="submit">Anmelden</button>

                <!-- Register -->
                <p>
                    <a href="register.php">Registrieren</a>
                </p>

            </form>
            <!-- Default form login -->

            <?php
            // fehlermeldung oder nachricht ausgeben
            if (!empty($message)) {
                echo "<br><div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
            } else if (!empty($error)) {
                echo "<br><div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
            }
            ?>
        </div>

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