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


$stmt->execute([$id_moderatora]);
$mentori = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<h2>🧑‍🏫 Mentori koje ste unijeli</h2>

<?php if (count($mentori) > 0): ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Uloga u Kompaniji</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Slika</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mentori as $mentor): ?>
                <tr>
                    <td><?= htmlspecialchars($mentor['ime']); ?></td>
                    <td><?= htmlspecialchars($mentor['prezime']); ?></td>
                    <td><?= htmlspecialchars($mentor['uloga_kompanije']); ?></td>
                    <td><?= htmlspecialchars($mentor['email']); ?></td>
                    <td><?= htmlspecialchars($mentor['telefon']); ?></td>
                    <td><?= htmlspecialchars($mentor['slika']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
<?php endif; ?>
	<a href="dodaj_mentora.php" class="btn btn-primary mt-3">➕ Dodaj novog mentora</a>
