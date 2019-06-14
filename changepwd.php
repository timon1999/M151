<?php

session_start();
session_regenerate_id(true);
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}

if ($_POST) {
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];

    include('database.php');

    $email = $_SESSION['email'];

    // SELECT Query erstellen, email und passwort mit Datenbank vergleichen
    $query = 'SELECT * FROM users WHERE email=? LIMIT 1';
    // prepare()
    $stmt = $mysqli->prepare($query);
    // bind_param()
    $stmt->bind_param('s', $email);
    // execute()
    $stmt->execute();
    // Passwort auslesen und mit dem eingegeben Passwort vergleichen
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    if (password_verify($oldpassword, $row['password'])) {
        if (isset($_POST['newpassword']) && !empty(trim($_POST['newpassword'])) && $_POST['newpassword'] === $_POST['newrepeatpassword']) {
            $password = trim($_POST['password']);
            $newpassword = $_POST['newpassword'];
            //entspricht das passwort unseren vorgaben? (minimal 8 Zeichen, Zahlen, Buchstaben, keine Zeilenumbrüche, mindestens ein Gross- und ein Kleinbuchstabe)
            if (!preg_match("/(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $newpassword)) {
                $error .= "Passwort: Mindestlänge 8, min. 1 Gross- und Kleinbuchstabe, Zahl und ein Zeichen";
            } else {
                $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
                $query = 'UPDATE `users` SET `password` = ? WHERE `id` = ?';
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('si', $newpassword, $row['id']);
                $stmt->execute();
                $message = "Passwort erfolgreich geändert!";
            }
        } else {
            $error = "das Kennwort ist falsch";
        }
    } 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Passwort ändern</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="dist/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="dist/css/style.css" rel="stylesheet">
</head>

<!--Main Navigation-->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark primary-color">
        <a class="navbar-brand" href="index.php"><strong>Kontaktbuch</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Kontakte</a>
                </li>
                <li class="nav-item">
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
        <div class="container" id="bg-img">
            <div class="row pt-5">
            </div>
        </div>

        <div class="card-body px-lg-5 pt-0 mx-auto mt-5" style="max-width: 500px">

            <form class="text-center border border-light p-5" method="POST" action="changepwd.php">

                <p class="h4 mb-4">Passwort ändern</p>

                <?php
                if (!empty($message)) {
                    echo "<br><div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
                } else if (!empty($error)) {
                    echo "<br><div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
                }
                ?>

                <!-- Altes Password -->
                <input type="password" id="password" name="oldpassword" class="form-control mb-4" placeholder="Altes Passwort">

                <input type="password" id="password" name="newpassword" class="form-control mb-4" placeholder="Neues Passwort">
                <input type="password" id="password" name="newrepeatpassword" class="form-control mb-4" placeholder="Passwort bestätigen">

                <div class="d-flex justify-content-around">
                    <div>
                        <!-- Forgot password -->
                        <a href="forgot.html">Passwort vergessen?</a>
                    </div>
                </div>

                <!-- Sign in button -->
                <button class="btn btn-primary btn-block my-4" type="submit">Passwort ändern</button>
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