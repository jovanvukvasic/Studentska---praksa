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
    }
} else {
    $greska = "ID prakse nije prosleđen.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $praksa) {
    $dodatno = trim($_POST['dodatno'] ?? '');

    try {
        $stmt = $conn->prepare("INSERT INTO konkursi (praksa_id, student_id, dodatno, datum_prijave)
                                VALUES (:praksa_id, :student_id, :dodatno, NOW())");
        $stmt->execute([
            'praksa_id' => $praksa['id'],
            'student_id' => $student_id,
<?php include("../includes/footer.php"); ?>
