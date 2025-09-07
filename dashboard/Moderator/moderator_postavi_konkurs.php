<?php
session_start();
require_once("../includes/db.php");

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'moderator') {
    echo "Niste autorizovani.";
    exit;
}

$korisnik_id = $_SESSION['korisnik_id'];

$stmt = $conn->prepare("SELECT povezani_id FROM korisnici WHERE id = ? AND uloga = 'moderator'");
$stmt->execute([$korisnik_id]);
$id_moderatora = $stmt->fetchColumn();

if (!$id_moderatora) {
    echo "Greška: Moderator nije pronađen.";
    exit;
}

$sql = "SELECT * FROM praksa WHERE kompanija_id = ? ORDER BY pocetak DESC"; 
$stmt = $conn->prepare($sql);
$stmt->execute([$id_moderatora]);
$prakse = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>📢 Konkursi za praksu koje ste objavili</h2>

<?php if (count($prakse) > 0): ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Naziv prakse</th>
                <th>Organizacija</th>
                <th>Početak prakse</th>
                <th>Kraj prakse</th>
                <th>Datum objave</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prakse as $praksa): ?>
                <tr>
                    <td><?= htmlspecialchars($praksa['naziv']); ?></td>
                    <td><?= htmlspecialchars($praksa['organizacija']); ?></td>
                    <td><?= htmlspecialchars($praksa['pocetak']); ?></td>
                    <td><?= htmlspecialchars($praksa['kraj']); ?></td>
                    <td><?= htmlspecialchars($praksa['datum_objave'] ?? 'Nepoznato'); ?></td>
                    <td>
                        <a href="uredi_praksu.php?id=<?= $praksa['id']; ?>" class="btn btn-sm btn-warning">Uredi</a>
                        <a href="prijave.php?id=<?= $praksa['id']; ?>" class="btn btn-sm btn-warning">Prijave</a>
                        <a href="obrisi_praksu.php?id=<?= $praksa['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni da želite obrisati ovu praksu?')">Obriši</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Niste još objavili nijednu praksu.</p>
<?php endif; ?>

<a href="postavi_konkurs.php" class="btn btn-primary mt-3">➕ Dodaj novu praksu</a>
