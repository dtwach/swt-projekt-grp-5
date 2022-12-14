<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_GET['uid']) || !isset($_GET['cid'])) {
    header('Location: index.php');
}
require 'includes/dbcon.inc.php';
$user_id = htmlspecialchars($_GET['uid']);
$content_id = htmlspecialchars($_GET['cid']);
$stmt = $con->prepare("SELECT r.Inhalt, r.Bewertung, c.titel, u.Username, c.Bild as Content_Picture, u.Bild as User_Picture, r.User, r.Content
        FROM review as r
        JOIN content as c on c.ID = r.Content 
        JOIN user as u on r.User = u.ID
        WHERE r.User=? AND r.Content=?
        ");
$stmt->bind_param('ii', $user_id, $content_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
if (!isset($data)) {
    header('Location: content_overview.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js">
    </script>
    <script src="js/review.js" defer></script>
    <?php
    include './navbar.php';
    ?>
</head>

<body>
    <?php
    if (!isset($data)) {
        echo '
            <div class="container-lg p-4">
                <h1 class="text-center mt-4">  Keine Reviews gefunden!</h1>
            </div>
            ';
    } else {
        $content_picture = (!isset($data['Content_Picture'])) ? "./img/content_ph.jpg" :
            "data:image/jpeg;base64," . base64_encode($data['Content_Picture']);

        $user_picture = (!isset($data['User_Picture'])) ? "./img/profil_ph.png" : 'data:image/jpeg;base64,' . base64_encode($data['User_Picture']);
        echo '
                <div class="container-lg p-4">
                    <h1 class="text-center">Review</h1>
                    <div class="row">
                        <div class="col-md-4 d-flex align-items-center mb-3">
                        <div style="height: 250px; margin: auto">
                        <img style="object-fit: contain;width: 100%;height: 100%;" class="rounded-2" id="user_picture" name="' . $data['User'] . '" src="' . $user_picture . '" alt="">
                            </div>
                            <span class="m-3">
                                <p class="mb-1">Von:</p>
                                <p>' . $data['Username'] . '</p>
                            </span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-sm-end mb-3" style="margin-left: auto;">
                        <div style="height: 250px; margin: auto">
                        <img style="object-fit: contain;width: 100%;height: 100%;" class="rounded-2" id="content_picture" name="' . $data['Content'] . '" src="' . $content_picture . '"
                                alt="">
                                </div>
                            <span class="m-3 order-sm-first">
                                <p class="mb-1 d-flex justify-content-sm-end">Zu:</p>
                                <p class="d-flex justify-content-sm-end">' . $data['titel'] . '</p>
                            </span>
                        </div>
                    </div>
                    <div class="border rounded">
                        <h4 class="text-center m-2">Rating ' . intval($data['Bewertung']) . '/10</h4>
                        <p class="mx-4">' . $data['Inhalt'] . '</p>
                    </div>
                
            ';
    }
    ?>
    <?php
    if (!isset($_SESSION['id'])) {
    } else {
        require 'includes/dbcon.inc.php';
        $user_id = $_SESSION['id'];
        $stmt = $con->prepare("SELECT 
                u.Rolle
                FROM user AS u
                WHERE u.ID = ?;");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data_main = $result->fetch_assoc();
        if ($_SESSION["id"] == $_GET["uid"]) {
            echo '
        <a href="" class="p-3 text-center" data-bs-toggle="modal" data-bs-target="#changeReviewModal">Review ??ndern</a>
        <a href="" class="p-3 text-center text-danger" data-bs-toggle="modal" data-bs-target="#deleteReviewModal">Review l??schen</a>
        ';
        }
        echo '
        <!-- change review modal -->
        <div class="modal fade" id="changeReviewModal" aria-labelledby="changeReviewModal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <!-- Modal Inhalt -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addReviewLabel">Review bearbeiten</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form action="includes/change_review.inc.php" id="form1" method="post" name="form1">
                            <div class="text-start my-1">
                            <input type="hidden" name="cid" id="cid" value="' . $_GET['cid'] . '" />
                            <input type="hidden" name="uid" id="uid" value="' . $_GET['uid'] . '" />
                                <label class="fw-bold" for="reviewRating">Bewertung</label>
                                <input type="number" min="1" max="10" class="form-control w-25 px-3" name="reviewRating"
                                    id="reviewRating" placeholder="1 - 10" name="reviewRating">

                            </div>
                            <div class="text-start my-1 pt-1">
                                <label class="fw-bold" for="reviewText">Review</label>
                                <textarea type="text" class="form-control text-start" name="reviewText" id="reviewText"
                                    placeholder="Gib dein Review an" name="reviewText" style="height:250px;"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-default btn-outline-danger"
                            data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-outline-success" form="form1" name="review_submit" data-bs-dismiss="modal">Fertig</button>
    </div>
    </div>
    </div>
    </div>
    <!-- delete review modal -->
    <div class="modal fade" id="deleteReviewModal" aria-labelledby="deleteReviewModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <!-- Modal Inhalt -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addReviewLabel">Review l??schen</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <form action="includes/change_review.inc.php" id="form1" method="post" name="form1">
                        <div class="text-start my-1">
                        <input type="hidden" name="cid" id="cid" value="' . $_GET['cid'] . '" />
                        <input type="hidden" name="uid" id="uid" value="' . $_GET['uid'] . '" />
                        <h5>Bist du dir Sicher?</h5>
                    </form>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-default btn-outline-danger"
                        data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-outline-success" form="form1" name="review_delete" data-bs-dismiss="modal">Fertig</button>
</div>
</div>
</div>
</div>
    </div>
    ';
    }
    ?>
</body>

</html>