<?php
session_start();
include '../includes/db.php';

$mentor_id = $_SESSION['povezani_id'] ?? 0;
$student_id = $_GET['id'] ?? 0;
$fokus_dan = $_GET['fokus_dan'] ?? null;

$sql = "SELECT p.id, p.naziv, p.pocetak, p.kraj 
        FROM praksa p
        JOIN konkursi k ON k.praksa_id = p.id 
        WHERE k.student_id = ? AND k.status = 'prihvaćen'";
$stmt = $conn->prepare($sql);
$stmt->execute([$student_id]);
$praksa = $stmt->fetch();

if (!$praksa) {
    echo "<div class='alert alert-warning'>Student nije prijavljen na prihvaćenu praksu.</div>";
    exit;
}

$stmt2->execute([$student_id, $praksa['pocetak'], $praksa['kraj']]);
$aktivnosti = [];
while ($row = $stmt2->fetch()) {
    $aktivnosti[$row['datum']] = $row['opis'];
}

$sql_kom = "SELECT datum, komentar FROM komentari_mentora 
            WHERE student_id = ? AND mentor_id = ?";
$stmt3 = $conn->prepare($sql_kom);
$stmt3->execute([$student_id, $mentor_id]);
$komentari = [];
while ($row = $stmt3->fetch()) {
    $komentari[$row['datum']] = $row['komentar'];
}

$pocetak = new DateTime($praksa['pocetak']);
$kraj = new DateTime($praksa['kraj']);
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($pocetak, $interval, $kraj->modify('+1 day'));
?>

<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Uvid u rad studenta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <div class="mb-4">
    <h4 class="fw-bold">🗓️ Praksa: <?= htmlspecialchars($praksa['naziv']) ?> (<?= $praksa['pocetak'] ?> – <?= $praksa['kraj'] ?>)</h4>
    <a href="mentor.php" class="btn btn-secondary mt-2">⬅️ Nazad</a>
  </div>

<?php 
$brojacDana = 1;
$fokus_prikazan = false;
$ostaliDani = [];

foreach ($period as $dan) {
    $datum = $dan->format('Y-m-d');
    $opis = $aktivnosti[$datum] ?? null;
$komentar = $komentari[$datum] ?? '';

    if ($datum === $fokus_dan && !$fokus_prikazan) {
        $fokus_prikazan = true;
?>
<div class="card border-primary mb-4 shadow">
  <div class="card-header bg-primary text-white fw-bold">
    Fokusirani dan: <?= $dan->format('l, d.m.Y') ?> (Dan <?= $brojacDana ?>)
  </div>
  <div class="card-body">
    <p><strong>Aktivnost studenta:</strong><br>
  <?= $opis ? htmlspecialchars($opis) : '<span class="text-muted fst-italic">Nema unosa</span>' ?>
</p>

    <form method="POST" action="snimi_komentar_mentor.php">
      <input type="hidden" name="student_id" value="<?= $student_id ?>">
      <input type="hidden" name="mentor_id" value="<?= $mentor_id ?>">
      <input type="hidden" name="datum" value="<?= $datum ?>">
      <div class="mb-3">
        <label class="form-label">📝 Vaš komentar:</label>
        <textarea name="komentar" class="form-control" rows="4"><?= htmlspecialchars($komentar) ?></textarea>
      </div>
      <button type="submit" class="btn btn-success">💾 Sačuvaj komentar</button>
    </form>
  </div>
</div>
<?php
    } else {
        $ostaliDani[] = [
            'dan' => $brojacDana,
            'datum' => $datum,
            'opis' => $opis,
            'komentar' => $komentar,
        ];
    }

    $brojacDana++;
}
?>

<h5 class="mt-4">📋 Ostali dani prakse</h5>
<div class="table-responsive">
  <table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Datum</th>
        <th>Aktivnost</th>
        <th>Komentar mentora</th>
        <th>Akcija</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($ostaliDani as $dan): ?>
      <tr>
        <td><?= $dan['dan'] ?></td>
        <td><?= date('d.m.Y', strtotime($dan['datum'])) ?></td>
        <td>
  <?= $dan['opis'] ? htmlspecialchars($dan['opis']) : '<span class="text-muted fst-italic">Nema unosa</span>' ?>
</td>
        <td><?= htmlspecialchars($dan['komentar']) ?: '<span class="text-muted fst-italic">Bez komentara</span>' ?></td>
        <td>
          <a href="?id=<?= $student_id ?>&fokus_dan=<?= $dan['datum'] ?>" class="btn btn-outline-primary btn-sm">
            📝 Uredi komentar
          </a>
		  <a href="mailto:student<?= $student_id ?>@example.com" class="btn btn-outline-info ms-2">📧</a>

        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

</html>
<?php
$zadnji_dan_prakse = clone $kraj;
$zadnji_dan_prakse->modify('-1 day');

if ($today > $zadnji_dan_prakse): ?>
  <div class="text-center mt-4">
    <a href="izvještaj_mentora.php?student_id=<?= $student_id ?>" class="btn btn-lg btn-primary">
      ✅ Pošalji izvještaj profesoru
    </a>
  </div>
<?php else: ?>
  <div class="text-center mt-4">
    <button class="btn btn-lg btn-secondary" disabled title="Izvještaj je moguće poslati nakon što student završi praksu">
      ⏳ Izvještaj je moguće poslati nakon što student završi praksu...
    </button>
  </div>
<?php endif; ?>
