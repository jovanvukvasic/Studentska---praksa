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

// end of file
