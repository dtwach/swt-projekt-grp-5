<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
// Verbindung zur Datenbank
$con = mysqli_connect('localhost', 'root', '', 'swt_crp');
// sollte die Verbindung nicht funktionieren, dann wird eine Fehlermeldung ausgegeben
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}