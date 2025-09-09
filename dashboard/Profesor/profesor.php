<?php
session_start();

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'profesor') {
    header("Location: ../index.php");
    exit;
}
?>

<?php include("../includes/header.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar pt-3 border-end" style="min-height: 100vh;">
      <div class="position-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#" onclick="showSection('profil')">👤 Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="showSection('kompanije')">🏢 Kompanije</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="showSection('studenti')">🎓 Studenti na praksi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="../logout.php">🚪 Odjava</a>
          </li>
        </ul>
      </div>
<?php include("../includes/footer.php"); ?>
