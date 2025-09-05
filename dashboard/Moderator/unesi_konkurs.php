<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'student') {
    http_response_code(403);
    echo "Greška: Niste prijavljeni kao student.";
    exit;
}

$student_id = $_SESSION['povezani_id'] ?? null;

if (!$student_id) {
    http_response_code(400);
    echo "Greška: Nepoznat student.";
    exit;
}

$praksa_id = $_POST['praksa_id'] ?? null;
$dodatno = $_POST['dodatno'] ?? '';

if (!$praksa_id) {
    http_response_code(400);
    echo "Greška: Nedostaje ID prakse.";
    exit;
}

$provjera = $conn->prepare("SELECT COUNT(*) FROM konkursi WHERE student_id = ? AND praksa_id = ?");
$provjera->execute([$student_id, $praksa_id]);

// end of file
