<?php
function already_watchlisted($myid, $content_id)
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT * 
    FROM watchlist
    WHERE User=? and Content=?;");
    $stmt->bind_param('ii', $myid, $content_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows == 0) {
        return false;
    } else {
        return true;
    }
}
if (isset($_POST['watchlist_submit'])) {
    require 'dbcon.inc.php';
    $name = $_SESSION['user'];
    $id = $_SESSION['id'];
    $content_id = htmlspecialchars($_POST['contentid']);
    // Status ist vorübergehend immer auf 1
    $status = 1;
    date_default_timezone_set('Europe/Berlin');
    $date = date('Y-m-d H:i:s');
    if (empty($content_id)) {
        header('Location: ../content.php?id=' . $content_id . '&ms=empty');
        exit();
    }
    if ($content_id == $id) {
        header('Location: ../content.php?id=' . $content_id . '&ms=sameid');
        exit();
    }
    if (already_watchlisted($id, $content_id)) {
        header('Location: ../content.php?id=' . $content_id . '&ms=alreadywatchlisted');
        exit();
    }

    $stmt = $con->prepare("INSERT INTO watchlist VALUES (?, ?, ?, ?);");
    if (!$stmt) {
        header('Location: ../content.php?id=' . $content_id . '&ms=db');
        exit();
    }
    $stmt->bind_param('iiis', $id, $content_id, $status, $date);
    $stmt->execute();
    if (!$stmt) {
        header('Location: ../content.php?id=' . $content_id . '&ms=db');
        exit();
    }
    header('Location: ../content.php?id=' . $content_id . '&ms=success');
    $stmt->close();
    $con->close();
}