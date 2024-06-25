<?php
// Hebruikbare Code: De tabel die de vluchtinfo op de index.php geeft, dient ook als de basis voor de tabel waarin de passagier kan zien welke boekingen deze wel of niet heeft.
// Bij passagier.php heeft deze de input parameter $redirect (regel 83) en bij index.php NULL. Vanuit Passagier is dit dus een klikbare link om in te kunnen checken.
function renderVluchtInformatieTabel($data, $redirect)
{
    ?>
    <!-- Tabel in linker container met de actuele vlucht informatie uit de View -->
    <div class="vlucht-tabel-container">
    <table>
        <thead>
        <tr>
            <th>Tijd</th>
            <th>Vluchtnummer</th>
            <th>Bestemming</th>
            <th>Land</th>
            <th>Maatschappij</th>
            <th>Gate</th>
            <th>Incheck_balie</th>
        </tr>
        </thead>
        <tbody><?php
        foreach ($data as $row) { ?>
            <tr>
                <td><?= htmlspecialchars($row['vertrektijd'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <?php if ($redirect) echo '<a href='.$redirect . $row['vluchtnummer'].'>'; ?>
                    <?= htmlspecialchars($row['vluchtnummer'], ENT_QUOTES, 'UTF-8') ?>
                    <?php if ($redirect) echo '</a>'; ?>
                </td>
                <td><?= htmlspecialchars($row['luchthaven_naam'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['land'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['maatschappij_naam'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['gatecode'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['Incheck_balie'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

    </div> <!-- -->
    <?php
}