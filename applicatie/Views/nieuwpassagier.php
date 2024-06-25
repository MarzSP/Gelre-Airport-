<?php require_once "../includes.php" ?>
<?php include "../db/passagiernummer.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/main.css">
    <title>GelreAirport</title>
</head>
<body>
<!-- Navigatie balk -->
<?php include '../Components/General/nav.php';?>

<main>
<!-- Pagina header(column1), en welkomst text(column2) -->
<?php include '../Components/General/header.php';?>


<section class="mainBoxLeft">
    <!-- Formulier: Nieuwe Passagier toevoegen -->
    <h2>Nieuwe Passagier toevoegen</h2>
    <form action="../Controllers/_nieuwpassagier.php" method="post">
        <p id="passagier-toegevoegd-bericht">
            <?php if (isset($_SESSION['passagierToegevoegdBericht'])) {
                echo '<p class="successmelding">' .  $_SESSION['passagierToegevoegdBericht'] . '</p>';
            }
            if (isset($_SESSION['foutmelding'])) {
                echo '<p class="foutmelding">' . $_SESSION['foutmelding'] . '</p>';
                unset($_SESSION['foutmelding']);
            } ?>
        </p>

        <label for="passagiernummer">Passagiernummer:</label>
        <?php
        try {
            $db = maakVerbinding();
            $passagiernummer = getNextPassagiernummer($db);
            echo '<input type="number" id="passagiernummer" name="passagiernummer" value="' . htmlspecialchars($passagiernummer, ENT_QUOTES, 'UTF-8') . '" readonly><br>';
        } catch (Exception $e) {
            echo '<input type="number" id="passagiernummer" name="passagiernummer" value="Error" readonly><br>';
            error_log("Fout bij het ophalen van passagiernummer: " . $e->getMessage());
        }
        ?>

        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required><br>

        <label for="vluchtnummer">Vluchtnummer:</label>
        <input type="text" id="vluchtnummer" name="vluchtnummer" required><br>

        <label for="geslacht">Geslacht:</label>
        <select id="geslacht" name="geslacht">
            <option value="M">Man</option>
            <option value="V">Vrouw</option>
            <option value="O">Anders</option>
        </select><br>

        <label for="stoel">Stoel:</label>
        <input type="text" id="stoel" name="stoel" required maxlength="3"><br>

        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" id="wachtwoord" name="wachtwoord" required><br>
        
        <input type="submit" value="Toevoegen">
    </form>
</section>
</main>

<!-- Footer onderaan pagina -->
<?php include '../Components/General/footer.php';?>
</body>
</html>
