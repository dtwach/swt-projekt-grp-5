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
            $stmt = $con->prepare("SELECT r.Inhalt, r.Bewertung, c.Titel, c.Bild, u.Username
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
            echo'
                <h4>' . $item['Username'] . '</h4>
                <div class="container">
                    <h4 class="text-center py-3">Alle Reviews:</h4>
                    <div class="row row-cols-1 row-cols-md-2 g-2 g-lg-3">
                    ';
                $result->data_seek(0);

                if($result->num_rows == 0){
                    echo'<h5 class=" mt-5 text-center">Keine Reviews vorhanden' . "\u{1F625}" . '</h5>';
                }

                while($item = $result->fetch_assoc()){
                    $picture = (is_null($item['Bild'])) ? "https://image.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600w-1037719192.jpg" : 
                    "data:image/jpeg;base64," + base64_encode($item['Bild'])  ;
                    echo'
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
                                                <p class="card-text">' . $item['Inhalt'] . '</p>
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