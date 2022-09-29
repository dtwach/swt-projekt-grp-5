<?php
if (!isset($_SESSION)) {
    session_start();
}
//Hier wird die Review-ID geprüft, ob der Benutzer schon eine Review 
//zu diesem Content erstellt hat.
function compare_id($r_id, $u_id)
{
    require 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT * FROM review WHERE Content=? AND User=?;");
    if (!$stmt) {
        header('Location: ../content.php?id=' . $r_id . '&ms=db');
        exit();
    }
    $stmt->bind_param('ii', $r_id, $u_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if (isset($result)) {
        header('Location: ../content.php?id=' . $r_id . '&ms=review');
        exit();
    }
    $stmt->close();
    return;
}
// Hier ist der Code um eine Review zu erstellen und diese in die Datenbank zu legen.
if (isset($_POST['review_submit'])) {
    require 'dbcon.inc.php';
    $user_id = $_SESSION['id'];
    $description = htmlspecialchars($_POST['reviewText']);
    $review_rating = htmlspecialchars($_POST['reviewRating']);
    $review_id = htmlspecialchars($_POST['review_submit']);
    if (empty($description)) {
        header('Location: ../content.php?id=' . $review_id . '&ms=empty');
        exit();
    }
    if (empty($review_id)) {
        header('Location: ../content.php?id=' . $review_id . '&ms=empty');
        exit();
    }
    compare_id($review_id, $user_id);

    date_default_timezone_set('Europe/Berlin');
    $time = date('Y-m-d H:i:s');
    $stmt = $con->prepare("INSERT INTO review (User, Content, Inhalt, Bewertung, Timestamp) VALUES (?, ?, ?, ?, ?);");
    if (!$stmt) {
        header('Location: ../content.php?id=' . $review_id . '&ms=db');
        exit();
    }

    $stmt->bind_param('iisis', $user_id, $review_id, $description, $review_rating, $time);
    $stmt->execute();
    if (!$stmt) {
        header('Location: ../content.php?id=' . $review_id . '&ms=db');
        exit();
    }
    header('Location: ../content.php?id=' . $review_id . '&ms=success');
    $stmt->close();
    $con->close();
}