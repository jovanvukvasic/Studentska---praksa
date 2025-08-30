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
</html>
