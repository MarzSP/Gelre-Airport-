<?php require_once "../includes.php"; ?>
<?php redirectIfNotLoggedin(); ?>

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
<?php include '../Components/General/nav.php';
include '../Components/General/formIncheck.php';
include '../Components/General/vluchtinformatie.php';
?>

<main>
    <!-- Pagina Passagier: Als er boekingen zijn worden deze displayed, als niet, dan staat er alleen dat er geen boekingen zijn. -->
    <?php include '../Components/General/header.php'; ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Controller voert de GET uit. Hierna wordt deze ook gesanitized om te voorkomen dat er schadelijke script/code op kan worden uitgevoerd.
    } else if (isset($_GET['vluchtnummer'])) {
        $vluchtnummer = htmlspecialchars($_GET['vluchtnummer'], ENT_QUOTES, 'UTF-8');
        renderFormInCheck("passagier");
    } else { ?>
        <div class="extraBox">
            <?php
            include '../DB/checkin.php';
            $data = getPassagierBoekingen(htmlspecialchars($_SESSION['gebruikersnaam'], ENT_QUOTES, 'UTF-8'));
            ?>
            <h2>Mijn Boekingen</h2>
            <p>Bekijk hier uw aankomende boekingen. Klik op het vluchtnummer om in te checken!</p>
            <?php
            if (count($data)) {
                renderVluchtInformatieTabel($data, '/Views/passagier.php?vluchtnummer='); // In Components/vluchtinformatie.php -> modulair herbruikbare html
            } else { ?>
                <p>U heeft momenteel geen aankomende vluchten.</p>
            <?php } ?>
        </div>
    <?php } ?>

    <?php include '../Components/General/footer.php'; ?>
</main>
</body>
</html>
