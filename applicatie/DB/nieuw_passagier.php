<?php

// Functie om passagiergegevens te valideren
function valideerPassagierInvoer($passagiernummer, $naam, $vluchtnummer, $geslacht, $wachtwoord, $stoel) {
    $geldig = true;
    $foutmeldingen = [];

    if (!is_numeric($passagiernummer) || $passagiernummer <= 0) {
        $geldig = false;
        $foutmeldingen[] = "Ongeldig passagiernummer";
    }

    if (empty($naam)) {
        $geldig = false;
        $foutmeldingen[] = "Naamveld mag niet leeg zijn";
    }
    if (empty($vluchtnummer)) {
        $geldig = false;
        $foutmeldingen[] = "Vluchtnummer mag niet leeg zijn";
    }

    if (empty($geslacht)) {
        $geldig = false;
        $foutmeldingen[] = "Vul een geslacht in.";
    }
    if (empty($wachtwoord)) {
        $geldig = false;
        $foutmeldingen[] = "Wachtwoord mag niet leeg zijn";
    }

    if (empty($stoel)) {
        $geldig = false;
        $foutmeldingen[] = "Stoel mag niet leeg zijn";
    }
    if (strlen($stoel) > 3) {
        $geldig = false;
        $foutmeldingen[] = "Stoel mag niet langer dan 3 chars zijn";
    }

    if ($geldig) {
        return true;
    } else {
        return $foutmeldingen;
    }
}

// Passagiersgegevens opslaan met gebruik van prepared SQL statements tegen SQL-injection (A03:2021)
function slaPassagierOp($passagiernummer, $naam, $vluchtnummer, $geslacht, $wachtwoord, $stoel) {
    $db = maakVerbinding();

    $sql = "INSERT INTO Passagier (passagiernummer, naam, vluchtnummer, geslacht, wachtwoord, stoel)
          VALUES (:passagiernummer, :naam, :vluchtnummer, :geslacht, :wachtwoord, :stoel)";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':passagiernummer', $passagiernummer, PDO::PARAM_INT);
    $stmt->bindParam(':naam', $naam,PDO::PARAM_STR);
    $stmt->bindParam(':vluchtnummer', $vluchtnummer, PDO::PARAM_INT);
    $stmt->bindParam(':geslacht', $geslacht, PDO::PARAM_STR);
    $stmt->bindParam(':wachtwoord', $wachtwoord, PDO::PARAM_STR);
    $stmt->bindParam(':stoel', $stoel);

    try {
        return $stmt->execute();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $_SESSION['foutmelding'] = "Passagier $passagiernummer is reeds toegevoegd voor vluchtnummer: $vluchtnummer.";
            return false;
        } else {
            throw $e;
        }
    }
}

function checkIfStoelBestaat($vluchtnummer, $stoel) {
    $db = maakVerbinding();

    $sql = "SELECT vluchtnummer FROM Passagier where stoel = :stoel and vluchtnummer = :vluchtnummer";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':stoel', $stoel, PDO::PARAM_STR);
    $stmt->bindParam(':vluchtnummer', $vluchtnummer, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return count($result) > 0;
}