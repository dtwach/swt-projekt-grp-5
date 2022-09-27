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
    <div class="container-xl">
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
    <div class="container-xl profile mb-2">
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
        <div class="desc p-3">
            <h3>Beschreibung</h3>
            <?php
            require 'includes/dbcon.inc.php';
            $stmt = $con->prepare("SELECT Beschreibung FROM user WHERE ID=?;");
            $stmt->bind_param('i', $_GET["id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_array()[0];
            if (!isset($row)) {
                echo " <p> Keine Beschreibung vorhanden!</p>";
            } else {
                echo "<p>" . $row . "</p>";
            }
            ?>
        </div>
        <form action="includes/follow.inc.php" method="POST">
            <input type="hidden" name="gefolgtid" id="gefolgtid" value="<?php echo $_GET['id'] ?>" />
            <button class="btn btn-primary follow w-100" type="submit" name="follow_submit">
                <h4 class="mb-0">Folge User</h4>
            </button>
        </form>
        <div class="reviews text-center d-md-flex justify-content-center align-items-center p-3">
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
        <div class="following text-center text-md-start p-3">
            <h4 class="mb-0">following:
                <?php
                require 'includes/dbcon.inc.php';
                $stmt = $con->prepare("SELECT COUNT(folger) as folgt FROM folgeliste WHERE folger=?;");
                $stmt->bind_param('i', $_GET["id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                echo $row['folgt'];
                ?></h4>
            <ul class="list-unstyled hidden">
                <?php
                require 'includes/dbcon.inc.php';
                $stmt = $con->prepare("SELECT f.gefolgt,u.Username,u.ID 
                FROM folgeliste as f 
                JOIN user as u on u.ID = f.gefolgt
                WHERE folger=?;");
                $stmt->bind_param('i', $_GET["id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                if (!isset($row['gefolgt'])) {
                    echo "<li> Dieser User folgt niemandem! </li>";
                } else {
                    echo "<li><a href='profile.php?id=" . $row['ID'] . "'> " . $row['Username'] . "</a></li>";
                }
                ?>
            </ul>
        </div>
        <div class="followers text-center text-md-start p-3">
            <h4 class="mb-0">followers:
                <?php
                require 'includes/dbcon.inc.php';
                $stmt = $con->prepare("SELECT COUNT(gefolgt) as follower FROM folgeliste WHERE gefolgt=?;");
                $stmt->bind_param('i', $_GET["id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                echo $row['follower'];
                ?></h4>
            <ul class="list-unstyled hidden">
                <?php
                require 'includes/dbcon.inc.php';
                $stmt = $con->prepare("SELECT f.folger,u.Username,u.ID 
                FROM folgeliste as f 
                JOIN user as u on u.ID = f.folger 
                WHERE gefolgt=?;");
                $stmt->bind_param('i', $_GET["id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                if (!isset($row['folger'])) {
                    echo "<li> Niemand folgt diesem User! </li>";
                } else {
                    echo "<li><a href='profile.php?id=" . $row['ID'] . "'> " . $row['Username'] . "</a></li>";
                }
                ?>
            </ul>
        </div>
        <div class="recentrev p-3">
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
        <div class="list p-3">
            <nav>
                <div class="nav nav-tabs nav-fill" role="tablist">
                    <p class="m-2">Wunschliste: </p>

                    <button class="nav-link active" id="list-film-tab" data-bs-toggle="tab" data-bs-target="#list-film"
                        aria-selected="true">Filme</button>

                    <button class="nav-link" id="list-series-tab" data-bs-toggle="tab" data-bs-target="#list-series"
                        aria-selected="false">Serien</button>

                    <button class="nav-link" id="list-game-tab" data-bs-toggle="tab" data-bs-target="#list-game"
                        aria-selected="false">Videospiele</button>

                    <button class="nav-link" id="list-music-tab" data-bs-toggle="tab" data-bs-target="#list-music"
                        aria-selected="false">Musik</button>

                    <button class="nav-link" id="list-book-tab" data-bs-toggle="tab" data-bs-target="#list-book"
                        aria-selected="false">Bücher</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-film" role="tabpanel" aria-labelledby="list-film-tab">
                    <div class="row mt-2">
                        <?php
                        include_once './includes/showwatchlist.inc.php';
                        $kategorie = 2;
                        showWatchlist($kategorie);
                        ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="list-series" role="tabpanel" aria-labelledby="list-series-tab">
                    <div class="row mt-2">
                        <?php
                        $kategorie = 3;
                        showWatchlist($kategorie);
                        ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="list-game" role="tabpanel" aria-labelledby="list-game-tab">
                    <div class="row mt-2">
                        <?php
                        $kategorie = 1;
                        showWatchlist($kategorie);
                        ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="list-music" role="tabpanel" aria-labelledby="list-music-tab">
                    <div class="row mt-2">
                        <?php
                        $kategorie = 5;
                        showWatchlist($kategorie);
                        ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="list-book" role="tabpanel" aria-labelledby="list-book-tab">
                    <div class="row mt-2">
                        <?php
                        $kategorie = 4;
                        showWatchlist($kategorie);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>