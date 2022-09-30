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
            header('Location: search.php?ms=searchempty');
            exit();
        }
        if (strlen($_GET["search"]) <= 2) {
            header('Location: search.php?ms=searchshort');
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js">
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
                    while ($row = $search_result->fetch_array()) {
                        $picture = (is_null($row['Bild'])) ? "./img/content_ph.jpg" : "data:image/jpeg;base64," . base64_encode($row['Bild']);

                        echo '
                        <div class="col-12 col-xl-4 col-lg-6 px-0">
                                <div class="row no-gutter border m-1">
                                    <a style="margin: 0 auto;"href="content.php?id=' . $row["cid"] . '">
                                        <h4 class="col-12 text-center">' . $row["Titel"] . '</h4>
                                        <div class="col-12 text-center" style="height: 300px;  margin: auto">
                                            <img style="object-fit: contain;width: 100%;height: 100%;" src="' . $picture . '" class="rounded-2" alt="">
                                        </div>
                                    </a>
                                    <div class="col" style="height:100px">';
                        echo 'Kategorie:  <a href="search.php?search=category:' . $row["Kategoriebezeichnung"] . '">' . $row["Kategoriebezeichnung"] . '</a>';
                        echo '<div class="card-block px-2 mx-1" style="max-height: 110px; text-align: justify;">';
                        if ($row['Beschreibung'] == NULL) {
                            echo '<p class="card-text truncate-max-3lines">Keine Beschreibung vorhanden!</p>';
                        } else {
                            echo '<p class="card-text truncate-max-3lines">' . $row["Beschreibung"] . '</p>';
                        }
                        echo '               
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