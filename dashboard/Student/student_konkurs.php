<?php
session_start();
include '../includes/db.php';

$student_id = $_SESSION['student_id'] ?? 1;
$praksa_id = $_POST['praksa_id'] ?? null;
$dodatno = trim($_POST['dodatno'] ?? '');

if (!$student_id || !$praksa_id) {
    echo "Nedostaju podaci.";
    exit;
}

$provera = $conn->prepare("SELECT 1 FROM konkursi WHERE student_id = ? AND praksa_id = ?");
$provera->execute([$student_id, $praksa_id]);
if ($provera->fetch()) {
    echo "Već ste konkurisali na ovu praksu.";
    exit;
}

$unos = $conn->prepare("INSERT INTO konkursi (student_id, praksa_id, dodatno) VALUES (?, ?, ?)");
$uspeh = $unos->execute([$student_id, $praksa_id, $dodatno]);

echo $uspeh ? "Uspešno ste konkurisali na praksu!" : "Greška prilikom konkurisanja.";

// end of file
