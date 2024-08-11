<?php
include 'layout/header.php';
include '../koneksi.php';
// Ambil total bayi
$sql_bayi = "SELECT COUNT(*) as total_bayi FROM data_bayi";
$result_bayi = $koneksi->query($sql_bayi);
$total_bayi = 0;
if ($result_bayi && $row = $result_bayi->fetch_assoc()) {
    $total_bayi = $row['total_bayi'];
}

// Ambil total balita
$sql_balita = "SELECT COUNT(*) as total_balita FROM data_balita";
$result_balita = $koneksi->query($sql_balita);
$total_balita = 0;
if ($result_balita && $row = $result_balita->fetch_assoc()) {
    $total_balita = $row['total_balita'];
}

// Ambil jadwal
$sql_jadwal = "SELECT * FROM jadwal";
$result_jadwal = $koneksi->query($sql_jadwal);
?>
<div class="wrapper">
    <div class="main-panel">
        <div class="main-header">
            <?php include 'layout/navbar.php'; ?>
        </div>
        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Dashboard</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col col-stats ml-3 ml-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Total Bayi</p>
                                            <h4 class="card-title"><?php echo number_format($total_bayi); ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col col-stats ml-3 ml-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Total Balita</p>
                                            <h4 class="card-title"><?php echo number_format($total_balita); ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col col-stats ml-3 ml-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Cetak Laporan</p>
                                            <a href="laporan.php" class="btn btn-primary btn-round">
                                                <i class="fa fa-file-alt"></i> Cetak
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Content for Jadwal Poskesri -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Jadwal Poskesri</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="jadwalTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Waktu Mulai</th>
                                                <th>Waktu Selesai</th>
                                                <th>Lokasi</th>
                                                <th>Kegiatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result_jadwal->num_rows > 0) {
                                                $no = 0;
                                                while ($row = $result_jadwal->fetch_assoc()) {
                                                    $no++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $no; ?></td>
                                                        <td><?php echo $row['tgl']; ?></td>
                                                        <td><?php echo $row['waktu_mulai']; ?></td>
                                                        <td><?php echo $row['waktu_selesai']; ?></td>
                                                        <td><?php echo $row['lokasi']; ?></td>
                                                        <td><?php echo $row['kegiatan']; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
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
        </div>
    </div>
    <?php include 'layout/footer.php'; ?>