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

        } else {
            $greska = "Pogrešni podaci.";
        }
    } else {
        $greska = "Ne postoji korisnik sa tim emailom i sifrom.";
    }
}

?>


<?php include("includes/header.php"); ?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title text-center mb-4">Prijava na sistem stručne prakse</h3>
          <form method="POST" action="index.php">
            <div class="mb-3">
              <label for="username" class="form-label">Email</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Lozinka</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>        
            <button type="submit" class="btn btn-primary w-100">Prijavi se</button>
			<div class="text-center mt-3">
			  <a href="registrovanje_kompanije.php" class="btn btn-link">Registrovanje kompanije</a>
			</div>

            <?php if (isset($greska)): ?>
              <div class="alert alert-danger mt-3"><?php echo $greska; ?></div>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php"); ?>
