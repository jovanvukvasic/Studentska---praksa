<?php
include '../includes/db.php';

$student_id = $_POST['student_id'];
$mentor_id = $_POST['mentor_id'];
$datum = $_POST['datum'];
$komentar = $_POST['komentar'];

$sql_check = "SELECT id FROM komentari_mentora WHERE student_id = ? AND mentor_id = ? AND datum = ?";
$stmt = $conn->prepare($sql_check);
$stmt->execute([$student_id, $mentor_id, $datum]);

if ($stmt->fetch()) {
    $sql_update = "UPDATE komentari_mentora SET komentar = ? WHERE student_id = ? AND mentor_id = ? AND datum = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->execute([$komentar, $student_id, $mentor_id, $datum]);
} else {
    $sql_insert = "INSERT INTO komentari_mentora (student_id, mentor_id, datum, komentar) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->execute([$student_id, $mentor_id, $datum, $komentar]);
}

header("Location: mentor_uvid.php?id=$student_id&fokus_dan=$datum");
exit;

// end of file
