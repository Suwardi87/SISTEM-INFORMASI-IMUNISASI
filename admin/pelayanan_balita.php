<?php
include 'layout/header.php';
include '../koneksi.php';

// Fetch id_data_balita options
$data_balita_query = "SELECT id_data_balita, nama_balita FROM data_balita";
$data_balita_result = $koneksi->query($data_balita_query);
$data_balita_options = [];
if ($data_balita_result->num_rows > 0) {
    while ($row = $data_balita_result->fetch_assoc()) {
        $data_balita_options[] = $row;
    }
}

// Handle form submission for create and update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $id_data_balita = $_POST['id_data_balita'];
    $nama_balita = $_POST['nama_balita'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $berat_badan = $_POST['berat_badan'];

    if (isset($_POST['create'])) {
        $stmt = $koneksi->prepare("INSERT INTO pelayanan_balita (id_data_balita, nama_balita, jenis_kelamin, tgl_lahir, berat_badan) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $id_data_balita, $nama_balita, $jenis_kelamin, $tgl_lahir, $berat_badan);
    } elseif (isset($_POST['update'])) {
        $stmt = $koneksi->prepare("UPDATE pelayanan_balita SET id_data_balita=?, nama_balita=?, jenis_kelamin=?, tgl_lahir=?, berat_badan=? WHERE id_pelayanan_balita=?");
        $stmt->bind_param("isssii", $id_data_balita, $nama_balita, $jenis_kelamin, $tgl_lahir, $berat_badan, $id);
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
    $stmt = $koneksi->prepare("DELETE FROM pelayanan_balita WHERE id_pelayanan_balita=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record successfully deleted.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM pelayanan_balita";
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
                    <h3 class="fw-bold mb-3">Kelola Pelayanan Balita</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Data Pelayanan Balita</h4>
                                    <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#pelayananBalitaModal" onclick="resetForm()">
                                        <i class="fa fa-plus"></i>
                                        Tambah Pelayanan Balita
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="modal fade" id="pelayananBalitaModal" tabindex="-1" aria-labelledby="pelayananBalitaModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pelayananBalitaModalLabel">Tambah Pelayanan Balita</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="pelayananBalitaForm" method="POST" action="">
                                                <input type="hidden" id="id" name="id">
                                                <div class="mb-3">
                                                    <label for="id_data_balita" class="form-label">ID Data Balita</label>
                                                    <select class="form-control" id="id_data_balita" name="id_data_balita" required>
                                                        <option value="">Pilih ID Data Balita</option>
                                                        <?php foreach ($data_balita_options as $option): ?>
                                                            <option value="<?php echo $option['id_data_balita']; ?>"><?php echo $option['id_data_balita'] . ' - ' . $option['nama_balita']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_balita" class="form-label">Nama Balita</label>
                                                    <input type="text" class="form-control" id="nama_balita" name="nama_balita" required>
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
                                                    <label for="berat_badan" class="form-label">Berat Badan</label>
                                                    <input type="number" class="form-control" id="berat_badan" name="berat_badan" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary" name="create" id="createBtn">Tambah</button>
                                                <button type="submit" class="btn btn-primary d-none" name="update" id="updateBtn">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="pelayananBalitaTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ID Data Balita</th>
                                            <th>Nama Balita</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Berat Badan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $row['id_pelayanan_balita']; ?></td>
                                                    <td><?php echo $row['id_data_balita']; ?></td>
                                                    <td><?php echo $row['nama_balita']; ?></td>
                                                    <td><?php echo $row['jenis_kelamin']; ?></td>
                                                    <td><?php echo $row['tgl_lahir']; ?></td>
                                                    <td><?php echo $row['berat_badan']; ?></td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <button type="button" class="btn btn-link btn-primary btn-lg" onclick="editPelayananBalita(<?php echo $row['id_pelayanan_balita']; ?>, '<?php echo $row['id_data_balita']; ?>', '<?php echo $row['nama_balita']; ?>', '<?php echo $row['jenis_kelamin']; ?>', '<?php echo $row['tgl_lahir']; ?>', '<?php echo $row['berat_badan']; ?>')">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <a href="?delete=<?php echo $row['id_pelayanan_balita']; ?>" class="btn btn-link btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
        document.getElementById('pelayananBalitaForm').reset();
        document.getElementById('pelayananBalitaModalLabel').textContent = 'Tambah Pelayanan Balita';
        document.getElementById('createBtn').classList.remove('d-none');
        document.getElementById('updateBtn').classList.add('d-none');
    }

    function editPelayananBalita(id, id_data_balita, nama_balita, jenis_kelamin, tgl_lahir, berat_badan) {
        document.getElementById('id').value = id;
        document.getElementById('id_data_balita').value = id_data_balita;
        document.getElementById('nama_balita').value = nama_balita;
        document.getElementById('jenis_kelamin').value = jenis_kelamin;
        document.getElementById('tgl_lahir').value = tgl_lahir;
        document.getElementById('berat_badan').value = berat_badan;
        document.getElementById('pelayananBalitaModalLabel').textContent = 'Edit Pelayanan Balita';
        document.getElementById('createBtn').classList.add('d-none');
        document.getElementById('updateBtn').classList.remove('d-none');
        var myModal = new bootstrap.Modal(document.getElementById('pelayananBalitaModal'), {});
        myModal.show();
    }
</script>
