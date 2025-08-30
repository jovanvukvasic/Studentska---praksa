<?php
session_start();
if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'admin') {
  header("Location: ../index.php");
  exit;
}

include("../includes/header.php");

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);
?>

<div class="container mt-5">
  <h2>➕ Dodaj profesora</h2>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?=htmlspecialchars($error)?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" action="obradi_dodavanje_profesora.php">
    <div class="mb-3">
      <label for="ime" class="form-label">Ime</label>
      <input type="text" class="form-control" id="ime" name="ime" value="<?=htmlspecialchars($old['ime'] ?? '')?>" required>
    </div>
    <div class="mb-3">
      <label for="prezime" class="form-label">Prezime</label>
      <input type="text" class="form-control" id="prezime" name="prezime" value="<?=htmlspecialchars($old['prezime'] ?? '')?>" required>
    </div>
    <div class="mb-3">
      <label for="zvanje" class="form-label">Zvanje</label>
<?php include("../includes/footer.php"); ?>
