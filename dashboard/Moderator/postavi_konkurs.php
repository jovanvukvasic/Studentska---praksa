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
            }

            $stmt2 = $conn->prepare("INSERT INTO praksa (naziv, organizacija, pocetak, kraj, kompanija_id)
                                     VALUES (:naziv, :organizacija, :pocetak, :kraj, :kompanija_id)");
            $stmt2->execute([
                'naziv' => $naziv,
                'organizacija' => $organizacija,
                'pocetak' => $pocetak,
                'kraj' => $kraj,
                'kompanija_id' => $kompanija_id
            ]);

            $conn->commit();
            $poruka = "Konkurs za praksu je uspješno objavljen.";
        } catch (Exception $e) {
            $conn->rollBack();
            $greska = "Greška pri unosu: " . $e->getMessage();
        }
    }
}
?>

<?php include("../includes/header.php"); ?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title mb-4 text-center">Objavi novi konkurs za praksu</h4>
          <?php if (isset($poruka)): ?>
            <div class="alert alert-success"><?= $poruka; ?></div>
<?php include("../includes/footer.php"); ?>
