<?php
include 'koneksi.php';
$sql = "SELECT * FROM jadwal";
$result = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Poskesri Kubu Nan V Nagari Batipuh Baruah</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="assets/img/kaiadmin/favicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>
</head>

<body class="d-flex flex-column ">
    <div class="wrapper flex-grow-1  ">
        <div class="main-panel  min-vh-100">
            <!-- Navbar Header -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.html">Poskesri Kubu Nan V Nagari Batipuh Baruah</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ortu/informasiBayi.php">Informasi Bayi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ortu/informasiBalita.php">Informasi Balita</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container mt-5">
                <div class="page-inner">
                    <div class="container">
                        <h2 class="my-md-5">Selamat Datang</h2>
                        <h4>Di Poskesri Kubu Nan V Nagari Batipuh Baruah</h4>
                    </div>

                    <!-- New Content for Jadwal Poskesri -->
                    <div class="row mt-4">
                    <div class="card-body">
                               
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="jadwalTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tanggal</th>
                                                <th>Waktu Mulai</th>
                                                <th>Waktu Selesai</th>
                                                <th>Lokasi</th>
                                                <th>Kegiatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['id_jadwal']; ?></td>
                                                        <td><?php echo $row['tgl']; ?></td>
                                                        <td><?php echo $row['waktu_mulai']; ?></td>
                                                        <td><?php echo $row['waktu_selesai']; ?></td>
                                                        <td><?php echo $row['lokasi']; ?></td>
                                                        <td><?php echo $row['kegiatan']; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer bg-dark text-white text-center mt-auto">
            <div class="container">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <p class="mb-0">Copyright &copy; 2022 -
                        <a href="" class="text-white">Fadhila Annur</a>
                    </p>
                    <p class="mb-0">
                        <a href="login.php" class="text-white"><i class="bi bi-arrow-right-circle"></i></a>
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
