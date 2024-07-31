<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $nama = $_POST['nama_lengkap']; // Updated to match form field
    $alamat = $_POST['alamat'];
    $tgl_lahir = $_POST['tgl_lhr'];
    $tmp_lahir = $_POST['tmp_lhr'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Directly use the password
    $level = $_POST['level'];

    if (isset($_POST['create'])) {
        // Create new user in 'pengguna' table
        $sql = "INSERT INTO pengguna (nama_lengkap, alamat, tgl_lhr, tmp_lhr, username, password, level) 
                VALUES ('$nama', '$alamat', '$tgl_lahir', '$tmp_lahir', '$username', '$password', '$level')";

        if ($koneksi->query($sql) === TRUE) {
            // Redirect to index.php
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
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
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-lg-6">
                <div class="login-container">
                    <h3 class="text-center mb-4">Silahkan Login</h3>
                    <form id="penggunaForm" method="POST" action="">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_lhr" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lhr" name="tgl_lhr" required>
                        </div>
                        <div class="mb-3">
                            <label for="tmp_lhr" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tmp_lhr" name="tmp_lhr" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="admin">Admin</option>
                                <option value="kader">Kader</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create" id="createBtn">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
