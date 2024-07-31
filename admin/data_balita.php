<?php
include 'layout/header.php';
include '../koneksi.php';

// Handle form submission for create and update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $nik_balita = $_POST['nik_balita'];
    $nama_balita = $_POST['nama_balita'];
    $tgl_lhr = $_POST['tgl_lhr'];
    $nik_ayah = $_POST['nik_ayah'];
    $nama_ayah = $_POST['nama_ayah'];
    $nik_ibu = $_POST['nik_ibu'];
    $nama_ibu = $_POST['nama_ibu'];
    $alamat = $_POST['alamat'];
    $buku_kia = $_POST['buku_kia'];

    if (isset($_POST['create'])) {
        $stmt = $koneksi->prepare("INSERT INTO Data_Balita (nik_balita, nama_balita, tgl_lhr, nik_ayah, nama_ayah, nik_ibu, nama_ibu, alamat, buku_kia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $nik_balita, $nama_balita, $tgl_lhr, $nik_ayah, $nama_ayah, $nik_ibu, $nama_ibu, $alamat, $buku_kia);
    } elseif (isset($_POST['update'])) {
        $stmt = $koneksi->prepare("UPDATE Data_Balita SET nik_balita=?, nama_balita=?, tgl_lhr=?, nik_ayah=?, nama_ayah=?, nik_ibu=?, nama_ibu=?, alamat=?, buku_kia=? WHERE id_data_balita=?");
        $stmt->bind_param("sssssssssi", $nik_balita, $nama_balita, $tgl_lhr, $nik_ayah, $nama_ayah, $nik_ibu, $nama_ibu, $alamat, $buku_kia, $id);
    }

    if ($stmt->execute()) {
        echo "Record successfully saved.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $koneksi->prepare("DELETE FROM Data_Balita WHERE id_data_balita=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record successfully deleted.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM Data_Balita";
$result = $koneksi->query($sql);
?>

<div class="wrapper">
    <div class="main-panel">
        <div class="main-header">
            <?php include 'layout/navbar.php'; ?>
        </div>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <h3 class="fw-bold mb-3">Kelola Data Balita</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Data Balita</h4>
                                    <button type="button" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#balitaModal" onclick="resetForm()">
                                        <i class="fa fa-plus"></i>
                                        Tambah Balita
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="modal fade" id="balitaModal" tabindex="-1" aria-labelledby="balitaModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="balitaModalLabel">Tambah Balita</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="balitaForm" method="POST" action="">
                                                    <input type="hidden" id="id" name="id">
                                                    <div class="mb-3">
                                                        <label for="nik_balita" class="form-label">NIK Balita</label>
                                                        <input type="text" class="form-control" id="nik_balita" name="nik_balita" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nama_balita" class="form-label">Nama Balita</label>
                                                        <input type="text" class="form-control" id="nama_balita" name="nama_balita" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tgl_lhr" class="form-label">Tanggal Lahir</label>
                                                        <input type="date" class="form-control" id="tgl_lhr" name="tgl_lhr" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nik_ayah" class="form-label">NIK Ayah</label>
                                                        <input type="text" class="form-control" id="nik_ayah" name="nik_ayah" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                                        <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nik_ibu" class="form-label">NIK Ibu</label>
                                                        <input type="text" class="form-control" id="nik_ibu" name="nik_ibu" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                                        <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="alamat" class="form-label">Alamat</label>
                                                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="buku_kia" class="form-label">Buku KIA</label>
                                                        <select class="form-control" id="buku_kia" name="buku_kia" required>
                                                            <option value="Ada">Ada</option>
                                                            <option value="Tidak Ada">Tidak Ada</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" name="create" id="createBtn" class="btn btn-primary">Tambah</button>
                                                    <button type="submit" name="update" id="updateBtn" class="btn btn-primary d-none">Update</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                                                <th>Aksi</th>
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
                                                                <button type="button" class="btn btn-link btn-primary btn-lg" onclick="editBalita(<?php echo $row['id_data_balita']; ?>, '<?php echo $row['nik_balita']; ?>', '<?php echo $row['nama_balita']; ?>', '<?php echo $row['tgl_lhr']; ?>', '<?php echo $row['nik_ayah']; ?>', '<?php echo $row['nama_ayah']; ?>', '<?php echo $row['nik_ibu']; ?>', '<?php echo $row['nama_ibu']; ?>', '<?php echo $row['alamat']; ?>', '<?php echo $row['buku_kia']; ?>')">
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
</div>

<?php include 'layout/footer.php'; ?>

<script>
    function resetForm() {
        document.getElementById('balitaForm').reset();
        document.getElementById('balitaModalLabel').textContent = 'Tambah Balita';
        document.getElementById('createBtn').classList.remove('d-none');
        document.getElementById('updateBtn').classList.add('d-none');
    }

    function editBalita(id, nik_balita, nama_balita, tgl_lhr, nik_ayah, nama_ayah, nik_ibu, nama_ibu, alamat, buku_kia) {
        document.getElementById('id').value = id;
        document.getElementById('nik_balita').value = nik_balita;
        document.getElementById('nama_balita').value = nama_balita;
        document.getElementById('tgl_lhr').value = tgl_lhr;
        document.getElementById('nik_ayah').value = nik_ayah;
        document.getElementById('nama_ayah').value = nama_ayah;
        document.getElementById('nik_ibu').value = nik_ibu;
        document.getElementById('nama_ibu').value = nama_ibu;
        document.getElementById('alamat').value = alamat;
        document.getElementById('buku_kia').value = buku_kia;
        document.getElementById('balitaModalLabel').textContent = 'Edit Balita';
        document.getElementById('createBtn').classList.add('d-none');
        document.getElementById('updateBtn').classList.remove('d-none');
        var myModal = new bootstrap.Modal(document.getElementById('balitaModal'), {});
        myModal.show();
    }
</script>
