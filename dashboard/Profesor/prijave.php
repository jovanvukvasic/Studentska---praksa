<?php
session_start();
require_once("../includes/db.php");

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'moderator') {
    echo "Niste autorizovani.";
    exit;
}

$korisnik_id = $_SESSION['korisnik_id'];
$praksa_id = $_GET['id'] ?? null;

if (!$praksa_id || !is_numeric($praksa_id)) {
    echo "Neispravan ID prakse.";
    exit;
}

$stmt = $conn->prepare("SELECT povezani_id FROM korisnici WHERE id = ?");
$stmt->execute([$korisnik_id]);
$id_moderatora = $stmt->fetchColumn();

if (!$id_moderatora) {
    echo "Greška: Moderator nije pronađen.";
    exit;
}

$stmt->execute([$id_moderatora]);
$mentori = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("
    SELECT s.id AS student_id, s.ime, s.prezime, s.email, k.datum_prijave, k.status, k.mentor_id
    FROM konkursi k
    JOIN studenti s ON k.student_id = s.id
    WHERE k.praksa_id = ?
    ORDER BY k.datum_prijave DESC
");
$stmt->execute([$praksa_id]);
$prijave = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['akcija'], $_POST['student_id'])) {
        $akcija = $_POST['akcija'];
        $student_id = $_POST['student_id'];

        if ($akcija === 'prihvati' && isset($_POST['mentor_id'])) {
            $mentor_id = $_POST['mentor_id'];
            $update = $conn->prepare("UPDATE konkursi SET status = 'prihvaćen', mentor_id = ? WHERE praksa_id = ? AND student_id = ?");
            $update->execute([$mentor_id, $praksa_id, $student_id]);
        } elseif ($akcija === 'odbij') {
            $update = $conn->prepare("UPDATE konkursi SET status = 'odbijen' WHERE praksa_id = ? AND student_id = ?");
            $update->execute([$praksa_id, $student_id]);
        }

        header("Location: prijave.php?id=$praksa_id");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Prijave na praksu</title>
</html>
