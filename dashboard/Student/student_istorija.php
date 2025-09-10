<?php
include '../includes/db.php';
$student_id = $_SESSION['povezani_id'] ?? 1;


$query = $conn->prepare("
    SELECT a.*, d.datum
    FROM student_aktivnosti a
    JOIN praksa_dani d ON a.praksa_dan_id = d.id
    WHERE a.student_id = ?
    ORDER BY a.vreme_izmene DESC
");
$query->execute([$student_id]);
$aktivnosti = $query->fetchAll();
?>

<div class="container mt-4">
    <h4>🕓 Istorija aktivnosti</h4>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Datum dana</th>
                <th>Polje</th>
                <th>Sadržaj</th>
                <th>Vreme izmene</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($aktivnosti)): ?>
                <tr><td colspan="5" class="text-center">Nema zabeleženih aktivnosti.</td></tr>
            <?php else: ?>
                <?php foreach ($aktivnosti as $i => $a): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($a['datum']) ?></td>
                        <td><?= htmlspecialchars($a['polje']) ?></td>
                        <td><?= nl2br(htmlspecialchars($a['sadrzaj'])) ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($a['vreme_izmene'])) ?></td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>
