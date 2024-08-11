<?php
include 'layout/header.php';
include '../koneksi.php';

$jenis_laporan = $_GET['jenis_laporan'] ?? '';
$periode = $_GET['periode'] ?? '';

$query_data_bayi = "";
$query_pelayanan_bayi = "";
$query_data_balita = "";
$query_pelayanan_balita = "";

$result = null;

if ($jenis_laporan == 'data_bayi') {
    $query_data_bayi = "SELECT * FROM data_bayi";
    if ($periode) {
        $query_data_bayi .= " WHERE YEAR(tgl_lhr) = '$periode'";
    }
    $result = $koneksi->query($query_data_bayi);
} elseif ($jenis_laporan == 'pelayanan_bayi') {
    $query_pelayanan_bayi = "SELECT * FROM pelayanan_bayi";
    if ($periode) {
        $query_pelayanan_bayi .= " WHERE YEAR(tgl_lahir) = '$periode'";
    }
    $result = $koneksi->query($query_pelayanan_bayi);
} elseif ($jenis_laporan == 'data_balita') {
    $query_data_balita = "SELECT * FROM data_balita";
    if ($periode) {
        $query_data_balita .= " WHERE YEAR(tgl_lhr) = '$periode'";
    }
    $result = $koneksi->query($query_data_balita);
} elseif ($jenis_laporan == 'pelayanan_balita') {
    $query_pelayanan_balita = "SELECT * FROM pelayanan_balita";
    if ($periode) {
        $query_pelayanan_balita .= " WHERE YEAR(tgl_lahir) = '$periode'";
    }
    $result = $koneksi->query($query_pelayanan_balita);
}

$koneksi = mysqli_connect("localhost", "root", "", "db_poskesri");

// Check connection
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>

