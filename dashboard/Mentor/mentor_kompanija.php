<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'mentor') {
    echo "<div class='alert alert-danger'>Nemate pristup ovoj stranici.</div>";
    exit;
}

$mentor_id = $_SESSION['povezani_id'];

$query = $conn->prepare("
    SELECT k.naziv, k.adresa, k.kontakt_osoba
    FROM kompanije k
    JOIN moderatori mo ON k.moderator_id = mo.id
	JOIN mentori m ON m.id_moderatora = mo.id
    WHERE m.id = ?
");
$query->execute([$mentor_id]);
$kompanija = $query->fetch();

if (!$kompanija) {
    echo "<div class='alert alert-warning'>Nema informacija o kompaniji za ovog mentora.</div>";
    exit;
}
?>

<div class="container mt-4">
    <h4>🏢 Informacije o kompaniji</h4>
    <table class="table table-bordered mt-3">
        <tr>
            <td><?= htmlspecialchars($kompanija['kontakt_osoba']) ?></td>
        </tr>
    </table>
</div>
