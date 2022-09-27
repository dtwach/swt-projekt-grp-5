<?php
function already_followed($myid, $followedid)
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT * 
    FROM folgeliste
    WHERE folger=? and gefolgt=?;");
    $stmt->bind_param('ii', $myid, $followedid);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows == 0) {
        return false;
    } else {
        return true;
    }
}
if (isset($_POST['follow_submit'])) {
    require 'dbcon.inc.php';
    $name = $_SESSION['user'];
    $id = $_SESSION['id'];
    $gefolgt_id = htmlspecialchars($_POST['gefolgtid']);
    if (empty($gefolgt_id)) {
        header('Location: ../profile.php?id=' . $gefolgt_id . '&ms=empty');
        exit();
    }
    if ($gefolgt_id == $id) {
        header('Location: ../profile.php?id=' . $gefolgt_id . '&ms=sameid');
        exit();
    }
    if (already_followed($id, $gefolgt_id)) {
        header('Location: ../profile.php?id=' . $gefolgt_id . '&ms=alreadyfollowed');
        exit();
    }

    $stmt = $con->prepare("INSERT INTO folgeliste VALUES (?, ?);");
    if (!$stmt) {
        header('Location: ../profile.php?id=' . $gefolgt_id . '&ms=db');
        exit();
    }
    $stmt->bind_param('ii', $id, $gefolgt_id);
    $stmt->execute();
    if (!$stmt) {
        header('Location: ../profile.php?id=' . $gefolgt_id . '&ms=db');
        exit();
    }
    header('Location: ../profile.php?id=' . $gefolgt_id . '&ms=success');
    $stmt->close();
    $con->close();
}