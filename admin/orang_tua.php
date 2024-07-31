<?php
include 'layout/header.php';
include '../koneksi.php';

// Fetch bayi and balita data
$bayi_result = $koneksi->query("SELECT id_data_bayi, nama_bayi FROM data_bayi");
$balita_result = $koneksi->query("SELECT id_data_balita, nama_balita FROM data_balita");

// Handle form submission for create and update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $nama_ortu = $_POST['nama_ortu'];
    $id_data_bayi = $_POST['id_data_bayi'];
    $id_data_balita = $_POST['id_data_balita'];
    $keterangan = $_POST['keterangan'];

    if (isset($_POST['create'])) {
        $stmt = $koneksi->prepare("INSERT INTO orang_tua (nama_ortu, id_data_bayi, id_data_balita, keterangan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siis", $nama_ortu, $id_data_bayi, $id_data_balita, $keterangan);
    } elseif (isset($_POST['update'])) {
        $stmt = $koneksi->prepare("UPDATE orang_tua SET nama_ortu=?, id_data_bayi=?, id_data_balita=?, keterangan=? WHERE id_ortu=?");
        $stmt->bind_param("siisi", $nama_ortu, $id_data_bayi, $id_data_balita, $keterangan, $id);
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
    $stmt = $koneksi->prepare("DELETE FROM orang_tua WHERE id_ortu=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record successfully deleted.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM orang_tua";
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
                    <h3 class="fw-bold mb-3">Kelola Data Orang Tua</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Data Orang Tua</h4>
                                    <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#orangTuaModal" onclick="resetForm()">
                                        <i class="fa fa-plus"></i>
                                        Tambah Orang Tua
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="modal fade" id="orangTuaModal" tabindex="-1" aria-labelledby="orangTuaModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="orangTuaModalLabel">Tambah Orang Tua</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="orangTuaForm" method="POST" action="">
                                                    <input type="hidden" id="id" name="id">
                                                    <div class="mb-3">
                                                        <label for="nama_ortu" class="form-label">Nama Orang Tua</label>
                                                        <input type="text" class="form-control" id="nama_ortu" name="nama_ortu" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="id_data_bayi" class="form-label">ID Data Bayi</label>
                                                        <select class="form-control" id="id_data_bayi" name="id_data_bayi" required>
                                                            <option value="">Pilih Bayi</option>
                                                            <?php while ($row = $bayi_result->fetch_assoc()) { ?>
                                                                <option value="<?php echo $row['id_data_bayi']; ?>"><?php echo $row['nama_bayi']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="id_data_balita" class="form-label">ID Data Balita</label>
                                                        <select class="form-control" id="id_data_balita" name="id_data_balita" required>
                                                            <option value="">Pilih Balita</option>
                                                            <?php while ($row = $balita_result->fetch_assoc()) { ?>
                                                                <option value="<?php echo $row['id_data_balita']; ?>"><?php echo $row['nama_balita']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                        <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
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
                                                <th>Jenis Pelayanan</th>
                                                <th>ID Data Bayi</th>
                                                <th>ID Data Balita</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $row['id_ortu']; ?></td>
                                                        <td><?php echo $row['nama_ortu']; ?></td>
                                                        <td><?php echo $row['id_data_bayi']; ?></td>
                                                        <td><?php echo $row['id_data_balita']; ?></td>
                                                        <td><?php echo $row['keterangan']; ?></td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <button type="button" class="btn btn-link btn-primary btn-lg" onclick="editOrangTua(<?php echo $row['id_ortu']; ?>, '<?php echo $row['nama_ortu']; ?>', '<?php echo $row['id_data_bayi']; ?>', '<?php echo $row['id_data_balita']; ?>', '<?php echo $row['keterangan']; ?>')">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <a href="?delete=<?php echo $row['id_ortu']; ?>" class="btn btn-link btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </td>
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
</div>

<?php include 'layout/footer.php'; ?>

<script>
    function resetForm() {
        document.getElementById('orangTuaForm').reset();
        document.getElementById('orangTuaModalLabel').textContent = 'Tambah Orang Tua';
        document.getElementById('createBtn').classList.remove('d-none');
        document.getElementById('updateBtn').classList.add('d-none');
    }

    function editOrangTua(id, nama_ortu, id_data_bayi, id_data_balita, keterangan) {
        document.getElementById('id').value = id;
        document.getElementById('nama_ortu').value = nama_ortu;
        document.getElementById('id_data_bayi').value = id_data_bayi;
        document.getElementById('id_data_balita').value = id_data_balita;
        document.getElementById('keterangan').value = keterangan;
        document.getElementById('orangTuaModalLabel').textContent = 'Edit Orang Tua';
        document.getElementById('createBtn').classList.add('d-none');
        document.getElementById('updateBtn').classList.remove('d-none');
        var myModal = new bootstrap.Modal(document.getElementById('orangTuaModal'), {});
        myModal.show();
    }
</script>
