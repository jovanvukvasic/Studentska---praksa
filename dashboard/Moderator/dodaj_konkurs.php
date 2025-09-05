<?php
session_start();
require_once("../includes/db.php");

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'student') {
    echo "Niste autorizovani.";
    exit;
}

$student_id = $_SESSION['povezani_id'];
$poruka = null;
$greska = null;

$praksa_id = $_GET['id'] ?? null;
$praksa = null;

if ($praksa_id) {
    try {
        $stmt = $conn->prepare("SELECT * FROM praksa WHERE id = :id");
        $stmt->execute(['id' => $praksa_id]);
        $praksa = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$praksa) {
            $greska = "Praksa nije pronađena.";
        }
    } catch (PDOException $e) {
        $greska = "Greška pri učitavanju prakse: " . $e->getMessage();
<?php include("../includes/footer.php"); ?>
