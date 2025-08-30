<?php
session_start();
if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'admin') {
  header("Location: ../index.php");
  exit;
}

include("../includes/header.php");
include("../includes/db.php"); 

$stmt = $conn->prepare("SELECT id, ime, prezime, indeks, fakultet, smjer, usmjerenje, prosjek, email FROM studenti ORDER BY prezime, ime");
$stmt->execute();
$studenti = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
  <h2>🧑‍🎓 Lista studenata</h2>

  <div class="mb-3">
    <a href="dodaj_studenta.php" class="btn btn-success">➕ Dodaj studenta</a>
    <button id="importButton" class="btn btn-primary">📁 Uvezi studente iz fajla (CSV)</button>
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Ime</th>
        <th>Prezime</th>
        <th>Indeks</th>
        <th>Fakultet</th>
        <th>Smjer</th>
        <th>Usmjerenje</th>
        <th>Prosjek</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($studenti as $student): ?>
        <tr>
          <td><?= htmlspecialchars($student['id']) ?></td>
          <td><?= htmlspecialchars($student['ime']) ?></td>
          <td><?= htmlspecialchars($student['prezime']) ?></td>
          <td><?= htmlspecialchars($student['indeks']) ?></td>
          <td><?= htmlspecialchars($student['fakultet']) ?></td>
          <td><?= htmlspecialchars($student['smjer']) ?></td>
          <td><?= htmlspecialchars($student['usmjerenje']) ?></td>
          <td><?= htmlspecialchars($student['prosjek']) ?></td>
          <td><?= htmlspecialchars($student['email']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  document.getElementById('importButton').addEventListener('click', () => {
    alert('Opcija uvoza studenata iz fajla biće implementirana kasnije.');
  });
</script>

<?php include("../includes/footer.php"); ?>
