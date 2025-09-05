<?php
session_start();
require_once("../includes/db.php");

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'student') {
    echo "Niste autorizovani.";
    exit;
}

$student_id = $_SESSION['povezani_id'];
$poruka = null;
$greska = null;

$praksa_id = $_GET['id'] ?? null;
$praksa = null;

if ($praksa_id) {
    try {
        $stmt = $conn->prepare("SELECT * FROM praksa WHERE id = :id");
        $stmt->execute(['id' => $praksa_id]);
        $praksa = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$praksa) {
            $greska = "Praksa nije pronađena.";
        }
    } catch (PDOException $e) {
        $greska = "Greška pri učitavanju prakse: " . $e->getMessage();
    }
} else {
    $greska = "ID prakse nije prosleđen.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $praksa) {
    $dodatno = trim($_POST['dodatno'] ?? '');

    try {
        $stmt = $conn->prepare("INSERT INTO konkursi (praksa_id, student_id, dodatno, datum_prijave)
                                VALUES (:praksa_id, :student_id, :dodatno, NOW())");
        $stmt->execute([
            'praksa_id' => $praksa['id'],
            'student_id' => $student_id,
            'dodatno' => $dodatno
        ]);
        $poruka = "✅ Uspješno ste se prijavili na praksu: <strong>" . htmlspecialchars($praksa['naziv']) . "</strong>.";
    } catch (PDOException $e) {
        $greska = "Greška pri prijavi: " . $e->getMessage();
    }
}
?>

<?php include("../includes/header.php"); ?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title mb-4 text-center">Prijava na praksu</h4>

          <?php if ($poruka): ?>
            <div class="alert alert-success"><?= $poruka; ?></div>
          <?php elseif ($greska): ?>
            <div class="alert alert-danger"><?= $greska; ?></div>
          <?php endif; ?>

          <?php if ($praksa && !$poruka): ?>
            <h5><strong>Praksa:</strong> <?= htmlspecialchars($praksa['naziv']); ?></h5>
            <p><strong>Opis:</strong> <?= nl2br(htmlspecialchars($praksa['organizacija'])); ?></p>

            <form method="POST">
              <div class="mb-3">
                <label class="form-label">Dodatne informacije</label>
                <textarea name="dodatno" class="form-control" rows="4" placeholder="(opcionalno)"></textarea>
              </div>
              <button type="submit" class="btn btn-primary w-100">Potvrdi konkurisanje</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("../includes/footer.php"); ?>
