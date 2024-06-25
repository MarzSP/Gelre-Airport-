<?php
session_start();

// Unset alle sessie variabelen
session_unset();

// Destroy de sessie
session_destroy();

// Brengt je terug naar homepage
header("Location: ../index.php");

exit();

