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
<?php include("../includes/footer.php"); ?>
