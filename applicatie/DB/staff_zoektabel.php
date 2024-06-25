<?php
require_once '../Components/General/staff_zoekTabel.php';

$db = maakVerbinding();

function fetchFlightDataVluchtnummer($db, $vluchtnummer)
{
    $sql = 'SELECT vluchtnummer, Lnaam, max_aantal, max_gewicht_pp, max_totaalgewicht, vertrektijd, gatecode, naam, maatschappijcode, luchthavencode FROM vluchtnummer WHERE vluchtnummer = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $vluchtnummer, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchFlightDataLuchthaven($db, $luchthaven) {
    $sql = 'SELECT vluchtnummer, max_aantal, max_gewicht_pp, max_totaalgewicht, vertrektijd, gatecode, naam, maatschappijcode, Lnaam, luchthavencode FROM vluchtnummer WHERE Lnaam = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $luchthaven, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchFlightDataVertrektijd($db, $dateObject, $order = 'ASC') {
    $order = strtoupper($order);
    if ($order !== 'ASC' && $order !== 'DESC') {
        $order = 'ASC';
    }

    // Format datum
    $dateString = $dateObject->format('Y-m-d');


    $sql = 'SELECT vluchtnummer, max_aantal, max_gewicht_pp, max_totaalgewicht, vertrektijd, gatecode, naam, maatschappijcode, Lnaam, luchthavencode 
            FROM vluchtnummer 
            WHERE CONVERT(date, vertrektijd) = :date
            ORDER BY vertrektijd ' . $order;

    $stmt = $db->prepare($sql);

    // Bind bind format datum aan string parameter
    $stmt->bindParam(':date', $dateString, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}