<?php
// Deze functie wordt gebruikt voor de controller _nieuwvlucht.php die wordt aangeroepen vanuit de view nieuwvlucht.php - voor een medewerker die een vlucht toevoegd.
function insertVlucht($vluchtnummer, $bestemming, $max_aantal, $max_gewicht_pp, $max_totaalgewicht, $dateTimeObject, $maatschappijcode) {
    $db = maakVerbinding();
        $sql = "INSERT INTO Vlucht (vluchtnummer, bestemming, max_aantal, max_gewicht_pp, max_totaalgewicht, vertrektijd, maatschappijcode)
                VALUES (:vluchtnummer, :bestemming, :maxAntal, :maxGewichtPP, :maxTotaalGewicht, :vertrektijd, :maatschappijcode)";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':vluchtnummer', $vluchtnummer, PDO::PARAM_INT);
        $stmt->bindParam(':bestemming', $bestemming);
        $stmt->bindParam(':maxAntal', $max_aantal, PDO::PARAM_INT);
        $stmt->bindParam(':maxGewichtPP', $max_gewicht_pp, PDO::PARAM_INT);
        $stmt->bindParam(':maxTotaalGewicht', $max_totaalgewicht, PDO::PARAM_INT);
        $stmt->bindParam(':vertrektijd', $dateTimeObject);
        $stmt->bindParam(':maatschappijcode', $maatschappijcode);

    try {
        $stmt->execute();
        header('Location: ../Views/nieuwvlucht.php?succesmelding=Vlucht+succesvol+toegevoegd.');
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header('Location: ../Views/nieuwvlucht.php?foutmelding=Vluchtnummer al in gebruik. Kies een ander vluchtnummer.');
        } else {
            header('Location: ../Views/nieuwvlucht.php?foutmelding=Vlucht+kon+niet+worden+toegevoegd.');
            throw $e;
        }
    }
}