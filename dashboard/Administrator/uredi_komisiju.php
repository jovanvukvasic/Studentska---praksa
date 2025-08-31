<?php
require '../includes/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Nije specificirana komisija.");
}

$naziv_komisije = $_GET['id'];
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $izabrani_profesori = $_POST['profesori'] ?? [];

    try {
        $delQuery = "DELETE FROM komisije_profesori WHERE komisija = ?";
        $delStmt = $conn->prepare($delQuery);
        $delStmt->execute([$naziv_komisije]);

        if (!empty($izabrani_profesori)) {
            $insQuery = "INSERT INTO komisije_profesori (komisija, profesor_id) VALUES (?, ?)";
            $insStmt = $conn->prepare($insQuery);

            foreach ($izabrani_profesori as $prof_id) {
                $insStmt->execute([$naziv_komisije, $prof_id]);
            }
        }

        $msg = "Članovi komisije su uspješno ažurirani.";
    } catch (PDOException $e) {
        $msg = "Greška: " . $e->getMessage();
    }
}

$profQuery = "SELECT id, ime, prezime FROM profesori";
$profStmt = $conn->prepare($profQuery);
$profStmt->execute();
$profesori = $profStmt->fetchAll(PDO::FETCH_ASSOC);

$trenutniQuery = "SELECT profesor_id FROM komisije_profesori WHERE komisija = ?";
$trenutniStmt = $conn->prepare($trenutniQuery);
$trenutniStmt->execute([$naziv_komisije]);
$trenutniClanovi = $trenutniStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Uredi komisiju</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container">
        <h2>Uredi komisiju: <?= htmlspecialchars(ucfirst($naziv_komisije)) ?></h2>

        <?php if ($msg): ?>
            <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Izaberite profesore:</label>
</html>
