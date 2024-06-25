<?php
require_once '../includes.php';
require_once '../DB/data_user.php';


$error = '';
$html = '';
if (isset($_POST['gebruikersnaam']) && isset($_POST['wachtwoord'])) {
    $login = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    $gebruikersId = (int)$login;
    if ($gebruikersId == 0) {
        print "invalid";
        exit();
    }

    // Haal user_data uit de rol van een gebruiker.
    $user = getMedewerker($login) ?? getPassagier($login);
    $rol = loginUser($user, $wachtwoord);

    switch($rol) {
        case false:
            $error = "Ongeldige gebruikersnaam of wachtwoord"; // Ongeldig inlog meuk
            break;
        case 'medewerker':
            header("Location: medewerker.php"); // Breng de gebruiker naar de correcte pagina
            exit();
        case 'passagier':
            header("Location: passagier.php"); // Breng de gebruiker naar de correcte pagina
            exit();
        default:
            $error = "Onbekende gebruikersrol: " . $rol; // Wat er gebeurt als er een geen rol is gevonden.
    }

    if (!empty($error)) {
        $html = "<p>Error: " . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</p>";
    }
}
echo $html;


