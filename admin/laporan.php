<?php
include 'layout/header.php';
include '../koneksi.php';

// Fetch query parameters
$jenis_laporan = $_GET['jenis_laporan'] ?? '';
$periode = $_GET['periode'] ?? '';

$query_data_bayi = "";
$query_pelayanan_bayi = "";
$query_data_balita = "";
$query_pelayanan_balita = "";
$result = null;

// Determine the query based on jenis_laporan
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

// Check connection
$koneksi = mysqli_connect("localhost", "root", "", "db_poskesri");
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

// Function to return the title based on jenis_laporan
function getLaporanTitle($jenis_laporan)
{
    switch ($jenis_laporan) {
        case 'data_bayi':
            return 'Data Bayi';
        case 'pelayanan_bayi':
            return 'Pelayanan Bayi';
        case 'data_balita':
            return 'Data Balita';
        case 'pelayanan_balita':
            return 'Pelayanan Balita';
        default:
            return 'Laporan';
    }
}
$laporan_title = getLaporanTitle($jenis_laporan);
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
                                                    <th>No</th>
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
                                                    <th>No</th>
                                                    <th>Nama Bayi</th>
                                                    <th>Lokasi</th>
                                                    <th>Pilihan Imunisasi</th>
                                                    <th>Keterangan</th>
                                                <?php elseif ($jenis_laporan == 'data_balita') : ?>
                                                    <th>No</th>
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
                                                    <th>No</th>
                                                    <th>Nama Balita</th>
                                                    <th>Lokasi</th>
                                                    <th>Berat Badan</th>
                                                    <th>Tinggi Badan</th>
                                                    <th>Vitamin A</th>
                                                    <th>Keterangan</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result && $result->num_rows > 0) {
                                                $no = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $no++;
                                                    echo "<tr>";
                                                    if ($jenis_laporan == 'data_bayi') {
                                                        echo "<td>$no</td>";
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
                                                        echo "<td>$no</td>";
                                                        echo "<td>{$row['nama_bayi']}</td>";
                                                        echo "<td>{$row['lokasi']}</td>";
                                                        echo "<td>{$row['pilihan_imunisasi']}</td>";
                                                        echo "<td>{$row['keterangan']}</td>";
                                                    } elseif ($jenis_laporan == 'data_balita') {
                                                        echo "<td>$no</td>";
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
                                                        echo "<td>$no</td>";
                                                        echo "<td>{$row['nama_balita']}</td>";
                                                        echo "<td>{$row['lokasi']}</td>";
                                                        echo "<td>{$row['tinggi_badan']}</td>";
                                                        echo "<td>{$row['vitamin_a']}</td>";
                                                        echo "<td>{$row['berat_badan']}</td>";
                                                        echo "<td>{$row['keterangan']}</td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='100%' class='text-center'>No data available</td></tr>";
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
        <div class="main-footer">
            <?php include 'layout/footer.php'; ?>
        </div>
    </div>
</div>

<script>
    function printTable() {
        var reportType = document.getElementById('jenisLaporan').value;
        var table = document.getElementById('laporanTable').outerHTML;
        var title = '';

        switch (reportType) {
            case 'data_bayi':
                title = 'Data Bayi';
                break;
            case 'pelayanan_bayi':
                title = 'Pelayanan Bayi';
                break;
            case 'data_balita':
                title = 'Data Balita';
                break;
            case 'pelayanan_balita':
                title = 'Pelayanan Balita';
                break;
            default:
                title = 'Laporan';
        }

        var newWin = window.open('', '', 'width=900, height=650');
        newWin.document.write('<html><head><title>Poskesri Kubu Nan V Nagari Batipuh Baruah</title>');
        newWin.document.write('<style>');
        newWin.document.write('table { width: 100%; border-collapse: collapse; }');
        newWin.document.write('table, th, td { border: 1px solid black; }');
        newWin.document.write('th, td { padding: 8px; text-align: left; }');
        newWin.document.write('</style></head><body>');
        newWin.document.write('<h2>' + title + '</h2>');
        newWin.document.write('<table>' + table + '</table>');
        newWin.document.write('</body></html>');
        newWin.print();
        newWin.close();
    }
</script>