<?php
include 'layout/header.php';
include '../koneksi.php';

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM data_bayi";
if ($searchQuery) {
    $sql .= " WHERE nama_bayi LIKE '%$searchQuery%' OR nik_bayi LIKE '%$searchQuery%'";
}

$result = $koneksi->query($sql);
?>

<?php include 'layout/navbar.php'; ?>

<div class="container my-xl-5">
    <div class="page-inner">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="fw-bold mb-3">Informasi Bayi</h3>
                </div>
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan Nama Bayi atau NIK Bayi..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Data Bayi</h4>
                           
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>{$no}</td>
                                            <td>{$row['nik_bayi']}</td>
                                            <td>{$row['nama_bayi']}</td>
                                            <td>{$row['tgl_lhr']}</td>
                                            <td>{$row['jns_kel']}</td>
                                            <td>{$row['nik_ayah']}</td>
                                            <td>{$row['nama_ayah']}</td>
                                            <td>{$row['nik_ibu']}</td>
                                            <td>{$row['nama_ibu']}</td>
                                            <td>{$row['alamat']}</td>
                                            <td>{$row['buku_kia']}</td>
                                            <td>{$row['berat_lhr']}</td>
                                            <td>{$row['tinggi_lhr']}</td>
                                            <td>{$row['waktu_kunjungan']}</td>
                                        </tr>";
                                        $no++;
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

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    var searchQuery = this.value.toLowerCase();
    var rows = document.querySelectorAll('tbody tr');

    rows.forEach(function(row) {
        var name = row.querySelector('td:nth-child(3)').textContent.toLowerCase(); // Nama Bayi
        var nik = row.querySelector('td:nth-child(2)').textContent.toLowerCase(); // NIK Bayi

        if (name.includes(searchQuery) || nik.includes(searchQuery)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<?php include 'layout/footer.php'; ?>
