<?php
session_start();

if (!isset($_SESSION['korisnik_id']) || $_SESSION['uloga'] !== 'moderator') {
    echo "Niste autorizovani.";
    exit;
}
?>

<h2>👤 Moj profil</h2>
<table class="table table-bordered">
    <tr>
        <th>Ime:</th>
        <td><?= $_SESSION['ime'] ?? 'Nepoznato'; ?></td>
    </tr>
    <tr>
        <th>Prezime:</th>
        <td><?= $_SESSION['prezime'] ?? 'Nepoznato'; ?></td>
    </tr>
    <tr>
        <th>Email:</th>
        <td><?= $_SESSION['email'] ?? 'Nepoznato'; ?></td>
    </tr>
    <tr>
        <th>Uloga:</th>
        <td>Moderator</td>
    </tr>
</table>
