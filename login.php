<!DOCTYPE html> 
<head>
	<title>Web - Pariwisata</title>
	<link rel="icon" href="assets/img/kaiadmin/favicon.ico" type="image/x-icon" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			background-image: url('wisatawan/assets/img/bg.jpg');
			/* Ganti URL gambar dengan URL gambar pemandangan yang Anda inginkan */
			background-size: cover;
			background-position: center;
		}

		.login-container {
			background: rgba(255, 255, 255, 0.8);
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}
	</style>
</head>

<body>
	<!-- <-- Konten lainnya tetap sama seperti yang Anda berikan --> 

	<div class="container">
		<div class="row justify-content-center align-items-center vh-100">
			<div class="col-lg-6">
				<div class="login-container">
					<h3 class="text-center mb-4">Silahkan Login</h3>
					<form action="cek_login.php" method="post">
						<div class="mb-3">
							<label for="Username" class="form-label">Username</label>
							<input type="text" name="username" class="form-control" id="Username" required>
						</div>
						<div class="mb-3">
							<label for="Password" class="form-label">Password</label>
							<input type="password" name="password" class="form-control" id="Password" required>
						</div>
						<button type="submit" class="btn btn-primary mb-3 w-100">Login</button>
						<div class="mb-3 text-center">
							<a href="register.php" class="text-center">Belum memiliki akun? Daftar sekarang!</a>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div> 

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>  