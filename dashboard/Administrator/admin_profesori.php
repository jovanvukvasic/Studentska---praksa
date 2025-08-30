<?php
include("../includes/db.php"); 

$query = "SELECT id, ime, prezime, zvanje, email, telefon FROM profesori";
$stmt = $conn->prepare($query);
$stmt->execute();

$profesori = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>🧑‍🏫 Lista profesora</h2>
  <a href="dodaj_profesora.php" class="btn btn-primary">➕ Dodaj profesora</a>
</div>

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Ime</th>
      <th>Prezime</th>
      <th>Zvanje</th>
      <th>Email</th>
      <th>Telefon</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($profesori as $prof): ?>
      <tr>
        <td><?= htmlspecialchars($prof['id']) ?></td>
        <td><?= htmlspecialchars($prof['ime']) ?></td>
        <td><?= htmlspecialchars($prof['prezime']) ?></td>
        <td><?= htmlspecialchars($prof['zvanje']) ?></td>
        <td><?= htmlspecialchars($prof['email']) ?></td>
        <td><?= htmlspecialchars($prof['telefon']) ?></td>
    <?php endforeach; ?>
  </tbody>
</table>
