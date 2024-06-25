<?php
session_start();
//Deze functie wordt gebruikt om te checken of een gebruiker is ingelogd of niet
function isLoggedIn()
{
    return isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
}


