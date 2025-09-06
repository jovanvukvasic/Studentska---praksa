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
<?php endif; ?>
