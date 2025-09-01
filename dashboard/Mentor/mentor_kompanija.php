<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'mentor') {
    echo "<div class='alert alert-danger'>Nemate pristup ovoj stranici.</div>";
    exit;
}

$mentor_id = $_SESSION['povezani_id'];

$query = $conn->prepare("
    SELECT k.naziv, k.adresa, k.kontakt_osoba
    FROM kompanije k
    JOIN moderatori mo ON k.moderator_id = mo.id
	JOIN mentori m ON m.id_moderatora = mo.id
            <td><?= htmlspecialchars($kompanija['kontakt_osoba']) ?></td>
        </tr>
    </table>
</div>
