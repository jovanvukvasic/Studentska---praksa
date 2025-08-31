<?php
session_start();

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'mentor') {
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
            <a class="nav-link active" href="#" onclick="showSection('profil', event)">👤 Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="showSection('kompanija', event)">🏢 Moja kompanija</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="showSection('studenti', event)">🎓 Studenti na praksi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="../logout.php">🚪 Odjava</a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
      <section id="profil" class="content-section">
        <h2>👤 Mentor profil</h2>
        <p>Dobrodošli, <strong><?php echo $_SESSION['ime'] . " " . $_SESSION['prezime']; ?></strong>.</p>
        <p>Email: <strong><?php echo $_SESSION['email'] ?? 'Nepoznato'; ?></strong></p>
        <hr>
      </section>

      <section id="kompanija" class="content-section d-none">
        <h2>🏢 Moja kompanija</h2>
        <div id="kompanijaContainer">
          <div class="text-muted">Učitavanje podataka...</div>
        </div>
        <hr>
      </section>

      <section id="studenti" class="content-section d-none">
        <h2>🎓 Studenti na praksi</h2>
        <div id="studentiContainer">
          <div class="text-muted">Učitavanje studenata...</div>
        </div>
        <hr>
      </section>
    </main>

  </div>
</div>

<script>
  function showSection(id, event) {
    if (event) event.preventDefault();

    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    event.target.classList.add('active');

    document.querySelectorAll('.content-section').forEach(section => {
      section.classList.add('d-none');
    });

    const section = document.getElementById(id);
    section.classList.remove('d-none');

    if (id === 'kompanija') {
      fetch('mentor_kompanija.php')
        .then(response => response.text())
        .then(data => {
          document.getElementById('kompanijaContainer').innerHTML = data;
        });
    } else if (id === 'studenti') {
      fetch('mentor_studenti.php')
        .then(response => response.text())
        .then(data => {
          document.getElementById('studentiContainer').innerHTML = data;
        });
    }
  }
</script>
<?php include("../includes/footer.php"); ?>
