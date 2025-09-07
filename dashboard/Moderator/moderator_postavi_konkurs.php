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
<?php endif; ?>

<a href="postavi_konkurs.php" class="btn btn-primary mt-3">➕ Dodaj novu praksu</a>
