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
      <input type="text" class="form-control" id="zvanje" name="zvanje" value="<?=htmlspecialchars($old['zvanje'] ?? '')?>" required>
    </div>
    <div class="mb-3">
      <label for="telefon" class="form-label">Telefon</label>
      <input type="text" class="form-control" id="telefon" name="telefon" value="<?=htmlspecialchars($old['telefon'] ?? '')?>" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="<?=htmlspecialchars($old['email'] ?? '')?>" required>
    </div>
    <div class="mb-3">
      <label for="sifra" class="form-label">Šifra</label>
      <input type="password" class="form-control" id="sifra" name="sifra" required>
    </div>
    <button type="submit" class="btn btn-success">Sačuvaj</button>
    <a href="admin.php" class="btn btn-secondary">Nazad</a>
  </form>
</div>

<?php include("../includes/footer.php"); ?>
