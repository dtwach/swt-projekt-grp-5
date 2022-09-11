<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SERVER['HTTP_REFERER'])) {
    $bits = explode('?', $_SERVER['HTTP_REFERER']);
    $redirect = $bits[0];
}

// Überprüfen des Strings
if (empty($_GET["search"])) {
    header('Location: ' . $redirect . '?ms=searchempty');
    exit();
}
if (strlen($_GET["search"]) <= 2) {
    header('Location: ' . $redirect . '?ms=searchshort');
    exit();
}
include './includes/search.inc.php';
if (isset($_GET)) {
    display();
}
function display()
{
    $search_result = get_search_results(htmlspecialchars($_GET["search"]));
    while ($row_search = $search_result->fetch_array()) {
        echo "ID: " . $row_search[0];
        echo "<br>Titel: " . $row_search["Titel"];
        echo "<br>Beschreibung: " . $row_search["Beschreibung"];
        echo "<br>Kategorie ID: " . $row_search["Kategorie"];
        echo "<br>Kategorie Name: " . $row_search["Kategoriebezeichnung"];
        echo "<br><br>";
    }
}