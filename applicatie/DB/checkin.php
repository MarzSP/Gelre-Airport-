<?php
require_once '../includes.php';

function getPassagierBoekingen($login)
{
    $db = maakVerbinding();

    $sql = "SELECT
        vertrektijd,
        vluchtnummer,
        luchthaven_naam,
        land,
        maatschappij_naam,
        gatecode,
        Incheck_balie
    FROM boeking_passagier
    WHERE passagiernummer = ?
    AND vertrektijd > GETDATE()";

    $result = $db->prepare($sql);
    $result->bindValue(1, $login);
    $result->execute();

    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function getBaggageInfo($vluchtnummer)
{
    $db = maakVerbinding();

    $sql = 'SELECT TOP (1) max_objecten_pp as objecten, max_gewicht_pp as pp
        FROM Vlucht v
        join Maatschappij m on v.maatschappijcode = m.maatschappijcode
        where v.vluchtnummer = ?';

    $result = $db->prepare($sql);
    $result->bindValue(1, $vluchtnummer, PDO::PARAM_INT);
    $result->execute();

    return $result->fetch(PDO::FETCH_ASSOC);
}

function addBaggage($passagiernummer, $key, $gewicht)
{
    $db = maakVerbinding();

    $sql = 'INSERT INTO BagageObject (passagiernummer, objectvolgnummer, gewicht) VALUES (?, ?, ?)';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $passagiernummer, PDO::PARAM_STR);
    $stmt->bindValue(2, $key, PDO::PARAM_INT);
    $stmt->bindValue(3, $gewicht, PDO::PARAM_STR);

    return $stmt->execute();
}

function updateInchecktijdstip($passagiernummer)
{
    $db = maakVerbinding();


    $sql = 'UPDATE Passagier SET Inchecktijdstip = GETDATE() WHERE passagiernummer = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $passagiernummer);

    return $stmt->execute();
}


function checkin($vluchtnummer, $passagiernummer, $gewichten)
{
    $data = getBaggageInfo($vluchtnummer);
    $maxObjecten = $data['objecten'];
    $maxGewicht = $data['pp'];

    $totaalGewicht = array_sum($gewichten);

     if ($totaalGewicht > $maxGewicht) {
        $_SESSION['foutmelding'] = "Het totale gewicht overschrijdt het limiet van $maxGewicht kg.";
    } elseif (count($gewichten) > $maxObjecten) {
        $_SESSION['foutmelding'] = "Het aantal objecten overschrijdt het limiet van $maxObjecten.";
    } else if (checkIfVolleVlucht($vluchtnummer)) {
         $_SESSION['foutmelding'] = 'Vlucht is al volgeboekt';
     } else if (checkIfGewichtVlucht($vluchtnummer)) {
         $_SESSION['foutmelding'] = 'Vlucht is te zwaar';
     } else  {
        foreach ($gewichten as $key => $gewicht) {
            if ($gewicht >= 0) {
                try {
                    addBaggage($passagiernummer, $key, $gewicht);
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        $_SESSION['foutmelding'] = "Passagier $passagiernummer is reeds ingecheckt voor vluchtnummer: $vluchtnummer.";
                    } else {
                        throw $e;
                    }
                }
            }
        }

        updateInchecktijdstip($passagiernummer);

        $_SESSION['succesmelding'] = "U bent ingecheckt!";
    }


}

function checkIfVolleVlucht($vluchtnummer) {
    $sql = "
SELECT
    p.vluchtnummer,
    COUNT(stoel) AS aantal_stoelen,
    v.max_aantal
FROM Passagier p
         JOIN Vlucht V on V.vluchtnummer = p.vluchtnummer
where p.vluchtnummer = ?
GROUP BY
    p.vluchtnummer,
    V.max_aantal
";
    $db = maakVerbinding();

    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $vluchtnummer, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $aantal_stoelen = $result[0]['aantal_stoelen'];
    $max_aantal = $result[0]['max_aantal'];
    if ($aantal_stoelen > $max_aantal) {
        return true;
    }
    return false;
}
function checkIfGewichtVlucht($vluchtnummer) {
    $sql = "
select sum(bo.gewicht) as huidiggewicht, v.vluchtnummer, v.max_totaalgewicht
from Vlucht v
	join Passagier p on p.vluchtnummer = v.vluchtnummer
	join BagageObject bo on p.passagiernummer = bo.passagiernummer
where v.vluchtnummer = ?
group by v.vluchtnummer,v.max_totaalgewicht ";
    $db = maakVerbinding();

    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $vluchtnummer, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $huidigGewicht = $result[0]['huidiggewicht'];
    $maxGewicht = $result[0]['max_totaalgewicht'];
    if ($huidigGewicht > $maxGewicht) {
        return true;
    }
    return false;
}