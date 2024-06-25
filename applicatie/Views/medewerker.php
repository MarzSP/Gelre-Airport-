<?php require_once "../includes.php" ?>
<?php redirectIfNotLoggedin() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link rel="stylesheet" href="../Styles/main.css">
    <title>GelreAirport</title>
</head>


<body><main>
<!-- Navigatie balk -->
<?php include '../Components/General/nav.php';?>

<!-- Pagina header(column1), en welkomst text(column2) -->

<?php include '../Components/General/header.php';?>



  <!-- Vlucht gegevens ophalen op vluchtnummer formulier -->
  <section class="extraBox">
        <h3>Vluchtgegevens Ophalen: Vluchtnummer</h3>
        <form method="post">
            <label for="vluchtnummer">Vluchtnummer:</label>
            <input type="text" id="vluchtnummer" name="vluchtnummer" required>
            <span class="error-message"></span>
            <br>
            <button type="submit">Zoek Vlucht</button>
            <?php include '../Controllers/_staff_vluchtinfo.php'; ?>
        </form>
      </section> 

<!-- Vlucht gegevens ophalen op Luchthaven formulier -->
      <section class="extraBox">
    <h3>Vluchtgegevens Ophalen: Luchthaven</h3>
    <form method="post" >
        <label for="luchthaven">Luchthavennaam:</label>
        <input type="text" id="luchthaven" name="luchthaven" required>
        <span class="error-message"></span>
        <br>
        <button type="submit">Zoek op luchthaven</button>
        <?php include '../Controllers/_staff_zoekluchthaven.php'; ?>
    </form>

      </section>

<!-- Vlucht gegevens ophalen op Vertrektijd formulier -->
    <section class="extraBox">
    <h3>Vluchtgegevens Ophalen: Datum & sorteer op tijd</h3>
    <form method="post">
    <label for="vertrektijd">Vertrektijd:</label>
        <input type="date" id="vertrektijd" name="vertrektijd" required><br> 

        <label for="order">Sorteer op:</label>
        <select id="order" name="order">
            <option value="ASC">Oplopend (ASC)</option>
            <option value="DESC">Aflopend (DESC)</option>
        </select><br>


        <button type="submit">Zoeken op Datum & Tijd </button>
    </form>
    <?php include '../Controllers/_staff_zoekdatum.php'; ?> 
</section>


</main>
</body>
<!-- Footer onderaan pagina -->
<?php include '../Components/General/footer.php';?>

</html>
