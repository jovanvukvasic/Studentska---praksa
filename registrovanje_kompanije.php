<?php
include("includes/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naziv = $_POST['naziv'];
    $adresa = $_POST['adresa'];
    $kontakt_ime = $_POST['kontakt_ime'];
    $kontakt_prezime = $_POST['kontakt_prezime'];
    $email = $_POST['email'];
    $sifra = $_POST['sifra'];
    $telefon = $_POST['telefon'];

    try {
        $conn->beginTransaction();

        $kontakt_osoba = $kontakt_ime . ' ' . $kontakt_prezime;
        $stmt1 = $conn->prepare("INSERT INTO kompanije (naziv, adresa, kontakt_osoba) VALUES (:naziv, :adresa, :kontakt_osoba)");
        $stmt1->execute([
            'naziv' => $naziv,
            'adresa' => $adresa,
            'kontakt_osoba' => $kontakt_osoba
        ]);

        $st2 = $conn->prepare("INSERT INTO moderatori (ime, prezime, email, sifra, telefon) VALUES (:ime, :prezime, :email, :sifra, :telefon)");
        $stmt2->execute([
            'ime' => $kontakt_ime,
            'prezime' => $kontakt_prezime,
            'email' => $email,
            'sifra' => $sifra,
            'telefon' => $telefon
        ]);
        $moderator_id = $conn->lastInsertId();

        $stmt3 = $conn->prepare("INSERT INTO korisnici (email, sifra, uloga, povezani_id) VALUES (:email, :sifra, 'moderator', :povezani_id)");
        $stmt3->execute([
            'email' => $email,
            'sifra' => $sifra,
            'povezani_id' => $moderator_id
        ]);

        $conn->commit();
        $poruka = "Registracija uspješna.";
    } catch (Exception $e) {
        $conn->rollBack();
        $greska = "Greška prilikom registracije: " . $e->getMessage();
    }
}
?>

<?php include("includes/header.php"); ?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title mb-4 text-center">Registracija kompanije</h4>
          <?php if (isset($poruka)): ?>
            <div class="alert alert-success"><?php echo $poruka; ?></div>
          <?php elseif (isset($greska)): ?>
            <div class="alert alert-danger"><?php echo $greska; ?></div>
          <?php endif; ?>
          <form method="POST" action="registrovanje_kompanije.php">
            <div class="mb-3">
              <label class="form-label">Naziv kompanije</label>
              <input type="text" name="naziv" class="form-control" required>
            </div>
<?php include("includes/footer.php"); ?>
