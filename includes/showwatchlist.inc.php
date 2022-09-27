<?php
function showWatchlist($kategorie)
{
    $myid = htmlspecialchars($_GET['id']);
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT w.Content, c.Titel,c.Kategorie
    FROM watchlist as w
    JOIN content as c on c.ID = w.Content
    JOIN user as u on u.ID = w.User
    WHERE w.User=? and c.Kategorie=?;");
    $stmt->bind_param('ii', $myid, $kategorie);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows == 0) {
        echo 'Keine Content in der Watchlist!';
    } else {
        while ($item = $result->fetch_assoc()) {
            echo ' <div class="col-4 col-sm-2 text-center">
                        <a href="/content.php?id=' . $item["Content"] . '"><p>' . $item["Titel"] . '</p></a>
                    </div>';
        }
    }
}