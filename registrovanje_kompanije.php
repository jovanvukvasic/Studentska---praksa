<?php
include("includes/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naziv = $_POST['naziv'];
    $adresa = $_POST['adresa'];
    $kontakt_ime = $_POST['kontakt_ime'];
    $kontakt_prezime = $_POST['kontakt_prezime'];
    $email = $_POST['email'];
    $sifra = $_POST['sifra'];
    $telefon = $_POST['telefon'];

    try {
        $conn->beginTransaction();
<?php include("includes/footer.php"); ?>