<div class="wrapper">
    <div class="main-panel">
        <div class="main-header">
            <?php include 'layout/navbar.php'; ?>
        </div>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <h3 class="fw-bold mb-3">Kelola Laporan</h3>
                    <form class="d-flex" method="GET" action="">
                        <div class="me-3">
                            <label for="jenisLaporan" class="form-label">Jenis Laporan</label>
                            <select id="jenisLaporan" class="form-select" name="jenis_laporan" onchange="this.form.submit()">
                                <option value="">Pilih Jenis Laporan</option>
                                <option value="data_bayi" <?php if (isset($_GET['jenis_laporan']) && $_GET['jenis_laporan'] == 'data_bayi') echo 'selected'; ?>>Data Bayi</option>
                                <option value="pelayanan_bayi" <?php if (isset($_GET['jenis_laporan']) && $_GET['jenis_laporan'] == 'pelayanan_bayi') echo 'selected'; ?>>Pelayanan Bayi</option>
                                <option value="data_balita" <?php if (isset($_GET['jenis_laporan']) && $_GET['jenis_laporan'] == 'data_balita') echo 'selected'; ?>>Data Balita</option>
                                <option value="pelayanan_balita" <?php if (isset($_GET['jenis_laporan']) && $_GET['jenis_laporan'] == 'pelayanan_balita') echo 'selected'; ?>>Pelayanan Balita</option>
                            </select>
                        </div>
                        <div>
                            <label for="periode" class="form-label">Periode</label>
                            <select id="periode" class="form-select" name="periode" onchange="this.form.submit()">
                                <option value="">Pilih Periode</option>
                                <?php
                                $currentYear = date('Y');
                                for ($year = 2010; $year <= $currentYear; $year++) {
                                    $selected = (isset($_GET['periode']) && $_GET['periode'] == $year) ? 'selected' : '';
                                    echo "<option value=\"$year\" $selected>$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Data Laporan</h4>
                                    <div>
                                        <button type="button" class="btn btn-secondary btn-round ms-2" onclick="printTable()">
                                            <i class="fa fa-print"></i>
                                            Cetak
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="laporanTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <?php if ($jenis_laporan == 'data_bayi') : ?>
                                                    <th>ID</th>
                                                    <th>NIK Bayi</th>
                                                    <th>Nama Bayi</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>NIK Ayah</th>
                                                    <th>Nama Ayah</th>
                                                    <th>NIK Ibu</th>
                                                    <th>Nama Ibu</th>
                                                    <th>Alamat</th>
                                                    <th>Buku KIA</th>
                                                    <th>Berat Lahir</th>
                                                    <th>Tinggi Lahir</th>
                                                    <th>Waktu Kunjungan</th>
                                                <?php elseif ($jenis_laporan == 'pelayanan_bayi') : ?>
                                                    <th>ID</th>
                                                <th>ID Data Bayi</th>
                                                <th>ID Jadwal</th>
                                                <th>Pilihan Imunisasi</th>
                                                <th>Keterangan</th>
                                                <?php elseif ($jenis_laporan == 'data_balita') : ?>
                                                    <th>ID</th>
                                                    <th>NIK Balita</th>
                                                    <th>Nama Balita</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>NIK Ayah</th>
                                                    <th>Nama Ayah</th>
                                                    <th>NIK Ibu</th>
                                                    <th>Nama Ibu</th>
                                                    <th>Alamat</th>
                                                    <th>Buku KIA</th>
                                                <?php elseif ($jenis_laporan == 'pelayanan_balita') : ?>
                                                    <th>ID</th>
                                                    <th>Nama Balita</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Berat Badan</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result && $result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    if ($jenis_laporan == 'data_bayi') {
                                                        echo "<td>{$row['id_data_bayi']}</td>";
                                                        echo "<td>{$row['nik_bayi']}</td>";
                                                        echo "<td>{$row['nama_bayi']}</td>";
                                                        echo "<td>{$row['tgl_lhr']}</td>";
                                                        echo "<td>{$row['jns_kel']}</td>";
                                                        echo "<td>{$row['nik_ayah']}</td>";
                                                        echo "<td>{$row['nama_ayah']}</td>";
                                                        echo "<td>{$row['nik_ibu']}</td>";
                                                        echo "<td>{$row['nama_ibu']}</td>";
                                                        echo "<td>{$row['alamat']}</td>";
                                                        echo "<td>{$row['buku_kia']}</td>";
                                                        echo "<td>{$row['berat_lhr']}</td>";
                                                        echo "<td>{$row['tinggi_lhr']}</td>";
                                                        echo "<td>{$row['waktu_kunjungan']}</td>";
                                                    } elseif ($jenis_laporan == 'pelayanan_bayi') {
                                                        echo "                                                        <td> {$row['id_pelayanan_bayi']}</td>";
                                                        echo "                                                        <td> {$row['id_data_bayi']}</td>";
                                                        echo "                                                        <td> {$row['id_jadwal']}</td>";
                                                        echo "                                                        <td> {$row['pilihan_imunisasi']}</td>";
                                                        echo "                                                        <td> {$row['keterangan']}</td>";
                                                    } elseif ($jenis_laporan == 'data_balita') {
                                                        echo "<td>{$row['id_data_balita']}</td>";
                                                        echo "<td>{$row['nik_balita']}</td>";
                                                        echo "<td>{$row['nama_balita']}</td>";
                                                        echo "<td>{$row['tgl_lhr']}</td>";
                                                        echo "<td>{$row['nik_ayah']}</td>";
                                                        echo "<td>{$row['nama_ayah']}</td>";
                                                        echo "<td>{$row['nik_ibu']}</td>";
                                                        echo "<td>{$row['nama_ibu']}</td>";
                                                        echo "<td>{$row['alamat']}</td>";
                                                        echo "<td>{$row['buku_kia']}</td>";
                                                    } elseif ($jenis_laporan == 'pelayanan_balita') {
                                                        echo "<td>{$row['id_pelayanan_balita']}</td>";
                                                        echo "<td>{$row['nama_balita']}</td>";
                                                        echo "<td>{$row['jenis_kelamin']}</td>";
                                                        echo "<td>{$row['tgl_lahir']}</td>";
                                                        echo "<td>{$row['berat_badan']}</td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='14'>Tidak ada data</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <p>Mengetahui,</p>
                                <br><br>
                                <p>______________________</p>
                                <p>Kepala Poskesri</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

<script>
    function printTable() {
        var printContents = document.getElementById('laporanTable').outerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = "<html><head><title>Cetak Laporan</title></head><body>" + printContents + "<br><br><p>Mengetahui,</p><br><br><p>______________________</p><p>Kepala Poskesri</p></body></html>";
        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload();
    }
</script>