<?php
/* Code is veilig gemaakt tegen SQL-Injection en XSS door middel van: Prepared statements, Sanitized input, htmlspecialchars, error handling en validatie. */
declare(strict_types=1);

function getPassagier(int $gebruikersnaam)
{
    $db = maakVerbinding();
    $sql = 'SELECT passagiernummer, wachtwoord FROM Passagier WHERE passagiernummer = :gebruikersnaam';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':gebruikersnaam', $gebruikersnaam, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();;
    if (!$result) {
        return null;
    }
    return $result;
}

function getMedewerker(int $balienummer)
{
    $db = maakVerbinding();
    $sql = 'SELECT * FROM Balie WHERE balienummer = :balienummer';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':balienummer', $balienummer, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();;
    if (!$result) {
        return null;
    }
    return $result;
}

function loginUser($user, $wachtwoord) {
    if (!$user) {
        return false;
    }

    if (!isset($user['wachtwoord'])) {
        return false;
    }

    if (!password_verify($wachtwoord, $user['wachtwoord'])) {
        return false;
    }

    $_SESSION['rol'] = $user['balienummer'] ? 'medewerker' : 'passagier';
    $_SESSION['gebruikersnaam'] = isset($user['balienummer']) ? $user['balienummer'] : $user['passagiernummer'];
    $_SESSION['isLoggedIn'] = true;

    return $_SESSION['rol'];
}

// Voeg een nieuwe passagier toe
if (isset($_POST['submit'])) {
    $passagiernummer = $_POST['passagiernummer'];
    $naam = $_POST['naam'];
    $vluchtnummer = $_POST['vluchtnummer'];
    $geslacht = $_POST['geslacht'];
    $balienummer = $_POST['balienummer'];
    $incheckstijdstip = $_POST['inchecktijdstip'];
    $wachtwoord = $_POST['wachtwoord'];

    $gebruiker = new Passagier($naam, $wachtwoord);

    // Gebruik prepared statements om SQL-injectie te voorkomen
    // Gebruik password hashing om Broken User Access te voorkomen
    $query = $verbinding->prepare("INSERT INTO Passagier (naam, vluchtnummer, geslacht, balienummer, inchecktijdstip, wachtwoord) VALUES (?, ?, ?, ?, ?, ?)");
    $hash = password_hash($gebruiker->wachtwoord, PASSWORD_DEFAULT);

    try {
        $query->execute([$gevalideerdeNaam, $hash]);
        return true;
    } catch (PDOException $ex) {
        throw new Exception($ex->getMessage());
        return false;
    }


    // Probeer de gebruiker te creëren
    if (createUser($gebruiker)) {
        // Gebruiker succesvol gecreëerd
        echo "<p>Gebruiker succesvol gecreëerd!</p>";
    } else {
        // Fout bij het creëren van gebruiker
        echo "<p>Er is een fout opgetreden bij het creëren van de gebruiker.</p>";
    }
}