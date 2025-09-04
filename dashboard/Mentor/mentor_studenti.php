<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'mentor') {
    echo "<div class='alert alert-danger'>Nemate pristup ovoj stranici.</div>";
    exit;
}

$mentor_id = $_SESSION['povezani_id'];

$query = $conn->prepare("
    SELECT s.id, s.ime, s.prezime, s.indeks, s.smjer
    FROM studenti s
    JOIN konkursi k ON s.id = k.student_id
    WHERE k.status = 'prihvaćen' AND k.mentor_id = ?
    ORDER BY s.prezime ASC
");
$query->execute([$mentor_id]);
$studenti = $query->fetchAll();
?>

<div class="container mt-4">
    <h4>🎓 Studenti kod vas na praksi</h4>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Ime i prezime</th>
                <th>Indeks</th>
                <th>Smjer</th>
                <th>Akcija</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($studenti)): ?>
                <tr><td colspan="5" class="text-center">Trenutno nemate zaduženih studenata.</td></tr>
            <?php else: ?>
                <?php foreach ($studenti as $i => $s): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($s['ime'] . ' ' . $s['prezime']) ?></td>
                        <td><?= htmlspecialchars($s['indeks']) ?></td>
                        <td><?= htmlspecialchars($s['smjer']) ?></td>
                        <td>
                            <a class="btn btn-info btn-sm" href="mentor_uvid.php?id=<?= $s['id']?>" class="btn btn-link text-decoration-none">
							  📘 Uvid u rad
							</a>

                        </td>
                    </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

<script>
  function ucitajUvid(studentId, event) {
    if (event) event.preventDefault();

    document.querySelectorAll('.content-section').forEach(section => {
      section.classList.add('d-none');
    });

    const uvidSection = document.getElementById('uvid');
    const uvidContainer = document.getElementById('uvidContainer');

    uvidSection.classList.remove('d-none');
    uvidContainer.innerHTML = "<div class='text-muted'>Učitavanje podataka...</div>";

    fetch('mentor_uvid.php?id=' + studentId)
      .then(response => response.text())
      .then(data => {
        uvidContainer.innerHTML = data;
      })
      .catch(err => {
        uvidContainer.innerHTML = "<div class='alert alert-danger'>Greška pri učitavanju.</div>";
      });
  }
</script>
