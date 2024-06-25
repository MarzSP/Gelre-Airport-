<?php
require_once '../DB/staff_zoektabel.php'; 

$db = maakVerbinding();
$vertrektijd = "";
$flight_data = array();
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vertrektijd'])) {
    $vertrektijd = htmlspecialchars($_POST['vertrektijd'], ENT_QUOTES, 'UTF-8');
    $format = "Y-m-d"; // Format voor alleen datum
    $dateObject = DateTime::createFromFormat($format, substr($vertrektijd, 0, 10)); // haal alleen datum er uit

    if ($dateObject === false) {
        $error_message = "Vertrektijd is ongeldig.";
    } else {
        $order = isset($_POST['order']) ? strtoupper($_POST['order']) : 'ASC';
        $flight_data = fetchFlightDataVertrektijd($db, $dateObject, $order);

        if (empty($flight_data)) {
            $error_message = "Geen vluchten gevonden voor datum: " . htmlspecialchars($dateObject->format('Y-m-d'), ENT_QUOTES, 'UTF-8');
        }
    }
}

renderStaffZoekTabel($flight_data);