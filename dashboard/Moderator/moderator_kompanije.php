<?php
session_start();
require_once("../includes/db.php");

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'moderator') {
    echo "Niste autorizovani.";
    exit;
}

$ime = $_SESSION['ime'];
$prezime = $_SESSION['prezime'];
$kontakt_osoba = "$ime $prezime";

$sql = "SELECT * FROM kompanije WHERE kontakt_osoba = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$kontakt_osoba]);
$kompanije = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>🏢 Moje kompanije</h2>

<?php if (count($kompanije) > 0): ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Naziv</th>
                <th>Adresa</th>
                <th>Kontakt osoba</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($kompanije as $kompanija): ?>
                <tr>
                    <td><?= htmlspecialchars($kompanija['naziv']); ?></td>
                    <td><?= htmlspecialchars($kompanija['adresa']); ?></td>
                    <td><?= htmlspecialchars($kompanija['kontakt_osoba']); ?></td>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
<?php endif; ?>
