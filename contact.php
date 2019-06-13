<?php
include('database.php');
session_start();
session_regenerate_id(true);

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kontakte</title>

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
                <li class="nav-item active">
                    <a class="nav-link" href="contact.php">Kontakte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="newcontact.php">Neuer Kontakt</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto nav-flex-icons">
                <li class="nav-item">
                    <a class="nav-link" href="changepwd.php"><i class="fas fa-user mr-2"> <small><?php echo $_SESSION['email']; ?></small></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Abmelden</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<body>
    <table class="table striped">
        <thead>
            <tr class="header">
                <td><b>Vorname</b></td>
                <td><b>Nachname</b></td>
                <td><b>Tel.</b></td>
                <td><b>Mail</b></td>
                <td><b>Typ</b></td>
                <td><b>Notiz</b></td>
            </tr>
        </thead>
        <tbody>
            <?php
            $user = $_SESSION['user_id'];
            $query = 'select * from contacts WHERE user=?';
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('i', $user);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['firstname'] . "</td>";
                    echo "<td>" . $row['lastname'] . "</td>";
                    echo "<td>" . $row['tel'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['type'] . "</td>";
                    echo "<td>" . $row['note'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr>";
                echo "<td>" . 'Keine Kontakte vorhanden!' . "</td>";
                echo "</tr>";
            }

            ?>
        </tbody>
    </table>
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