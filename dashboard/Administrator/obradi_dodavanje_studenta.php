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
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email nije validan.";
if ($sifra === '') $errors[] = "Šifra je obavezna.";


try {
    $conn->beginTransaction();

    $hashSifra = password_hash($sifra, PASSWORD_DEFAULT);

    $query = "INSERT INTO studenti (ime, prezime, indeks, fakultet, smjer, usmjerenje, prosjek, email, sifra) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$ime, $prezime, $indeks, $fakultet, $smjer, $usmjerenje, $prosjek, $email, $hashSifra]);

    $query2 = "INSERT INTO korisnici (email, sifra, uloga) VALUES (?, ?, 'student')";
    $stmt2 = $conn->prepare($query2);
    $stmt2->execute([$email, $hashSifra]);

    $conn->commit();

    header("Location: admin_studenti.php");
    exit;
} catch (PDOException $e) {
    $conn->rollBack();
    $_SESSION['errors'] = ["Greška u bazi podataka: " . $e->getMessage()];
    $_SESSION['old'] = $old;
    header("Location: dodaj_studenta.php");
    exit;
}

// end of file
