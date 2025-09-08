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
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
</head>
<body class="p-4">
    <h2>📄 Studenti koji su se prijavili na praksu</h2>

    <?php if (count($prijave) > 0): ?>
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-secondary">
                <tr>
                    <th>Ime i prezime</th>
                    <th>Email</th>
                    <th>Datum prijave</th>
                    <th>Status</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prijave as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['ime'] . ' ' . $p['prezime']); ?></td>
                        <td><?= htmlspecialchars($p['email']); ?></td>
                        <td><?= date('d.m.Y', strtotime($p['datum_prijave'])); ?></td>
                        <td>
                            <?php
                                $status = $p['status'] ?? 'na čekanju';
                                $badge = 'secondary';
                                if ($status === 'prihvaćen') $badge = 'success';
                                elseif ($status === 'odbijen') $badge = 'danger';
                            ?>
                            <span class="badge bg-<?= $badge ?>"><?= ucfirst($status); ?></span>
                        </td>
                        <td>
                            <?php if ($status === 'na čekanju'): ?>
                                <form method="post" class="d-flex gap-2 flex-wrap">
                                    <input type="hidden" name="student_id" value="<?= $p['student_id']; ?>">
                                    
                                    <select name="mentor_id" class="form-select form-select-sm w-auto" required>
                                        <option value="">👤 Odaberi mentora</option>
                                        <?php foreach ($mentori as $m): ?>
                                            <option value="<?= $m['id']; ?>">
                                                <?= htmlspecialchars($m['ime'] . ' ' . $m['prezime']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <button type="submit" name="akcija" value="prihvati" class="btn btn-sm btn-success">✅ Prihvati</button>
                                    <button type="submit" name="akcija" value="odbij" class="btn btn-sm btn-danger">❌ Odbij</button>
                                </form>
                            <?php else: ?>
                                <em>Akcija zaključana</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Još uvijek nema prijava za ovu praksu.</p>
    <?php endif; ?>

    <a href="moderator.php" class="btn btn-secondary mt-3">⬅ Nazad na konkurs listu</a>
</body>
</html>
