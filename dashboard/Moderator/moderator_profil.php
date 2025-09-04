<?php
session_start();

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'moderator') {
    echo "Niste autorizovani.";
    exit;
}
?>

<h2>👤 Moj profil</h2>
<table class="table table-bordered">
        <td><?= $_SESSION['email'] ?? 'Nepoznato'; ?></td>
    </tr>
    <tr>
        <th>Uloga:</th>
        <td>Moderator</td>
    </tr>
</table>
