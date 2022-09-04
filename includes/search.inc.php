<?php
function get_search_results($query)
{
    $query = "%" . $query . "%";
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT 
    c.ID,c.Titel,c.Beschreibung,c.Kategorie,
    k.ID,k.Kategoriebezeichnung
     FROM content AS c, kategorie AS k
     WHERE c.Titel LIKE ?
     and c.Kategorie = k.ID;");
    $stmt->bind_param('s', $query);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}