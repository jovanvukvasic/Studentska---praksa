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
<?php include("../includes/footer.php"); ?>
