<?php
// Deze functie genereert (renders) een formulier voor het inchecken van een passagier en baggage gegevens. Deze kan zowel door passagiers gebruikt worden als medewerkers.
// Door $typeOfForm te gebruiken, wordt het formulier aangepas voor een medewerker of passagier.
function renderFormInCheck($typeOfForm)
{
    ?>
    <div class="extraBox">
        <h2>Inchecken</h2>
        <p>Check hier online in en voeg uw bagage gegevens toe.</p>
        <form id="inchecken-form" action="../Controllers/<?= $typeOfForm ?>.php" method="post">
            <label for="vluchtnummer">Vluchtnummer:</label>
            <input id="vluchtnummer" name="vluchtnummer" readonly required
                   value="<?= htmlspecialchars($_GET['vluchtnummer']) ?>">
            <br><br>
            <?php if ($typeOfForm === 'medewerker') { ?>
            <label for="passagiernummer">Passagiernummer:</label>
            <input id="passagiernummer" name="passagiernummer" required
                   value="">
            <br><br>
            <?php } ?>
            <label for="gewicht">Gewicht bagage:</label>
            <?php
            require_once '../DB/checkin.php';
            $data = getBaggageInfo($_GET['vluchtnummer']);
            for ($i = 0; $i < $data['objecten']; $i++) {
                ?>
                <input type="number" id="gewicht" name="gewicht[]" step="0.1" min="0" max="35"><br>
                <?php
            }
            ?><br>
            <button type="submit">Inchecken</button>
            <br>
        </form>

        <?php if (isset($_SESSION['foutmelding'])) { ?>
            <p class="foutmelding"><?= htmlspecialchars($_SESSION['foutmelding']);
                unset($_SESSION['foutmelding']); ?></p>
        <?php } elseif (isset($_SESSION['succesmelding'])) { ?>
            <p class="succesmelding"><?= htmlspecialchars($_SESSION['succesmelding']);
                unset($_SESSION['succesmelding']); ?></p>
        <?php } ?>
    </div>
    <?php
}
