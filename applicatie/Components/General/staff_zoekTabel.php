<?php
// Dit is een functie die een zoektabel genereerd (renders). Deze wordt 3x keer gebruikt, voor zoeken op vertrektijd, luchthaven en vluchtnummer.
function renderStaffZoekTabel($flight_data)
{
    if (count($flight_data) > 0) {
        echo '<div id="flight_results">
            <h3>Vluchtgegevens</h3>
            <table>
                <thead>
                    <tr>
                        <th>Vluchtnummer</th>
                        <th>Vertrektijd</th>
                        <th>Maatschappij</th>
                        <th>Maatschappijcode</th>
                        <th>Luchthaven</th>
                        <th>Luchthavencode</th>
                        <th>Max. Aantal</th>
                        <th>Max. gewicht PP</th>
                        <th>Max. totaal gewicht</th>
                        <th>Gate</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($flight_data as $flight) {
            echo '<tr>
                <td>' . htmlspecialchars($flight['vluchtnummer'], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($flight['vertrektijd'], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($flight['naam'], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($flight['maatschappijcode'], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($flight['Lnaam'], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($flight['luchthavencode'], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($flight['max_aantal'], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($flight['max_gewicht_pp'], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . htmlspecialchars($flight['max_totaalgewicht'], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . $flight['gatecode'] . '</td>
            </tr>';
        }
        echo '</tbody></table></div>';
    } else {
        echo '<span class="error-message">Geen gegevens gevonden.</span>';
    }
}
