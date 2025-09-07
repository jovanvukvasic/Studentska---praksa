<?php


session_start();
require_once("../includes/db.php");

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'moderator') {
    echo "<p class='text-danger'>Nemate dozvolu za ovu akciju.</p>";
    exit;
}

$id_moderatora = $_SESSION['povezani_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $naziv = $_POST['naziv'] ?? '';
    $organizacija = $_POST['organizacija'] ?? '';
    $pocetak = $_POST['pocetak'] ?? '';
    $kraj = $_POST['kraj'] ?? '';

    if (empty($naziv) || empty($organizacija) || empty($pocetak) || empty($kraj)) {
        $greska = "Sva polja su obavezna.";
    } else {
        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare("SELECT id FROM kompanije WHERE moderator_id = ?");
            $stmt->execute([$id_moderatora]);
            $kompanija_id = $stmt->fetchColumn();

            if (!$kompanija_id) {
                throw new Exception("Kompanija nije pronađena.");
<?php include("../includes/footer.php"); ?>
