<?php

function getVluchtInformatie($zoekVluchtNummer) {
    $db = maakVerbinding();

//Gebruik de view vluchtinfo in DB
    $sql = "SELECT vertrektijd,
vluchtnummer,
luchthaven_naam,
land,
maatschappij_naam,
gatecode,
Incheck_balie FROM vluchtinfo
where vertrektijd > GETDATE()
";

// Query als er een zoekterm is ingevoerd
    if ($zoekVluchtNummer) {
        $sql .= " AND vluchtnummer LIKE :zoekVluchtnummer";
    }
    $result = $db->prepare($sql);

    if ($zoekVluchtNummer) {
        $result->bindValue(':zoekVluchtnummer', '%' . $zoekVluchtNummer . '%');
    }

    $result->execute();
    $data = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) { // Variabele $result uit view - lus doorloopt de result rij voor rij
        $data[] = $row;
    }

    return $data;
}