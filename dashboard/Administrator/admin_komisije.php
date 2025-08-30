<?php
require '../includes/db.php';

$komisijeQuery = "SELECT DISTINCT komisija FROM komisije_profesori";
$komisijeStmt = $conn->prepare($komisijeQuery);
$komisijeStmt->execute();
$komisije = $komisijeStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Komisije</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container">
        <h2>Pregled komisija</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Komisija</th>
                    <th>Profesori</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($komisije as $komisija): ?>
                    <?php
                        $profQuery = "SELECT p.ime, p.prezime 
                                      FROM komisije_profesori kp 
                                      JOIN profesori p ON kp.profesor_id = p.id
                                      WHERE kp.komisija = ?";
                        $profStmt = $conn->prepare($profQuery);
                        $profStmt->execute([$komisija]);
                        $profesori = $profStmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <tr>
                        <td><?= htmlspecialchars(ucfirst($komisija)) ?></td>
                        <td>
                            <?php if (!empty($profesori)): ?>
                                <?php foreach ($profesori as $p): ?>
                                    <?= htmlspecialchars($p['ime'] . ' ' . $p['prezime']) ?><br>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <em>Nema profesora</em>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="uredi_komisiju.php?id=<?= urlencode($komisija) ?>" class="btn btn-sm btn-primary">
                                Uredi komisiju
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-4">
            <a href="dodaj_komisiju.php" class="btn btn-success">
                Dodaj novu komisiju
            </a>
        </div>
    </div>
</html>
