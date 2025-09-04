<?php
session_start();

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'moderator') {
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
            <a class="nav-link" href="#" onclick="showSection('kompanije')">🏢 Moje kompanije</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="showSection('mentori')">🧑‍🏫 Mentori</a>
          </li>
          <li class="nav-item">
           <a class="nav-link" href="#" onclick="showSection('konkursi')">📢 Konkursi za praksu</a>
			
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="../logout.php">🚪 Odjava</a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
      <section id="profil" class="content-section">
        <h2>👤 Profil moderatora</h2>
        <p>Dobrodošli, <strong><?= $_SESSION['ime'] . " " . $_SESSION['prezime']; ?></strong>.</p>
        <p>Email: <strong><?= $_SESSION['email'] ?? 'Nepoznato'; ?></strong></p>
        <hr>
      </section>

      <section id="kompanije" class="content-section d-none">
      </section>

      </section>
<?php include("../includes/footer.php"); ?>
