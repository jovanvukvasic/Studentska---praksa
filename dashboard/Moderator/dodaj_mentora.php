<?php
session_start();
require_once("../includes/db.php");

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'moderator') {
    echo "Niste autorizovani.";
	
    exit;
}
	$id_moderatora =$_SESSION['povezani_id'];




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $uloga_kompanije = $_POST['uloga_kompanije'];
    $email = $_POST['email'];
    $sifra = $_POST['sifra'];
    $telefon = $_POST['telefon'];
    $slika = ''; 

    try {
        $conn->beginTransaction();
        $stmt1 = $conn->prepare("INSERT INTO mentori (ime, prezime, uloga_kompanije, email, telefon, slika, id_moderatora)
                                 VALUES (:ime, :prezime, :uloga, :email, :telefon, :slika, :id_moderatora)");
        $stmt1->execute([
			'ime' => $ime,
			'prezime' => $prezime,
			'uloga' => $uloga_kompanije,
			'email' => $email,
			'telefon' => $telefon,
<?php include("../includes/footer.php"); ?>
