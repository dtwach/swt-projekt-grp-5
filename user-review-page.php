<?php
if (!isset($_SESSION)) {
    session_start();
} ?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alle Reviews</title>
    <link href="css/content-page.css" rel="stylesheet">
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

    <div class="text-center p-sm-4 pt-3">
        <?php
        require 'includes/dbcon.inc.php';
        $user_id = (isset($_GET['id'])) ? $_GET['id'] : $_SESSION['id'];
        $stmt = $con->prepare("SELECT r.Inhalt, r.Bewertung, c.Titel, c.Bild, u.Username, u.Bild as userbild,r.User,r.Content
            FROM review as r
            JOIN content as c on c.ID = r.Content 
            JOIN user as u on u.ID = r.User
            WHERE r.User=? 
            ORDER BY r.Timestamp 
            LIMIT 50;
            ");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        if (!isset($item['userbild'])) {
            echo '<img width="250px" height="150px" class="rounded-2" class="img-fluid" src="./img/profil_ph.png"
                             alt="">';
        } else {
            echo '<img width="250px" height="150px" class="rounded-2" class="img-fluid" src="data:image/jpeg;base64,' . base64_encode($item['userbild']) . '"/>';
        }

        require 'includes/dbcon.inc.php';
        $stmt_name = $con->prepare("SELECT Username FROM user WHERE ID=?;");
        $stmt_name->bind_param('i', $_GET["id"]);
        $stmt_name->execute();
        $result_name = $stmt_name->get_result();
        $row_name = $result_name->fetch_array()[0];
        echo '<h2>' . $row_name . '</h2>';
        echo '<div class="container">
                    <h4 class="text-center py-3">Alle Reviews:</h4>
                    <div class="row row-cols-1 row-cols-md-2 g-2 g-lg-3">
                    ';
        $result->data_seek(0);

        if ($result->num_rows == 0) {
            echo '<h5 class=" mt-5 text-center">Noch keine Review verfasst' . "\u{1F625}" . '</h5>';
        }

        while ($item = $result->fetch_assoc()) {
            $picture = (is_null($item['Bild'])) ? "./img/content_ph.jpg" :
                "data:image/jpeg;base64," . base64_encode($item['Bild']);
            echo '
                        <div class="col mb-3">
                            <div class="panel panel-primary">
                                <div class="card">
                                    <div class="row">
                                        <div class="d-flex px-4 justify-content-between">
                                            <div class="d-flex ">
                                                <img src="' . $picture . '"
                                                    alt="Logo" width="24" height="20" class="rounded-4">
                                                <h6 class="text-start card-title">' . $item['Titel'] . '</h6>
                                            </div>
                                            <h6 class="card-title">Rating: ' . intval($item['Bewertung']) . '</h6>
                                        </div>
        
                                        <div class="col">
                                            <div class="card-block px-2 mx-1" style="text-align: justify;">
                                            <a class="text-decoration-none text-reset" href="/review.php?uid=' . $item['User'] . '&cid=' . $item['Content'] . '">
                                                <p class="card-text">' . $item['Inhalt'] . '</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
        }
        ?>
    </div>
    </div>
    </div>


</body>