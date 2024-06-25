<?php

require_once '../includes.php';
require_once '../DB/checkin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vluchtnummer = htmlspecialchars($_POST['vluchtnummer'], ENT_QUOTES, 'UTF-8');
    $passagiernummer = htmlspecialchars($_POST['passagiernummer'], ENT_QUOTES, 'UTF-8');

    $gewichten = $_POST['gewicht'];

    foreach ($gewichten as $key => $gewicht) {
        $gewichten[$key] = floatval($gewicht);
    }


    // check if passagier is a passagier
    $vluchten = getPassagierBoekingen($passagiernummer);
    $foundVlucht = false;
    foreach($vluchten as $vlucht){
        if ($vlucht['vluchtnummer'] == $vluchtnummer) {
            $foundVlucht = true;
        }
    }

    if (!$foundVlucht) {
        $_SESSION['foutmelding'] = 'Mag niet';
    } else {
        checkIn($vluchtnummer, $passagiernummer, $gewichten);
    }

    header('Location: ../Views/staffcheckin.php?vluchtnummer=' . urlencode($vluchtnummer));
    exit;
}