<?php require_once "../includes.php" ?>

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
<?php require '../Controllers/_nieuwvlucht.php'; ?>
    <!-- Formulier: Nieuwe Vlucht toevoegen-->
    <h2>Nieuwe Vlucht Toevoegen</h2>

    <?php if (isset($_GET['succesmelding'])) { ?>
        <p class="successmelding">
            <?php echo htmlspecialchars(urldecode($_GET['succesmelding'])); ?>
        </p>
    <?php } ?>

    <?php if (isset($_GET['foutmelding'])) {  ?>
        <p class="foutmelding">
            <?php echo htmlspecialchars(urldecode($_GET['foutmelding'])); ?>
        </p>
    <?php } ?>

    <form method="POST" action="../Controllers/_nieuwvlucht.php" >
        <label for="vluchtnummer">Vluchtnummer:</label>
        <input type="number" id="vluchtnummer" name="vluchtnummer" minlength="5" maxlength="5" required><br>

<!-- Dropdown lijst van Bestemmingen -->
        <label for="bestemming">Bestemming:</label>
        <select id="bestemming" name="bestemming" required>
        <option value="">Selecteer bestemming</option>
        <?php foreach ($bestemmingen as $bestemming): ?>
        <option value="<?php echo htmlspecialchars($bestemming['bestemming'], ENT_QUOTES, 'UTF-8'); ?>">
        <?php echo htmlspecialchars($bestemming['bestemming'], ENT_QUOTES, 'UTF-8'); ?>
        </option>
         <?php endforeach; ?>
        </select>

        <label for="max_aantal">Maximaal aantal passagiers:</label>
        <input type="number" id="max_aantal" name="max_aantal" minlength="0" maxlength="999" required><br>

        <label for="max_gewicht_pp">Maximaal gewicht per persoon (kg):</label>
        <input type="number" step="0.1" id="max_gewicht_pp" name="max_gewicht_pp" minlength="0" maxlength="9999" required><br>

        <label for="max_totaalgewicht">Maximaal totaalgewicht (kg):</label>
        <input type="number" step="0.1" id="max_totaalgewicht" name="max_totaalgewicht" minlength="0" maxlength="99999" required><br>

        <label for="vertrektijd">Vertrektijd:</label>
        <input type="datetime-local" id="vertrektijd" name="vertrektijd" required><br>

<!-- Dropdown lijst van Maatschappijcodes -->
        <select id="maatschappijcode" name="maatschappijcode" required>
        <option value="">Selecteer maatschappij</option>
        <?php foreach ($maatschappijcodes as $maatschappijcode): ?>
            <option value="<?php echo htmlspecialchars($maatschappijcode['maatschappijcode'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($maatschappijcode['maatschappijcode'], ENT_QUOTES, 'UTF-8'); ?>
        </option>
        <?php endforeach; ?>
        </select>
        <button type="submit" name="submit">Vlucht toevoegen</button>
    </form>
</section>
</main>

<!-- Footer onderaan pagina -->
<?php include '../Components/General/footer.php';?>
</body>
</html>
