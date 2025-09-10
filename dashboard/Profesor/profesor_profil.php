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
?>
