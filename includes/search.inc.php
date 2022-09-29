<?php
if (!isset($_SESSION)) {
    session_start();
}
function get_search_results($query)
{
    include 'dbcon.inc.php';
    if (str_contains($query, "category:")) {
        $query = str_replace("category:", "", $query);
        $query = "%" . htmlspecialchars($query) . "%";
        $stmt = $con->prepare("SELECT 
        c.ID as cid,c.Titel,c.Beschreibung,c.Kategorie,
        k.ID,k.Kategoriebezeichnung,c.Bild
         FROM content AS c, kategorie AS k
         WHERE k.Kategoriebezeichnung LIKE ?
         and c.Kategorie = k.ID
         ORDER by c.Titel ASC;");
    } else {
        $query = "%" . htmlspecialchars($query) . "%";
        $stmt = $con->prepare("SELECT 
        c.ID as cid,c.Titel,c.Beschreibung,c.Kategorie,
        k.ID,k.Kategoriebezeichnung,c.Bild
         FROM content AS c, kategorie AS k
         WHERE c.Titel LIKE ?
         and c.Kategorie = k.ID
         ORDER by c.Titel ASC;");
    }
    $stmt->bind_param('s', $query);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}