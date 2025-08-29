<?php
session_start();
include("includes/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['username'];
    $lozinka = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM korisnici WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $korisnik = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($korisnik) {
        if (password_verify($lozinka, $korisnik['sifra'])) {
		   if ($lozinka === $korisnik['sifra']) {
<?php include("includes/footer.php"); ?>
