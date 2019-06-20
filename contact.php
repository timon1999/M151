<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php?error=Sie sind noch nicht angemeldet. Bitte anmelden!');
}
session_regenerate_id(true);
include('database.php');
?>

<!DOCTYPE html>
<html lang="de">

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
                    <a class="nav-link" href="changepwd.php"><i class="fas fa-cog"> <small><?php if (isset($_SESSION['email'])){echo $_SESSION['email'];} ?></small></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Abmelden</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<body>
                <?php
                if (!empty($message)) {
                    echo "<br><div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
                } else if (!empty($error)) {
                    echo "<br><div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
                }
                ?>
    <table id="dtMaterialDesignExample" class="table table-striped" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th class="th-sm"><b>Vorname</b>
      </th>
      <th class="th-sm"><b>Nachname</b>
      </th>
      <th class="th-sm"><b>Tel.</b>
      </th>
      <th class="th-sm"><b>Mail</b>
      </th>
      <th class="th-sm"><b>Typ</b>
      </th>
      <th class="th-sm"><b>Notiz</b>
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <?php
            $user = $_SESSION['user_id'];
            $query = 'select * from contacts WHERE user=?';
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('i', $user);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
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
    </tr>
  </tbody>

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