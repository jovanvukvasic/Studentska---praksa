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
  <h2>➕ Dodaj studenta</h2>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" action="obradi_dodavanje_studenta.php">
    <div class="mb-3">
      <label for="ime" class="form-label">Ime</label>
      <input type="text" class="form-control" id="ime" name="ime" value="<?= htmlspecialchars($old['ime'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
      <label for="prezime" class="form-label">Prezime</label>
      <input type="text" class="form-control" id="prezime" name="prezime" value="<?= htmlspecialchars($old['prezime'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
      <label for="indeks" class="form-label">Indeks</label>
      <input type="text" class="form-control" id="indeks" name="indeks" value="<?= htmlspecialchars($old['indeks'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
      <label for="fakultet" class="form-label">Fakultet</label>
      <input type="text" class="form-control" id="fakultet" name="fakultet" value="<?= htmlspecialchars($old['fakultet'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
      <label for="smjer" class="form-label">Smjer</label>
      <input type="text" class="form-control" id="smjer" name="smjer" value="<?= htmlspecialchars($old['smjer'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
      <label for="usmjerenje" class="form-label">Usmjerenje</label>
      <input type="text" class="form-control" id="usmjerenje" name="usmjerenje" value="<?= htmlspecialchars($old['usmjerenje'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
      <label for="prosjek" class="form-label">Prosjek</label>
      <input type="number" step="0.01" min="0" max="10" class="form-control" id="prosjek" name="prosjek" value="<?= htmlspecialchars($old['prosjek'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
      <label for="sifra" class="form-label">Šifra</label>
      <input type="password" class="form-control" id="sifra" name="sifra" required>
    </div>

    <button type="submit" class="btn btn-success">Sačuvaj</button>
    <a href="admin_studenti.php" class="btn btn-secondary">Nazad</a>
  </form>
</div>

<?php include("../includes/footer.php"); ?>
