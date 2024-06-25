-- view boeking_info voor passagier.php
CREATE VIEW boeking_passagier AS
SELECT
Passagier.passagiernummer,
    CONCAT(
        CONVERT(VARCHAR(10), vertrektijd, 120), ' ',
        CAST(DATEPART(hour, vertrektijd) AS varchar(2)), ':',
        CAST(DATEPART(minute, vertrektijd) AS varchar(2)), ' ', ' '
    ) AS Vertrektijd,
    Vlucht.vluchtnummer,
    Luchthaven.naam AS luchthaven_naam,
    Luchthaven.land,
    Maatschappij.naam AS maatschappij_naam,
    Vlucht.gatecode,
    IncheckenMaatschappij.balienummer AS Incheck_balie
FROM Vlucht
JOIN Passagier ON Vlucht.Vluchtnummer = Passagier.vluchtnummer
JOIN Luchthaven ON Vlucht.bestemming = Luchthaven.luchthavencode
JOIN Maatschappij ON Vlucht.maatschappijcode = Maatschappij.maatschappijcode
JOIN Gate ON Vlucht.gatecode = Gate.gatecode
JOIN IncheckenMaatschappij ON Maatschappij.maatschappijcode = IncheckenMaatschappij.maatschappijcode;

go