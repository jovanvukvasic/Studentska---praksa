<?php
session_start();
include("includes/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['username'];
    $lozinka = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM korisnici WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $korisnik = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($korisnik) {
        if (password_verify($lozinka, $korisnik['sifra'])) {
		   if ($lozinka === $korisnik['sifra']) {
            $_SESSION['korisnik_id'] = $korisnik['id'];
            $_SESSION['uloga'] = $korisnik['uloga'];
            $_SESSION['email'] = $korisnik['email'];
				$_SESSION['povezani_id'] = $korisnik['povezani_id'];
		
            switch ($korisnik['uloga']) {
				case 'student':
					$tabela = 'studenti';
					break;
				case 'mentor':
					$tabela = 'mentori';
					break;
				case 'profesor':
					$tabela = 'profesori';
					break;
				case 'moderator':
					$tabela = 'moderatori';
					break;
				case 'admin':
					$tabela = null; 
					break;
				default:
					$greska = "Nepoznata uloga.";
					exit;
			}
		
            if ($tabela) {
				$stmt2 = $conn->prepare("SELECT * FROM $tabela WHERE id = :id");
				$stmt2->execute(['id' => $korisnik['povezani_id']]);
				$detalji = $stmt2->fetch(PDO::FETCH_ASSOC);

				if ($detalji) {
					$_SESSION['ime'] = $detalji['ime'];
					$_SESSION['prezime'] = $detalji['prezime'];
				} else {
					$greska = "Nije moguće dohvatiti podatke o korisniku.";
					exit;
				}
			}

			header("Location: dashboard/" . $korisnik['uloga'] . ".php");
			exit;
<?php include("includes/footer.php"); ?>
