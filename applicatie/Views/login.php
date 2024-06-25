<?php require_once "../includes.php" ?>
<?php require_once '../Controllers/login.php'; ?>

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

<!-- Pagina header(column1), en welkomst text(column2) -->
<?php include '../Components/General/header.php';?>

<main>
  <!-- Inlog box -->
<section class="inlog-sectie">
  <div class="inlog-formulier">
    <h2>Login</h2>

    <form method="post">
      <label for="gebruikersnaam">Gebruikersnaam:</label>
      <input type="text" id="gebruikersnaam" pattern="[a-zA-Z0-9]+" name="gebruikersnaam" required>
      <label for="wachtwoord">Wachtwoord:</label>
      <input type="password" id="wachtwoord" name="wachtwoord" required>
      <input class="button" type="submit" value="Inloggen" >
    </form>
  </div>
  <?php echo($html) ?>
</section>

<!-- Footer onderaan pagina -->
<?php include '../Components/General/footer.php';?>
</main>
</body>

</html>
