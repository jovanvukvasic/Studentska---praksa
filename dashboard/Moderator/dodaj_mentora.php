<?php
session_start();
require_once("../includes/db.php");

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'moderator') {
    echo "Niste autorizovani.";
	
    exit;
}
	$id_moderatora =$_SESSION['povezani_id'];




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $uloga_kompanije = $_POST['uloga_kompanije'];
    $email = $_POST['email'];
    $sifra = $_POST['sifra'];
    $telefon = $_POST['telefon'];
    $slika = ''; 

    try {
        $conn->beginTransaction();
        $stmt1 = $conn->prepare("INSERT INTO mentori (ime, prezime, uloga_kompanije, email, telefon, slika, id_moderatora)
                                 VALUES (:ime, :prezime, :uloga, :email, :telefon, :slika, :id_moderatora)");
        $stmt1->execute([
			'ime' => $ime,
			'prezime' => $prezime,
			'uloga' => $uloga_kompanije,
			'email' => $email,
			'telefon' => $telefon,
			'slika' => $slika,
			'id_moderatora' => $id_moderatora
		]);

        $mentor_id = $conn->lastInsertId();

        $stmt2 = $conn->prepare("INSERT INTO korisnici (email, sifra, uloga, povezani_id)
                                 VALUES (:email, :sifra, 'mentor', :povezani_id)");
        $stmt2->execute([
            'email' => $email,
            'sifra' => $sifra,
            'povezani_id' => $mentor_id
        ]);

        $conn->commit();
        $poruka = "Mentor je uspješno dodat.";
    } catch (Exception $e) {
        $conn->rollBack();
        $greska = "Greška: " . $e->getMessage();
    }
}
?>

<?php include("../includes/header.php"); ?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title mb-4 text-center">Dodavanje mentora</h4>
          <?php if (isset($poruka)): ?>
            <div class="alert alert-success"><?= $poruka; ?></div>
          <?php elseif (isset($greska)): ?>
            <div class="alert alert-danger"><?= $greska; ?></div>
          <?php endif; ?>
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Ime</label>
              <input type="text" name="ime" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Prezime</label>
              <input type="text" name="prezime" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Uloga u kompaniji</label>
              <input type="text" name="uloga_kompanije" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Lozinka</label>
              <input type="password" name="sifra" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Telefon</label>
              <input type="text" name="telefon" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100">Dodaj mentora</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php include("../includes/footer.php"); ?>
