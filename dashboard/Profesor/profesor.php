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
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
      <section id="profil" class="content-section">
        <h2>👤 Profil profesora</h2>
        <p>Dobrodošli, <strong><?php echo $_SESSION['ime'] . " " . $_SESSION['prezime']; ?></strong>.</p>
        <p>Email: <strong><?php echo $_SESSION['email'] ?? 'Nepoznato'; ?></strong></p>
        <hr>
      </section>

      <section id="kompanije" class="content-section d-none">
        <h2>🏢 Kompanije</h2>
        <p>Pregled saradničkih kompanija.</p>
        <hr>
      </section>

      <section id="studenti" class="content-section d-none">
        <h2>🎓 Studenti na praksi</h2>
        <p>Pregled studenata i njihovih praksi.</p>
        <hr>
      </section>
    </main>

  </div>
</div>

<script>
  function showSection(id) {
    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    event.target.classList.add('active');

    document.querySelectorAll('.content-section').forEach(section => {
      section.classList.add('d-none');
    });

    const section = document.getElementById(id);
    section.classList.remove('d-none');

    if (id === 'profil') {
      fetch('profesor_profil.php')
        .then(response => response.text())
        .then(data => {
          section.innerHTML = data;
        });
    } else if (id === 'kompanije') {
      fetch('profesor_kompanije.php')
        .then(response => response.text())
        .then(data => {
          section.innerHTML = data;
        });
    } else if (id === 'studenti') {
      fetch('profesor_studenti.php')
        .then(response => response.text())
        .then(data => {
          section.innerHTML = data;
        });
    }
  }
<?php include("../includes/footer.php"); ?>
