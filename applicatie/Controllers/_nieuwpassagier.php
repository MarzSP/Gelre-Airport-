<?php
/* Code is veilig gemaakt door middel van: Filter_input, santize input, prepared statements, htmlspecialchars ren PDO::data-type */
require_once '../includes.php';
include '../DB/nieuw_passagier.php';
include '../DB/passagiernummer.php';
include '../DB/checkin.php';

redirectIfNotLoggedin();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passagiernummer = htmlspecialchars($_POST['passagiernummer'], ENT_QUOTES, 'UTF-8');
    $naam = htmlspecialchars($_POST['naam'], ENT_QUOTES, 'UTF-8');
    $vluchtnummer = htmlspecialchars($_POST['vluchtnummer'], ENT_QUOTES, 'UTF-8');
    $geslacht = htmlspecialchars($_POST['geslacht'], ENT_QUOTES, 'UTF-8');
    $wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);
    $stoel = htmlspecialchars($_POST['stoel'], ENT_QUOTES, 'UTF-8');

    if (valideerPassagierInvoer($passagiernummer, $naam, $vluchtnummer, $geslacht, $wachtwoord, $stoel)) {
        if (checkIfStoelBestaat($vluchtnummer, $stoel)) {
            $_SESSION['foutmelding'] = 'stoel '.$stoel.' Deze stoel is an bezet. ';
            header('Location: ../Views/nieuwpassagier.php');
        } else if (checkIfVolleVlucht($vluchtnummer)) {
            $_SESSION['foutmelding'] = 'Deze vlucht is al volgeboekt';
            header('Location: ../Views/nieuwpassagier.php');
        } else if (checkIfGewichtVlucht($vluchtnummer)) {
            $_SESSION['foutmelding'] = 'Deze vlucht is te zwaar als dit bagageobject wordt ingechecked.';
            header('Location: ../Views/nieuwpassagier.php');
        } else if (slaPassagierOp($passagiernummer, $naam, $vluchtnummer, $geslacht, $wachtwoord, $stoel)) {
            $succesBericht = "Passagier succesvol toegevoegd met nummer: " . $passagiernummer;
            $_SESSION['passagierToegevoegdBericht'] = $succesBericht;
            header('Location: ../Views/nieuwpassagier.php');
        } else {
            header('Location: ../Views/nieuwpassagier.php');
        }
    }
}