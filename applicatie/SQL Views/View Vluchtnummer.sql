-- view vluchtinfo voor medewerker op medewerker.php
CREATE VIEW vluchtnummer AS
SELECT
  v.vluchtnummer,
  v.max_aantal,
  v.max_gewicht_pp,
  v.max_totaalgewicht,
   CONCAT(
        CONVERT(VARCHAR(10), vertrektijd, 120), ' ',
        CAST(DATEPART(hour, vertrektijd) AS varchar(2)), ':',
        CAST(DATEPART(minute, vertrektijd) AS varchar(2)), ' ', ' '
    ) AS Vertrektijd,
  v.gatecode,
  m.naam,
  m.maatschappijcode,
  l.naam AS Lnaam,
  l.luchthavencode
FROM Vlucht v
JOIN Maatschappij m ON v.maatschappijcode = m.maatschappijcode
JOIN Luchthaven l ON v.bestemming = l.luchthavencode;
GO