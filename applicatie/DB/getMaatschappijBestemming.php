<?php
include 'db_connectie.php';

function getDestinations($db) {
$sql = "SELECT bestemming FROM Vlucht";
$stmt = $db->prepare($sql);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getMaatschappijCodes($db) {
$sql = "SELECT maatschappijcode FROM Maatschappij";
$stmt = $db->prepare($sql);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
