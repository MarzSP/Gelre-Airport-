<?php
require_once '../includes.php';
require_once '../DB/staff_zoektabel.php'; 

$db = maakVerbinding();
$luchthaven = "";
$flight_data = array();
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['luchthaven'])) {
    $luchthaven = htmlspecialchars($_POST['luchthaven'], ENT_QUOTES, 'UTF-8');

    if (empty($luchthaven)) {
        $error_message = "Luchthaven is ongeldig.";
    } else {
        $flight_data = fetchFlightDataLuchthaven($db, $luchthaven);
        if (empty($flight_data)) {
            $error_message = "Geen luchthaven gevonden met naam: " . htmlspecialchars($luchthaven, ENT_QUOTES, 'UTF-8');
        }
    }
}

if (!empty($error_message)) {
    echo "<span class='foutmelding'>$error_message</span>";
}

renderStaffZoekTabel($flight_data);

