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
        }
    }
}