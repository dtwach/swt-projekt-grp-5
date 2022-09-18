<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["id"])) {
    header('Location: /login.php');
}
if (!isset($_GET["id"])) {
    header('Location: /profile.php?id=' . $_SESSION["id"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Content-Review-Plattform</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/profilegrid.css" rel="stylesheet">
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
        <?php
        require 'includes/dbcon.inc.php';
        $stmt = $con->prepare("SELECT Username FROM user WHERE ID=?;");
        $stmt->bind_param('i', $_GET["id"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array()[0];
        echo '<h2>' . $row . '</h2>';
        ?>
    </div>
    <div class="container profile">
        <div class="pic p-1">
            <?php
            require 'includes/dbcon.inc.php';
            $stmt = $con->prepare("SELECT Bild FROM user WHERE ID=?;");
            $stmt->bind_param('i', $_GET["id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_array()[0];
            if ($row == NULL) {
                echo '<img height="250px" width="150px" src="./img/profil_ph.png"
                            class="img-fluid" alt="">';
            } else {
                echo '<img class="picture" src="data:image/jpeg;base64,' . base64_encode($row) . '"/>';
            }
            ?>
        </div>
        <div class="desc">
            <h3>Beschreibung</h3>
            <?php
            require 'includes/dbcon.inc.php';
            $stmt = $con->prepare("SELECT Beschreibung FROM user WHERE ID=?;");
            $stmt->bind_param('i', $_GET["id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_array()[0];
            echo '<p>' . $row . '</p>';
            ?>
        </div>
        <div class="favorite">content</div>
        <button class="btn btn-primary follow">
            <h4 class="mb-0">Follow</h4>
        </button>
        <div class="reviews text-center">
            <?php
            require 'includes/dbcon.inc.php';
            $stmt = $con->prepare("SELECT COUNT(Content) FROM review WHERE User=?;");
            $stmt->bind_param('i', $_GET["id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_array()[0];
            echo '<h4 class="mb-0">Reviews: ' . $row . '</h4>';
            ?>
        </div>
        <div class="following text-center text-md-start">
            <h4 class="mb-0">following: 8</h4>
            <ul class="list-unstyled hidden">
                <li>user 1</li>
                <li>user 2</li>
                <li>user 3</li>
            </ul>
        </div>
        <div class="followers text-center text-md-start">
            <h4 class="mb-0">followers: 8</h4>
            <ul class="list-unstyled hidden">
                <li>user 1</li>
                <li>user 2</li>
                <li>user 3</li>
            </ul>
        </div>
        <div class="recentrev">
            <div class="container h-100">
                <div class="row">
                    <div class="col-6">
                        <h3>Letzte Reviews</h3>
                    </div>
                    <div class="col-6 text-end">
                        <a href="">Alle Reviews</a>
                    </div>
                    <?php
                    require 'includes/dbcon.inc.php';
                    $stmt = $con->prepare("SELECT r.Inhalt, r.Bewertung, c.titel, r.User, r.Content FROM review as r
                        JOIN content as c on c.ID = r.Content WHERE User=? ORDER BY r.Timestamp LIMIT 2;");
                    $stmt->bind_param('i', $_GET["id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $data = $result->fetch_all();
                    foreach ($data as $item) {
                        echo '
                            <div class="col-12 col-lg-6 col-xl-6 col-md-6" >
                                <div class="row">                               
                                    <a class="col-6" href="review.php?uid=' . $item[3] . '&cid=' . $item[4] . '">
                                        <h4 >' . $item[2] . '</h4>     
                                    </a>
                                    <div class="col-6 text-end">Rating: ' . $item[1] . '</div>
                                    <div class="col-12">' . $item[0] . '</div>
                                </div>                            
                            </div>
                            ';
                    }
                    ?>
                </div>
            </div>

        </div>
        <div class="list">wunschliste</div>
    </div>
</body>

</html>