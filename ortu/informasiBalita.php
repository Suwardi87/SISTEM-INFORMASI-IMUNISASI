<?php
include 'layout/header.php';
include '../koneksi.php';

// Menangani pencarian
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM data_balita";
if ($searchQuery) {
    $searchQuery = $koneksi->real_escape_string($searchQuery); // Menjaga keamanan input
    $sql .= " WHERE nama_balita LIKE '%$searchQuery%' OR nik_balita LIKE '%$searchQuery%'";
}

$result = $koneksi->query($sql);
?>

<?php include 'layout/navbar.php'; ?>

<div class="container my-xl-5">
    <div class="page-inner">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="fw-bold mb-3">Informasi Balita</h3>
                </div>
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan Nama Balita atau NIK Balita..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Data Balita</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['id_data_balita']; ?></td>
                                                <td><?php echo $row['nik_balita']; ?></td>
                                                <td><?php echo $row['nama_balita']; ?></td>
                                                <td><?php echo $row['tgl_lhr']; ?></td>
                                                <td><?php echo $row['nik_ayah']; ?></td>
                                                <td><?php echo $row['nama_ayah']; ?></td>
                                                <td><?php echo $row['nik_ibu']; ?></td>
                                                <td><?php echo $row['nama_ibu']; ?></td>
                                                <td><?php echo $row['alamat']; ?></td>
                                                <td><?php echo $row['buku_kia']; ?></td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <button type="button" class="btn btn-link btn-primary btn-lg" onclick="editBalita(
                                                            <?php echo $row['id_data_balita']; ?>, 
                                                            '<?php echo $row['nik_balita']; ?>', 
                                                            '<?php echo $row['nama_balita']; ?>', 
                                                            '<?php echo $row['tgl_lhr']; ?>', 
                                                            '<?php echo $row['nik_ayah']; ?>', 
                                                            '<?php echo $row['nama_ayah']; ?>', 
                                                            '<?php echo $row['nik_ibu']; ?>', 
                                                            '<?php echo $row['nama_ibu']; ?>', 
                                                            '<?php echo $row['alamat']; ?>', 
                                                            '<?php echo $row['buku_kia']; ?>'
                                                        )">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <a href="?delete=<?php echo $row['id_data_balita']; ?>" class="btn btn-link btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='11'>Tidak ada data</td></tr>";
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
        var name = row.querySelector('td:nth-child(3)').textContent.toLowerCase(); // Nama Balita
        var nik = row.querySelector('td:nth-child(2)').textContent.toLowerCase(); // NIK Balita

        if (name.includes(searchQuery) || nik.includes(searchQuery)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<?php include 'layout/footer.php'; ?>
