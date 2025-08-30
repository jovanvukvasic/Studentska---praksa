<?php
session_start();
require '../includes/db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'save_members') {
    $komisija = $_POST['komisija'] ?? '';
    $profesori = $_POST['profesori'] ?? [];

    if (empty($komisija)) {
        echo "Komisija nije izabrana.";
        exit;
    }

    try {
        $stmt = $conn->prepare("DELETE FROM komisije_profesori WHERE komisija = ?");
        $stmt->execute([$komisija]);

        foreach ($profesori as $id_prof) {
            $stmt->execute([$komisija, $id_prof]);
        }

        echo "Članovi komisije su uspješno sačuvani.";
    } catch (PDOException $e) {
        echo "Greška pri čuvanju: " . $e->getMessage();
    }
} else {
    echo "Neispravan zahtjev.";
}

// end of file
