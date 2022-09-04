<form action="search.example.php" method="GET">
    <input name="search" type="text" placeholder="Type here">
    <br>
    <input id="submit" type="submit" value="Search">
</form>
<?php
// Fehlermeldungen
isset($_GET['ms']) ? $message = $_GET['ms'] : $message = '';
if ($message !== '') {
    switch ($message) {
        case 'empty':
            echo '<p>Suche ist leer!</p>';
            break;
        case 'short':
            echo '<p>Mindestens 3 Zeichen eingeben!</p>';
            break;
    }
}
?>