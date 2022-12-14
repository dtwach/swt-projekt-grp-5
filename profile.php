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
require 'includes/dbcon.inc.php';
$stmt = $con->prepare("SELECT Username FROM user WHERE ID=?;");
$stmt->bind_param('i', $_GET["id"]);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_array();
if (empty($row)) {
    header('Location: /profile.php?id=' . $_SESSION["id"]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil:
        <?php
        if (is_null($row[0])) {
            echo 'Kein Profil Vorhanden!';
        } else echo $row[0];
        ?>
    </title>
    <link href="css/profilegrid.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js">
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
                echo '<img style="object-fit: contain;width: 100%;height: 100%;" src="./img/profil_ph.png" class="rounded-2 img-fluid" alt="">';
            } else {
                echo '<img style="object-fit: contain;width: 100%;height: 100%;" class="rounded-2 img-fluid" src="data:image/jpeg;base64,' . base64_encode($row) . '"/>';
            }
            ?>
        </div>
        <div class="desc p-3">
            <h3>Beschreibung</h3>
            <div class="text-start">
                <?php
                require 'includes/dbcon.inc.php';
                $stmt = $con->prepare("SELECT Beschreibung FROM user WHERE ID=?;");
                $stmt->bind_param('i', $_GET["id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_array()[0];
                if (!isset($row)) {
                    echo " <p class='text-wrap text-break'> Keine Beschreibung vorhanden!</p>";
                } else {
                    echo "<p class='text-wrap text-break'>" . $row . "</p>";
                }
                ?>
            </div>
        </div>

        <form action="includes/follow.inc.php" method="POST" class="follow">
            <input type="hidden" name="gefolgtid" id="gefolgtid" value="<?php echo $_GET['id'] ?>" />

            <?php
            require 'includes/dbcon.inc.php';
            $stmt = $con->prepare("SELECT gefolgt,folger
                FROM folgeliste as f 
                WHERE folger=? and gefolgt=?;
                ");
            $stmt->bind_param('ii', $_SESSION["id"], $_GET["id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if ($_GET['id'] == $_SESSION['id']) {
                echo '
                <div class="row g-1 g-md-2">
                    <div class="col-6 col-md-12 col-xxl-auto">
                        <a href="pl-2" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#changeImgModal"><h6 class="mt-1">Bild ??ndern</h6></a>
                    </div> 
                    <div class="col-6 col-md-12 col-xxl-auto">
                        <a href="" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#changeDescModal"><h6 class="mt-1">Beschreibung ??ndern</h6></a>
                    </div>                  
                </div>                 
                ';
            } else if (!isset($row)) {
                echo '
                    <button class="btn btn-primary w-100" type="submit" name="follow_submit">
                    <h4 class="mb-0">Folge User</h4>
                    </button>
                ';
            } else {
                echo '
                <button class="btn btn-danger w-100" type="submit" name="defollow_submit">
                <h4 class="mb-0">Entfolge User</h4>
                </button>
                ';
            }
            ?>
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
            <ul class="list-unstyled hidden" style="max-height: 50px;overflow-y:auto;">
                <?php
                require 'includes/dbcon.inc.php';
                $stmt = $con->prepare("SELECT f.gefolgt,u.Username,u.ID 
                FROM folgeliste as f 
                JOIN user as u on u.ID = f.gefolgt
                WHERE folger=?;");
                $stmt->bind_param('i', $_GET["id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 0) {
                    echo "<li> Dieser User folgt niemandem! </li>";
                } else {
                    while ($item = $result->fetch_array()) {
                        echo "<li><a href='profile.php?id=" . $item['ID'] . "'> " . $item['Username'] . "</a></li>";
                    }
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
            <ul class="list-unstyled hidden" style="max-height: 50px;overflow-y:auto;">
                <?php
                require 'includes/dbcon.inc.php';
                $stmt = $con->prepare("SELECT f.folger,u.Username,u.ID 
                FROM folgeliste as f 
                JOIN user as u on u.ID = f.folger 
                WHERE gefolgt=?;");
                $stmt->bind_param('i', $_GET["id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 0) {
                    echo "<li> Niemand folgt diesem User! </li>";
                } else {
                    while ($item = $result->fetch_assoc()) {
                        echo "<li><a href='profile.php?id=" . $item['ID'] . "'> " . $item['Username'] . "</a></li>";
                    }
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

                    <?php
                    require 'includes/dbcon.inc.php';
                    $stmt = $con->prepare("SELECT r.Inhalt, r.Bewertung, c.titel, r.User, r.Content FROM review as r
                        JOIN content as c on c.ID = r.Content WHERE User=? ORDER BY r.Timestamp DESC LIMIT 2;");
                    $stmt->bind_param('i', $_GET["id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $data = $result->fetch_all();
                    echo '
                    <div class="col-6 text-end">
                        <a href="user-review-page.php?id=' . $_GET["id"] . '">Alle Reviews</a>
                    </div>';
                    if (!empty($data)) {
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
                    } else {
                        echo 'Keine Reviews erstellt!';
                    }

                    ?>
                </div>
            </div>
        </div>

        <?php
        if ($_GET['id'] == $_SESSION['id']) {
            echo '
            <!-- change image modal -->
            <div class="modal fade" id="changeImgModal" aria-labelledby="addReviewLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <!-- Modal Inhalt -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="addReviewLabel">Bild ??ndern</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
    
                        <div class="modal-body">
    
                            <form action="includes/profile.inc.php" id="formimg" method="POST"
                                enctype="multipart/form-data">
    
                                <div class="text-start my-1 pt-1">
                                    <input type="hidden" name="userid" id="userid" value="' . $_GET['id'] . '" />
                                    <label class="fw-bold" for="userImg">w??hle ein neues Bild aus</label>
                                    <input class="form-control" type="file" id="userImg" name="userImg"
                                        accept=".jpg, .jpeg, .png">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer gap-2">
                            <button type="button" class="btn btn-default btn-outline-danger"
                                data-bs-dismiss="modal">Abbrechen</button>
                            <button type="submit" form="formimg" name="imgChange" class="btn btn-outline-success"
                                data-bs-dismiss="modal">Fertig</button>
                        </div>
                    </div>
                </div>
            </div>
    
    
            <!-- description change modal -->
            <div class="modal fade" id="changeDescModal" aria-labelledby="addReviewLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <!-- Modal Inhalt -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="addReviewLabel">Beschreibung ??ndern</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
    
                        <div class="modal-body">
    
                            <form action="includes/profile.inc.php" id="formdesc" method="POST">
                                <div class="text-start my-1 pt-1">
                                    <input type="hidden" name="userid" id="userid" value="' . $_GET['id'] . '" />
        <label class="fw-bold" for="reviewText">Neue Beschreibung</label>
        <textarea type="text" class="form-control text-start" id="descText" placeholder="Neue Beschreibung"
            name="descText" style="height:250px;"></textarea>
    </div>
    </form>
    </div>
    <div class="modal-footer gap-2">
        <button type="button" class="btn btn-default btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
        <button type="submit" form="formdesc" name="descChange" class="btn btn-outline-success"
            data-bs-dismiss="modal">Fertig</button>
    </div>
    </div>
    </div>
    </div>
    ';
        }
        ?>
        <div class="list p-3">
            <nav>
                <div class="nav nav-tabs nav-fill" role="tablist">
                    <p class="m-2">Watchliste: </p>

                    <button class="nav-link active" id="list-film-tab" data-bs-toggle="tab" data-bs-target="#list-film"
                        aria-selected="true">Filme</button>

                    <button class="nav-link" id="list-series-tab" data-bs-toggle="tab" data-bs-target="#list-series"
                        aria-selected="false">Serien</button>

                    <button class="nav-link" id="list-game-tab" data-bs-toggle="tab" data-bs-target="#list-game"
                        aria-selected="false">Videospiele</button>

                    <button class="nav-link" id="list-music-tab" data-bs-toggle="tab" data-bs-target="#list-music"
                        aria-selected="false">Musik</button>

                    <button class="nav-link" id="list-book-tab" data-bs-toggle="tab" data-bs-target="#list-book"
                        aria-selected="false">B??cher</button>
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