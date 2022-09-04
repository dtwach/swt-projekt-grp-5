<?php
// Überprüfen des Strings
if (empty($_GET["search"])) {
    header('Location: searchbar.example.php?ms=empty');
    exit();
}
if (strlen($_GET["search"]) <= 2) {
    header('Location: searchbar.example.php?ms=short');
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