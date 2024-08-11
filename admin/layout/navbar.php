<body>
    <div class="wrapper">
        <div class="main-panel">
            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg navbar-dark bg-dark border-bottom">
                <div class="container-fluid">
                    <a class="navbar-brand" href="indexAdmin.php">Poskesri Kubu Nan V Nagari Batipuh Baruah</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="indexAdmin.php">Beranda</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dataDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                    Data
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dataDropdown">
                                    <a class="dropdown-item" href="pengguna.php">Data Pengguna</a>
                                    <a class="dropdown-item" href="data_bayi.php">Data Bayi</a>
                                    <a class="dropdown-item" href="data_balita.php">Data Balita</a>
                                    <!-- <a class="dropdown-item" href="orang_tua.php">Data Orang Tua</a> -->
                                    <a class="dropdown-item" href="pelayanan_bayi.php">Pelayanan Bayi</a>
                                    <a class="dropdown-item" href="pelayanan_balita.php">Pelayanan Balita</a>
                                    <a class="dropdown-item" href="jadwal.php">Data Jadwal</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="laporan.php">Laporan</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i><?php echo $_SESSION['username']; ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                                    <a class="dropdown-item" href="../logout.php">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <div class="container">
                <!-- End Navbar -->
            </div>