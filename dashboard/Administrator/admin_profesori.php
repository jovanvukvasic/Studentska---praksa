<?php
include("../includes/db.php"); 

$query = "SELECT id, ime, prezime, zvanje, email, telefon FROM profesori";
$stmt = $conn->prepare($query);
$stmt->execute();

$profesori = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>🧑‍🏫 Lista profesora</h2>
  <a href="dodaj_profesora.php" class="btn btn-primary">➕ Dodaj profesora</a>
</div>

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
    <?php endforeach; ?>
  </tbody>
</table>
