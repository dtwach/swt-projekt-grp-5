<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SERVER['HTTP_REFERER'])) {
    $bits = explode('?', $_SERVER['HTTP_REFERER']);
    $redirect = $bits[0];
    // Überprüfen des Strings
    //var_dump($bits);
    //var_dump($redirect);
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
    } else if (!isset($bits[1])) {
        $bits = explode('?', $_SERVER['HTTP_REFERER']);
        $redirect = $bits[0];
        if (empty($_GET["search"])) {
            header('Location: ' . $redirect . '?ms=searchempty');
            exit();
        }
        if (strlen($_GET["search"]) <= 2) {
            header('Location: ' . $redirect . '?ms=searchshort');
            exit();
        }
    } else if (str_starts_with($bits[1], 'ms=')) {
        $redirect = $bits[0];
        if (empty($_GET["search"])) {
            header('Location: ' . $redirect . '?ms=searchempty');
            exit();
        }
        if (strlen($_GET["search"]) <= 2) {
            header('Location: ' . $redirect . '?ms=searchshort');
            exit();
        }
    } else {
        $redirect .= '?' . $bits[1];
        $rm_and = explode('&ms=', $_SERVER['HTTP_REFERER']);
        $redirect = $rm_and[0];
        if (empty($_GET["search"])) {
            header('Location: ' . $redirect . '&ms=searchempty');
            exit();
        }
        if (strlen($_GET["search"]) <= 2) {
            header('Location: ' . $redirect . '&ms=searchshort');
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
    <link href="css/content-overview.css" rel="stylesheet">
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
    <div class="container">
        <div class="row">
            <?php

            include './includes/search.inc.php';
            if (isset($_GET["search"])) {
                $search_result = get_search_results(htmlspecialchars($_GET["search"]));
                if ($search_result->num_rows == 0) {
                    echo '<h2>Keine Einträge Gefunden!</h2>';
                } else {
                    while ($row_search = $search_result->fetch_array()) {
                        echo '
                <div class="col-sm-4 mb-3">
                <div class="panel panel-primary">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-auto text-center">
                                <a href="content.php?id=' . $row_search["ID"] . '"><h4 class="card-title">' . $row_search["Titel"] . '</h4>';
                        if ($row_search['Bild'] == NULL) {
                            echo '<img src="./img/content_ph.jpg"
                                    class="img-fluid rounded-2" height="400px" width="400px"alt="">';
                        } else {
                            echo '<img class="img-fluid rounded-2" height="400px" width="400px" src="data:image/jpeg;base64,' . base64_encode($row_search['Bild']) . '"/>';
                        }
                        echo '
                            </a></div>
                            <div class="col">';
                        echo 'Kategorie:  <a href="search.php?search=category:' . $row_search["Kategoriebezeichnung"] . '">' . $row_search["Kategoriebezeichnung"] . '</a>';
                        echo '<div class="card-block px-2 mx-1" style="max-height: 110px; text-align: justify;">';
                        if ($row_search['Beschreibung'] == NULL) {
                            echo '<p class="card-text truncate-max-3lines">Keine Beschreibung vorhanden!</p>';
                        } else {
                            echo '<p class="card-text truncate-max-3lines">' . $row_search["Beschreibung"] . '</p>';
                        }
                        echo '               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
                    }
                }
            } else {
                echo '<h2>Keine Suchparameter übergeben!</h2>';
            }
            ?>
        </div>
    </div>
</body>

</html>