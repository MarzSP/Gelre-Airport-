<?php
require_once '../includes.php';
require_once '../DB/checkin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $vluchtnummer = htmlspecialchars($_POST['vluchtnummer'], ENT_QUOTES, 'UTF-8');

    $gewichten = $_POST['gewicht'];
    $passagiernummer = $_SESSION['gebruikersnaam'];

    foreach ($gewichten as $key => $gewicht) {
        $gewichten[$key] = floatval($gewicht);
    }

    checkIn($vluchtnummer, $passagiernummer, $gewichten);

    header('Location: ../Views/passagier.php?vluchtnummer=' . urlencode($vluchtnummer));
    exit;
}
