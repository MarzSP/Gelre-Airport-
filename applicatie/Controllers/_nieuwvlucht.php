<?php
require_once '../includes.php';
include '../DB/nieuw_vlucht.php';



if (isset($_POST['submit'])) {
    $db=maakVerbinding();
    $vluchtnummer = htmlspecialchars($_POST['vluchtnummer'], ENT_QUOTES, 'UTF-8');
    $bestemming = htmlspecialchars($_POST['bestemming'], ENT_QUOTES, 'UTF-8');
    $max_aantal = htmlspecialchars($_POST['max_aantal'], ENT_QUOTES, 'UTF-8');
    $max_gewicht_pp = htmlspecialchars($_POST['max_gewicht_pp'], ENT_QUOTES, 'UTF-8');
    $max_totaalgewicht = htmlspecialchars($_POST['max_totaalgewicht'], ENT_QUOTES, 'UTF-8');
    $vertrektijd = $_POST['vertrektijd'];
    $maatschappijcode = htmlspecialchars($_POST['maatschappijcode'], ENT_QUOTES, 'UTF-8');


    $format = "Y-M-D H:i:s.u"; // Format in DB
    $dateTimeObject = DateTime::createFromFormat($format, $vertrektijd);

    $vluchtnummer = intval($vluchtnummer);
    $max_aantal = intval($max_aantal);
    $max_gewicht_pp = floatval($max_gewicht_pp);
    $max_totaalgewicht = floatval($max_totaalgewicht);

    if ($max_aantal < 0 || $max_aantal > 999) {
        header('Location: ../Views/nieuwvlucht.php?foutmelding=Maximaal aantal passagiers moet tussen 0 en 999 liggen.');
        exit;
    }
    insertVlucht($vluchtnummer, $bestemming, $max_aantal, $max_gewicht_pp, $max_totaalgewicht, $dateTimeObject, $maatschappijcode);
}




try {
    $data = maakVerbinding();
    $data->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
// Functie voor dropdownlijst bestemmingen
    function getDestinations($db) {
      $sql = "SELECT bestemming FROM Vlucht";
      $stmt = $db->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  
// Functie voor dropdownlijst voor maatschappijcoed
    function getMaatschappijCodes($db) {
      $sql = "SELECT maatschappijcode FROM Maatschappij";
      $stmt = $db->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  
    // Roep functies aan en sla resultaten op
    $bestemmingen = getDestinations($data);
    $maatschappijcodes = getMaatschappijCodes($data);
  } catch(PDOException $e) {
    echo "Error fetching options: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    $bestemmingen = [];
    $maatschappijcodes = [];
  }
