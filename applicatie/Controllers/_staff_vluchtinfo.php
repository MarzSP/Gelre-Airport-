<?php
require_once '../DB/staff_zoektabel.php'; 

$db = maakVerbinding();
$vluchtnummer = "";
$flight_data = array();
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vluchtnummer'])) {
    $vluchtnummer = htmlspecialchars($_POST['vluchtnummer'], ENT_QUOTES, 'UTF-8');

    if (!$vluchtnummer || strlen($vluchtnummer) != 5 || !is_numeric($vluchtnummer)) {
        $error_message = "Ongeldig vluchtnummer.";
    } else {
        $flight_data = fetchFlightDataVluchtnummer($db, $vluchtnummer);
        if (empty($flight_data)) {
            $error_message = "Geen vlucht gevonden met nummer: " . htmlspecialchars($vluchtnummer, ENT_QUOTES, 'UTF-8');
        }
    }
}

if (!empty($error_message)) {
    echo "<span class='error-message'>$error_message</span>";
}

renderStaffZoekTabel($flight_data);

