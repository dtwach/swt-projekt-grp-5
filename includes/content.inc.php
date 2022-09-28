<?php
if (isset($_POST['descChange'])) {
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once 'dbcon.inc.php';
    $id = $_SESSION['id'];
    $changeid = htmlspecialchars($_POST['contentid']);
    $newDesc = htmlspecialchars($_POST['descText']);
    if (empty($newDesc)) {
        $newDesc = NULL;
    }
    if (strlen($newDesc) > 510) {
        header('Location: ../content.php?id=' . $changeid . '&ms=toolong');
        exit;
    }
    $stmt = $con->prepare("UPDATE content SET Beschreibung=? WHERE id=?");
    $stmt->bind_param('si', $newDesc, $changeid);
    $stmt->execute();
    if ($stmt) {
        header('Location: ../content.php?id=' . $changeid . '&ms=success');
    }
    $stmt->close();
    $con->close();
}
if (isset($_POST['imgChange'])) {
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once 'dbcon.inc.php';
    $id = $_SESSION['id'];
    $changeid = htmlspecialchars($_POST['contentid']);
    if (!empty($_FILES['contentImg'])) {
        $file = $_FILES['contentImg'];
    }
    if (!empty($file['name'])) {
        $blob = check_file($file, $changeid);
    } else {
        $blob = NULL;
    }
    $stmt = $con->prepare("UPDATE content SET Bild=? WHERE id=?");
    $stmt->bind_param('si', $blob, $changeid);
    $stmt->execute();
    if ($stmt) {
        header('Location: ../content.php?id=' . $changeid . '&ms=success');
    }
    $stmt->close();
    $con->close();
}
function check_file($file, $changeid)
{

    $filter_arr = array('png', 'jpg', 'jpeg');
    $strip = explode('.', $file['name']);
    $file_extension = end($strip);
    if ($file['error'] !== 0) {
        header('Location: ../content.php?id=' . $changeid . '&ms=error');
        exit();
    }
    if ($file['size'] > 16000000) {
        header('Location: ../content.php?id=' . $changeid . '&ms=size');
        exit();
    }
    if (!in_array($file_extension, $filter_arr)) {
        header('Location: ../content.php?id=' . $changeid . '&ms=format');
        exit();
    }
    return file_get_contents($file['tmp_name']);
}