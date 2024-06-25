-- view vluchtinfo voor passagier op index.php
CREATE VIEW vluchtinfo AS
SELECT
    CONCAT(
        CONVERT(VARCHAR(10), vertrektijd, 120), ' ',
        RIGHT('0' + CAST(DATEPART(hour, vertrektijd) AS VARCHAR), 2), ':',
        RIGHT('0' + CAST(DATEPART(minute, vertrektijd) AS VARCHAR), 2)
    ) AS Vertrektijd,
    Vlucht.vluchtnummer,
    Luchthaven.naam AS luchthaven_naam,
    Luchthaven.land,
    Maatschappij.naam AS maatschappij_naam,
    Vlucht.gatecode,
    IncheckenMaatschappij.balienummer AS Incheck_balie
FROM Vlucht
JOIN Luchthaven ON Vlucht.bestemming = Luchthaven.luchthavencode
JOIN Maatschappij ON Vlucht.maatschappijcode = Maatschappij.maatschappijcode
JOIN Gate ON Vlucht.gatecode = Gate.gatecode
JOIN IncheckenMaatschappij ON Maatschappij.maatschappijcode = IncheckenMaatschappij.maatschappijcode;
GO