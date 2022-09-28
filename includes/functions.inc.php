<?php
if (!isset($_SESSION)) {
    session_start();
}
function searchErrorMs()
{
    isset($_GET['ms']) ? $message = $_GET['ms'] : $message = '';
    if ($message !== '') {
        switch ($message) {
            case 'searchempty':
                echo '<a class="text-decoration-none me-5 text-body">❌Suche ist leer!❌</a>';
                break;
            case 'searchshort':
                echo '<a class="text-decoration-none me-5 text-body">❌Mindestens 3 Zeichen eingeben!❌</a>';
                break;
            case 'error':
                echo '<a class="text-decoration-none me-5 text-body">❌Fehler im Bild!❌</a>';
                break;
            case 'size':
                echo '<a class="text-decoration-none me-5 text-body">❌Bild zu Groß!❌</a>';
                break;
            case 'format':
                echo '<a class="text-decoration-none me-5 text-body">❌Falsches Bild Format!❌</a>';
                break;
            case 'db':
                echo '<a class="text-decoration-none me-5 text-body">❌Datenbank Fehler!❌</a>';
                break;
            case 'taken':
                echo '<a class="text-decoration-none me-5 text-body">❌Titel existiert bereits!❌</a>';
                break;
            case 'empty':
                echo '<a class="text-decoration-none me-5 text-body">❌Titel Leer!❌</a>';
                break;
            case 'success':
                echo '<a class="text-decoration-none me-5 text-body">✅Erfolgreich!✅</a>';
                break;
            case 'sameid':
                echo '<a class="text-decoration-none me-5 text-body">❌Du Kannst dir selbst nicht Folgen!❌</a>';
                break;
            case 'alreadyfollowed':
                echo '<a class="text-decoration-none me-5 text-body">❌Du folgst dem User bereits!❌</a>';
                break;
            case 'alreadywatchlisted':
                echo '<a class="text-decoration-none me-5 text-body">❌Du hast den Content bereits in deiner Watchlist!❌</a>';
                break;
            case 'notsameuser':
                echo '<a class="text-decoration-none me-5 text-body">❌Das ist nicht dein User!❌</a>';
                break;
        }
    }
}