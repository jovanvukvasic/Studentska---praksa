<?php
session_start();
include '../includes/db.php';

$profesor_id = 1; 
if ($profesor_id) {
    $query = $conn->prepare("SELECT ime, prezime, zvanje, email, telefon, slika FROM profesori WHERE id = ?");
    $query->execute([$profesor_id]);
    $profesor = $query->fetch();

    if ($profesor) {
        $slika = !empty($profesor['slika']) ? $profesor['slika'] : '../images/default-profile.png';
        ?>
        <div class="card shadow-sm p-4">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="<?= htmlspecialchars($slika) ?>" alt="Profilna slika" class="img-fluid rounded-circle mb-3" width="150">
                </div>
                <div class="col-md-9">
                    <h3><?= htmlspecialchars($profesor['ime'] . ' ' . $profesor['prezime']) ?></h3>
                    <p><strong>Zvanje:</strong> <?= htmlspecialchars($profesor['zvanje']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($profesor['email']) ?></p>
                    <p><strong>Telefon:</strong> <?= htmlspecialchars($profesor['telefon']) ?></p>
                    <a href="mailto:admin@univerzitet.ba?subject=Izmena profila profesora&body=Poštovani,%0A%0AŽelim da prijavim izmenu informacija u mom profilu..." class="btn btn-outline-danger mt-3">📧 Prijavi grešku</a>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<div class='alert alert-danger'>Nema podataka o profesoru.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>Profesor nije prijavljen.</div>";
?>
