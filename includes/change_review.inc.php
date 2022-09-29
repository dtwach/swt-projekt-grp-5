<?php
if (!isset($_SESSION)) {
    session_start();
}
// Hier ist der Code um eine Review zu erstellen und diese in die Datenbank zu legen.
if (isset($_POST['review_submit'])) {
    require 'dbcon.inc.php';
    $user_id = $_SESSION['id'];
    $user_id_sent = htmlspecialchars($_POST['uid']);
    $description = htmlspecialchars($_POST['reviewText']);
    $review_rating = htmlspecialchars($_POST['reviewRating']);
    $content_id = htmlspecialchars($_POST['cid']);
    date_default_timezone_set('Europe/Berlin');
    $time = date('Y-m-d H:i:s');
    if (empty($content_id) || $user_id != $user_id_sent) {
        header('Location: ../review.php?uid=' . $user_id_sent . '&cid=' . $content_id . '&ms=empty');
        exit();
    }
    if (empty($description)) {
        $stmt = $con->prepare("UPDATE review SET Bewertung=?, Timestamp=? WHERE User=? AND Content=?");
        $stmt->bind_param('isii', $review_rating, $time, $user_id_sent, $content_id);
    }
    if (empty($review_rating)) {
        $stmt = $con->prepare("UPDATE review SET Inhalt=?, Timestamp=? WHERE User=? AND Content=?");
        $stmt->bind_param('ssii', $description, $time, $user_id_sent, $content_id);
    }
    if (!empty($review_rating) && !empty($description)) {
        $stmt = $con->prepare("UPDATE review SET Inhalt=?,Bewertung=?,Timestamp=? WHERE User=? AND Content=?");
        $stmt->bind_param('sisii', $description, $review_rating, $time, $user_id_sent, $content_id);
    }
    $stmt->execute();
    if (!$stmt) {
        header('Location: ../review.php?uid=' . $user_id_sent . '&cid=' . $content_id . '&ms=db');
        exit();
    }
    header('Location: ../review.php?uid=' . $user_id_sent . '&cid=' . $content_id . '&ms=success');
    $stmt->close();
    $con->close();
}
if (isset($_POST['review_delete'])) {
    require 'dbcon.inc.php';
    $user_id = $_SESSION['id'];
    $user_id_sent = htmlspecialchars($_POST['uid']);
    $content_id = htmlspecialchars($_POST['cid']);
    if (empty($content_id) || $user_id != $user_id_sent) {
        header('Location: ../review.php?uid=' . $user_id_sent . '&cid=' . $content_id . '&ms=empty');
        exit();
    }
    $stmt = $con->prepare("DELETE FROM review WHERE Content=? and User=?");
    $stmt->bind_param('ii', $content_id, $user_id_sent);
    $stmt->execute();
    if (!$stmt) {
        header('Location: ../review.php?uid=' . $user_id_sent . '&cid=' . $content_id . '&ms=db');
        exit();
    }
    header('Location: ../content.php?id=' . $content_id . '&ms=success');
    $stmt->close();
    $con->close();
}