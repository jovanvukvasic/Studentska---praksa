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
$broj = $provjera->fetchColumn();

if ($broj > 0) {
    echo "Već ste konkurisali na ovu praksu.";
    exit;
}

$insert = $conn->prepare("INSERT INTO konkursi (student_id, praksa_id, dodatno) VALUES (?, ?, ?)");
$uspjeh = $insert->execute([$student_id, $praksa_id, $dodatno]);

if ($uspjeh) {
    echo "Uspešno ste konkurisali na izabranu praksu.";
} else {
    http_response_code(500);

// end of file
