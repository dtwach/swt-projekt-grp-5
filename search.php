<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SERVER['HTTP_REFERER'])) {
    $bits = explode('?', $_SERVER['HTTP_REFERER']);
    $redirect = $bits[0];
    // Überprüfen des Strings
    if (str_contains($redirect, '/search.php') and !isset($_GET["ms"])) {
        if (empty($_GET["search"])) {
            header('Location: /search.php?ms=searchempty');
            exit();
        }
        if (strlen($_GET["search"]) <= 2) {
            header('Location: /search.php?ms=searchshort');
            exit();
        }
    } else if (str_contains($redirect, '/search.php')) {
    } else {

        if (empty($_GET["search"])) {
            header('Location: ' . $redirect . '?ms=searchempty');
            exit();
        }
        if (strlen($_GET["search"]) <= 2) {
            header('Location: ' . $redirect . '?ms=searchshort');
            exit();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suche</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <?php
    include './navbar.php';
    ?>
</head>

<body>
    <?php

    include './includes/search.inc.php';
    if (isset($_GET["search"])) {
        $search_result = get_search_results(htmlspecialchars($_GET["search"]));

        while ($row_search = $search_result->fetch_array()) {
            echo "ID: " . $row_search[0];
            echo "<br>Titel: " . $row_search["Titel"];
            echo "<br>Beschreibung: " . $row_search["Beschreibung"];
            echo "<br>Kategorie ID: " . $row_search["Kategorie"];
            echo "<br>Kategorie Name: " . $row_search["Kategoriebezeichnung"];
            echo "<br><br>";
        }
    } else {
        echo 'Keine Suche!';
    }
    ?>
</body>

</html>