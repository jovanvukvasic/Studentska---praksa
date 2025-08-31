<?php
require '../db.php';

$komisija = $_GET['komisija'] ?? '';
if (!$komisija) exit;

$profesori = $conn->query("SELECT id, ime, prezime FROM profesori")->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT profesor_id FROM komisije_profesori WHERE komisija = ?");
$stmt->execute([$komisija]);
$trenutni_clanovi = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($profesori)) {
    echo "<p>Nema dostupnih profesora.</p>";
    exit;
}

echo "<p><strong>Izaberi profesore za komisiju:</strong></p>";
foreach ($profesori as $prof) {
    $checked = in_array($prof['id'], $trenutni_clanovi) ? 'checked' : '';
    echo "<div class='form-check'>
        <input class='form-check-input' type='checkbox' name='profesori[]' value='{$prof['id']}' id='prof_{$prof['id']}' $checked>
        <label class='form-check-label' for='prof_{$prof['id']}'>
            {$prof['ime']} {$prof['prezime']}
        </label>
    </div>";
}

// end of file
