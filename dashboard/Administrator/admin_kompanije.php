<?php
session_start();
if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include("../includes/db.php");

try {
    $query = "SELECT id, naziv, adresa, kontakt_osoba, moderator_id FROM kompanije ORDER BY naziv ASC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $kompanije = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Greška pri dohvaćanju podataka: " . $e->getMessage());
}
?>

<div class="container mt-5">
    <h2>📋 Lista kompanija</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv</th>
                <th>Adresa</th>
                <th>Kontakt osoba</th>
                <th>Moderator ID</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($kompanije) > 0): ?>
                <?php foreach ($kompanije as $komp): ?>
                    <tr>
                        <td><?= htmlspecialchars($komp['id']) ?></td>
                        <td><?= htmlspecialchars($komp['naziv']) ?></td>
                        <td><?= htmlspecialchars($komp['adresa']) ?></td>
                        <td><?= htmlspecialchars($komp['kontakt_osoba']) ?></td>
                        <td><?= htmlspecialchars($komp['moderator_id']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">Nema registrovanih kompanija.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>


</div>

