<?php
include 'layout/header.php';
include '../koneksi.php';

// Fetch available id_data_bayi options
$data_bayi_options = $koneksi->query("SELECT id_data_bayi, nama_bayi FROM data_bayi");

// Handle form submission for create and update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $id_data_bayi = $_POST['id_data_bayi'];
    $nama_bayi = $_POST['nama_bayi'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $berat_lahir = $_POST['berat_lahir'];
    
    if (isset($_POST['create'])) {
        $stmt = $koneksi->prepare("INSERT INTO pelayanan_bayi (id_data_bayi, nama_bayi, jenis_kelamin, tgl_lahir, berat_lahir) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $id_data_bayi, $nama_bayi, $jenis_kelamin, $tgl_lahir, $berat_lahir);
    } elseif (isset($_POST['update'])) {
        $stmt = $koneksi->prepare("UPDATE pelayanan_bayi SET id_data_bayi=?, nama_bayi=?, jenis_kelamin=?, tgl_lahir=?, berat_lahir=? WHERE id_pelayanan_bayi=?");
        $stmt->bind_param("isssii", $id_data_bayi, $nama_bayi, $jenis_kelamin, $tgl_lahir, $berat_lahir, $id);
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
    $stmt = $koneksi->prepare("DELETE FROM pelayanan_bayi WHERE id_pelayanan_bayi=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record successfully deleted.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM pelayanan_bayi";
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
                    <h3 class="fw-bold mb-3">Kelola Pelayanan Bayi</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Data Pelayanan Bayi</h4>
                                    <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#pelayananBayiModal" onclick="resetForm()">
                                        <i class="fa fa-plus"></i>
                                        Tambah Pelayanan Bayi
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="modal fade" id="pelayananBayiModal" tabindex="-1" aria-labelledby="pelayananBayiModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="pelayananBayiModalLabel">Tambah Pelayanan Bayi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="pelayananBayiForm" method="POST" action="">
                                                    <input type="hidden" id="id" name="id">
                                                    <div class="mb-3">
                                                        <label for="id_data_bayi" class="form-label">ID Data Bayi</label>
                                                        <select class="form-control" id="id_data_bayi" name="id_data_bayi" required>
                                                            <option value="">Pilih ID Data Bayi</option>
                                                            <?php
                                                            if ($data_bayi_options->num_rows > 0) {
                                                                while ($row = $data_bayi_options->fetch_assoc()) {
                                                                    echo "<option value='" . $row['id_data_bayi'] . "'>" . $row['id_data_bayi'] . " - " . $row['nama_bayi'] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nama_bayi" class="form-label">Nama Bayi</label>
                                                        <input type="text" class="form-control" id="nama_bayi" name="nama_bayi" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                        <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="berat_lahir" class="form-label">Berat Lahir</label>
                                                        <input type="number" class="form-control" id="berat_lahir" name="berat_lahir" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary" name="create" id="createBtn">Tambah</button>
                                                    <button type="submit" class="btn btn-primary d-none" name="update" id="updateBtn">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="pelayananBayiTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>ID Data Bayi</th>
                                                <th>Nama Bayi</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Berat Lahir</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['id_pelayanan_bayi']; ?></td>
                                                        <td><?php echo $row['id_data_bayi']; ?></td>
                                                        <td><?php echo $row['nama_bayi']; ?></td>
                                                        <td><?php echo $row['jenis_kelamin']; ?></td>
                                                        <td><?php echo $row['tgl_lahir']; ?></td>
                                                        <td><?php echo $row['berat_lahir']; ?></td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <button type="button" class="btn btn-link btn-primary btn-lg" onclick="editPelayananBayi(<?php echo $row['id_pelayanan_bayi']; ?>, '<?php echo $row['id_data_bayi']; ?>', '<?php echo $row['nama_bayi']; ?>', '<?php echo $row['jenis_kelamin']; ?>', '<?php echo $row['tgl_lahir']; ?>', '<?php echo $row['berat_lahir']; ?>')">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <a href="?delete=<?php echo $row['id_pelayanan_bayi']; ?>" class="btn btn-link btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </td>
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
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

<script>
    function resetForm() {
        document.getElementById('pelayananBayiForm').reset();
        document.getElementById('pelayananBayiModalLabel').textContent = 'Tambah Pelayanan Bayi';
        document.getElementById('createBtn').classList.remove('d-none');
        document.getElementById('updateBtn').classList.add('d-none');
    }

    function editPelayananBayi(id, id_data_bayi, nama_bayi, jenis_kelamin, tgl_lahir, berat_lahir) {
        document.getElementById('id').value = id;
        document.getElementById('id_data_bayi').value = id_data_bayi;
        document.getElementById('nama_bayi').value = nama_bayi;
        document.getElementById('jenis_kelamin').value = jenis_kelamin;
        document.getElementById('tgl_lahir').value = tgl_lahir;
        document.getElementById('berat_lahir').value = berat_lahir;
        document.getElementById('pelayananBayiModalLabel').textContent = 'Edit Pelayanan Bayi';
        document.getElementById('createBtn').classList.add('d-none');
        document.getElementById('updateBtn').classList.remove('d-none');
        var myModal = new bootstrap.Modal(document.getElementById('pelayananBayiModal'), {});
        myModal.show();
    }
</script>
