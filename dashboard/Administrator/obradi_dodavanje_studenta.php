<?php
session_start();
if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'admin') {
  header("Location: ../index.php");
  exit;
}

include("../includes/db.php");

$ime        = trim($_POST['ime'] ?? '');
$prezime    = trim($_POST['prezime'] ?? '');
$indeks     = trim($_POST['indeks'] ?? '');
$fakultet   = trim($_POST['fakultet'] ?? '');
$smjer      = trim($_POST['smjer'] ?? '');
$usmjerenje = trim($_POST['usmjerenje'] ?? '');
$prosjek    = trim($_POST['prosjek'] ?? '');
$email      = trim($_POST['email'] ?? '');
$sifra      = $_POST['sifra'] ?? '';

$errors = [];
$old = compact('ime', 'prezime', 'indeks', 'fakultet', 'smjer', 'usmjerenje', 'prosjek', 'email');

if ($ime === '') $errors[] = "Ime je obavezno.";
if ($prezime === '') $errors[] = "Prezime je obavezno.";
if ($indeks === '') $errors[] = "Indeks je obavezan.";
if ($fakultet === '') $errors[] = "Fakultet je obavezan.";
if ($smjer === '') $errors[] = "Smjer je obavezan.";
if ($usmjerenje === '') $errors[] = "Usmjerenje je obavezno.";
if ($prosjek === '' || !is_numeric($prosjek) || $prosjek < 0 || $prosjek > 10) $errors[] = "Prosjek mora biti broj od 0 do 10.";
if ($email === '') $errors[] = "Email je obavezan.";

// end of file
