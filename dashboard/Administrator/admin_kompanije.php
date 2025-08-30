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
            <?php endif; ?>
        </tbody>
    </table>


</div>

