<?php
include '../includes/db.php';

$kompanija_id = $_GET['id'] ?? 1;

if ($kompanija_id) {
    $query = $conn->prepare("SELECT * FROM kompanije WHERE id = ?");
    $query->execute([$kompanija_id]);
    $kompanija = $query->fetch();

    if ($kompanija):
?>
<div class="container mt-4">
    <h4>📄 Detalji o kompaniji</h4>
    <div class="card p-4">
        <h5><?= htmlspecialchars($kompanija['naziv']) ?></h5>
        <p><strong>Adresa:</strong> <?= htmlspecialchars($kompanija['adresa']) ?></p>
        <p><strong>Kontakt osoba:</strong> <?= htmlspecialchars($kompanija['kontakt_osoba']) ?></p>
        <a href="profesor_kompanije.php" class="btn btn-secondary mt-3">⬅ Nazad</a>
    </div>
</div>
<?php
    else:
        echo "<div class='alert alert-danger m-4'>Kompanija nije pronađena.</div>";
    endif;
} else {
    echo "<div class='alert alert-warning m-4'>ID kompanije nije prosleđen.</div>";
}
?>
