<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_GET['id'])) {
    header('Location: ./content_overview.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review: Content Title</title>
    <link href="css/content-page.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="js/contentPage.js" defer></script>

    <?php
    include './navbar.php';
    ?>
</head>

<body>


    <div class="text-center p-sm-4 pt-2">
        <!-- TODO ADD REVIEW MODAL -->
        <h4>
            <?php
            require 'includes/dbcon.inc.php';
            $content_id = $_GET['id'];
            $stmt = $con->prepare("SELECT 
                c.ID,c.Titel,c.Beschreibung,c.Kategorie,
                k.ID,k.Kategoriebezeichnung,c.Bild
                FROM content AS c, kategorie AS k
                WHERE c.ID = ?
                and c.Kategorie = k.ID;");
            $stmt->bind_param('i', $content_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_main = $result->fetch_assoc();
            if (is_null($data_main['Titel'])) {
                echo 'Keine Beschreibung Vorhanden!';
            } else echo $data_main['Titel'];
            ?>
        </h4>
        <div class="row row-cols-1 row-cols-md-2 g-2 g-lg-3">
            <div class="col col-md-4">
                <?php
                if ($data_main['Bild'] == NULL) {
                    echo '<img src="./img/content_ph.jpg"
                                    class="img-fluid" alt="">';
                } else {
                    echo '<img class="img-fluid" src="data:image/jpeg;base64,' . base64_encode($data_main['Bild']) . '"/>';
                }
                ?>
            </div>
            <div class="col col-md-8">
                <div class="row row-cols-2 row-cols-lg-3">
                    <div class="col">
                        <div class="row row-cols-2 row-cols-lg-1">
                            <p class="text-end text-lg-start">Kategorie:</p>
                            <p class="text-start">
                                <?php
                                require 'includes/dbcon.inc.php';
                                $content_id = $_GET['id'];
                                if (is_null($data_main['Kategoriebezeichnung'])) {
                                    echo 'Keine Beschreibung Vorhanden!';
                                } else echo $data_main['Kategoriebezeichnung'];
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row row-cols-2 row-cols-lg-1">
                            <p class="text-end text-lg-start">Bewertung:</p>
                            <?php
                            require 'includes/dbcon.inc.php';
                            $content_id = $_GET['id'];
                            $stmt = $con->prepare("SELECT AVG ( Bewertung ) as Bewertung
                                FROM review
                                WHERE Content=?
                                ");
                            $stmt->bind_param('i', $content_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $data = $result->fetch_assoc();
                            if (is_null($data['Bewertung'])) {
                                echo '<p class="text-start">Keine</p>';
                            } else echo '<p class="text-start">' . sprintf("%.2f", $data['Bewertung']) . '</p>';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="text-start">
                    <?php
                    require 'includes/dbcon.inc.php';
                    if (is_null($data_main['Beschreibung'])) {
                        echo 'Keine Beschreibung Vorhanden!';
                    } else echo $data_main['Beschreibung'];
                    ?>
                </div>

                <div class="d-flex justify-content-evenly pt-4 px-4">
                    <button class="px-2 rounded-4 border bg-light" data-bs-toggle="modal"
                        data-bs-target="#addReveiwModal">
                        Review erstellen
                    </button>
                    <form action="includes/watchlist.inc.php" method="POST">
                        <input type="hidden" name="contentid" id="contentid" value="<?php echo $_GET['id'] ?>" />
                        <button class="p-3 rounded-4 border bg-light" type="submit" name="watchlist_submit">
                            in die Watchliste
                        </button>
                    </form>
                </div>
            </div>

        </div>
        <br />

        <div class="d-flex justify-content-between">
            <a href="" class="p-3" data-bs-toggle="modal" data-bs-target="#changeImgModal">Bild ändern </a>
            <a href="" class="p-3" data-bs-toggle="modal" data-bs-target="#changeDescModal">Beschreibung ändern</a>
        </div>

        <div class="row">
            <?php
            require 'includes/dbcon.inc.php';
            $content_id = $_GET['id'];
            $stmt = $con->prepare("SELECT r.Inhalt, r.Bewertung, c.Titel, u.Username, u.Bild, r.User
                FROM review as r
                JOIN content as c on c.ID = r.Content 
                JOIN user as u on u.ID = r.user
                WHERE r.Content=? 
                ORDER BY r.Timestamp 
                LIMIT 50;
                ");
            $stmt->bind_param('i', $content_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                echo '<h5 class=" mt-5 text-center">Keine Reviews vorhanden' . "\u{1F625}" . '</h5>';
            }

            while ($item = $result->fetch_assoc()) {
                $picture = (is_null($item['Bild'])) ? "./img/profil_ph.png" :
                    "data:image/jpeg;base64," + base64_encode($item['Bild']);
                echo '
                        <div class="col-sm-4 mb-3">
                            <div class="panel panel-primary">
                                <div class="card">
                                    <div class="row no-gutters">
                                        <div class="d-flex px-3 justify-content-between">
                                            <div class="d-flex ">
                                                <img src="' . $picture . '"
                                                    alt="Logo" width="24" height="20" class="rounded-4">
                                                <a href="/profile.php?id=' . $item['User'] . '">
                                                    <h6 class="text-start card-title">' . $item['Username'] . '</h6>
                                                </a>
                                            </div>
                                            <h6 class="card-title">' . $item['Bewertung'] . '</h6>
                                        </div>
            
                                        <div class="col">
                                            <div class="card-block px-2 mx-1" style="max-height: 130px; text-align: justify;">
                                                <p class="card-text truncate-max-5lines">' . $item['Inhalt'] . '</p>
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
        <!-- add review modal -->
        <div class="modal fade" id="addReveiwModal" aria-labelledby="addReviewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <!-- Modal Inhalt -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addReviewLabel">Neues Review hinzufügen</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form action="includes/create_review.inc.php" id="form1" method="post" name="review_submit">
                            <div class="text-start my-1">
                                <label class="fw-bold" for="reviewRating">Bewertung</label>
                            <input type="number" min="1" max="10" class="form-control w-25 px-3" name="reviewRating" id="reviewRating
                            placeholder="1 - 10" name="reviewRating">

                            </div>
                            <div class="text-start my-1 pt-1">
                                <label class="fw-bold" for="reviewText">Review</label>
                                <textarea type="text" class="form-control text-start" name="reviewText" id="reviewText" 
                                    placeholder="Enter Review" name="reviewText" style="height:250px;"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-default btn-outline-danger"
                            data-bs-dismiss="modal">Abbrechen</button>
                            <?php
                            echo '<button type="submit" class="btn btn-outline-success" form="form1"
                            name="review_submit" value="' . $_GET['id'] . '" data-bs-dismiss="modal">Fertig</button>';
                            ?>
                  
                    </div>
                </div>
            </div>
        </div>

        <!-- change image modal -->
        <div class="modal fade" id="changeImgModal" aria-labelledby="addReviewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <!-- Modal Inhalt -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addReviewLabel">Bild von
                            <?php
                            if (is_null($data_main['Titel'])) {
                                echo 'Kein Titel Vorhanden!';
                            } else echo $data_main['Titel'];
                            ?> ändern</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form action="/page.php">

                            <div class="text-start my-1 pt-1">
                                <label class="fw-bold" for="reviewText">wähle ein neues Bild aus</label>
                                <input class="form-control" type="file" accept="image/png, image/gif, image/jpeg"
                                    id="contentImg">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-default btn-outline-danger"
                            data-bs-dismiss="modal">Abbrechen</button>
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Fertig</button>
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
                        <h4 class="modal-title" id="addReviewLabel">Beschreibung von
                            <?php
                            if (is_null($data_main['Titel'])) {
                                echo 'Kein Titel Vorhanden!';
                            } else echo $data_main['Titel'];
                            ?>
                            ändern</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form action="/page.php">
                            <div class="text-start my-1 pt-1">
                                <label class="fw-bold" for="reviewText">Neue Beschreibung</label>
                                <textarea type="text" class="form-control text-start" id="reviewText"
                                    placeholder="Enter Review" name="reviewText" style="height:250px;"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-default btn-outline-danger"
                            data-bs-dismiss="modal">Abbrechen</button>
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Fertig</button>
                    </div>
                </div>
            </div>
        </div>

    </div>


</body>

</html>