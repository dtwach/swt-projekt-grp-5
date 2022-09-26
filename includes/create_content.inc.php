<?php
//Dient als Validierung des Files. Prüft ob der Upload erfolgreich war,
//die Größe passt, das Format stimmt.
function check_file($file)
{
    $filter_arr = array('png', 'jpg', 'jpeg');
    $strip = explode('.', $file['name']);
    $file_extension = end($strip);
    if ($file['error'] !== 0) {
        header('Location: ../content_overview.php?ms=error');
        exit();
    }
    if ($file['size'] > 16000000) {
        header('Location: ../content_overview.php?ms=size');
        exit();
    }
    if (!in_array($file_extension, $filter_arr)) {
        header('Location: ../content_overview.php?ms=format');
        exit();
    }
    return file_get_contents($file['tmp_name']);
}

//Hier wird der Name der Übung mit den vorhandenen Übungen verglichen.
//Kommt diser schon vor, wird eine Meldung für den Benutzer generiert.
function compare_ex_name($name_content)
{
    require 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT * FROM content WHERE Titel=?;");
    if (!$stmt) {
        header('Location: ../content_overview.php?ms=db');
        exit();
    }
    $stmt->bind_param('s', $name_content);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (is_null($result)) {
        return;
    }
    $name_low = strtolower($name_content);
    $result_low = strtolower($result['Titel']);
    if ($name_low === $result_low) {
        header('Location: ../content_overview.php?ms=taken');
        exit();
    }
}
// Hier ist der Code um eine Übung zu erstellen und diese in die Datenbank zu legen.
if (isset($_POST['content_submit'])) {
    require 'dbcon.inc.php';
    $name = $_SESSION['user'];
    $id = $_SESSION['id'];
    $name_content = htmlspecialchars($_POST['name_content']);
    $description = htmlspecialchars($_POST['contentDescription']);
    $kategorie = htmlspecialchars($_POST['kategorie_select']);
    if (!empty($_FILES['contentImg'])) {
        $file = $_FILES['contentImg'];
    }
    if (empty($description) || strlen(trim($description)) == 0) {
        $description = NULL;
    }
    if (empty($name_content)) {
        header('Location: ../content_overview.php?ms=empty');
        exit();
    }

    compare_ex_name($name_content);

    if (!empty($file['name'])) {
        $blob = check_file($file);
    } else {
        $blob = NULL;
    }

    $stmt = $con->prepare("INSERT INTO content (Titel, Beschreibung, Bild, Kategorie) VALUES (?, ?, ?, ?);");
    if (!$stmt) {
        header('Location: ../content_overview.php?ms=db');
        exit();
    }
    $stmt->bind_param('sssi', $name_content, $description, $blob, $kategorie);
    $stmt->execute();
    if (!$stmt) {
        header('Location: ../content_overview.php?ms=db');
        exit();
    }
    header('Location: ../content_overview.php?ms=success');
    $stmt->close();
    $con->close();
}