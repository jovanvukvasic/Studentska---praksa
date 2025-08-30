<?php
require '../includes/db.php';

$poruka = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naziv = trim($_POST['naziv']);

    if (!empty($naziv)) {
        $provjera = $conn->prepare("SELECT COUNT(*) FROM komisije_profesori WHERE komisija = ?");
        $provjera->execute([$naziv]);
        $postoji = $provjera->fetchColumn();

        if ($postoji == 0) {
            $insert = $conn->prepare("INSERT INTO komisije_profesori (komisija, profesor_id) VALUES (?, NULL)");
            if ($insert->execute([$naziv])) {
                header("Location: admin_komisije.php");
                exit;
            } else {
                $poruka = "Greška pri unosu u bazu.";
            }
        } else {
            $poruka = "Komisija sa tim nazivom već postoji.";
        }
    } else {
        $poruka = "Naziv komisije ne smije biti prazan.";
    }
}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Dodaj komisiju</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container">
        <h2>Dodaj novu komisiju</h2>

        <?php if ($poruka): ?>
            <div class="alert alert-warning"><?= htmlspecialchars($poruka) ?></div>
        <?php endif; ?>

        <form method="post" class="mt-3">
            <div class="mb-3">
                <label for="naziv" class="form-label">Naziv komisije</label>
                <input type="text" name="naziv" id="naziv" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Dodaj</button>
            <a href="admin_komisije.php" class="btn btn-secondary">Nazad</a>
        </form>
    </div>
</body>
</html>
