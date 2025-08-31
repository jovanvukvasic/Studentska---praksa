<?php
include("../includes/db.php"); 

$ime     = $_POST['ime'];
$prezime = $_POST['prezime'];
$zvanje  = $_POST['zvanje'];
$telefon = $_POST['telefon'];
$email   = $_POST['email'];
$sifra   = password_hash($_POST['sifra'], PASSWORD_DEFAULT);

try {
    $conn->beginTransaction();

    $query1 = "INSERT INTO profesori (ime, prezime, zvanje, telefon, email, sifra) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt1 = $conn->prepare($query1);
    $stmt1->execute([$ime, $prezime, $zvanje, $telefon, $email, $sifra]);

    $query2 = "INSERT INTO korisnici (email, sifra, uloga) VALUES (?, ?, 'profesor')";
    $stmt2 = $conn->prepare($query2);
    $stmt2->execute([$email, $sifra]);

    $conn->commit();

    header("Location: admin.php");
    exit;

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Greška pri dodavanju profesora: " . $e->getMessage();
}
?>
