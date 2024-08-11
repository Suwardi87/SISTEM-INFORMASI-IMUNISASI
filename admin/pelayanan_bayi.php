<?php
include 'layout/header.php';
include '../koneksi.php';

// Handle form submission for create and update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $id_data_bayi = $_POST['id_data_bayi'];
    $nama_bayi = $_POST['nama_bayi'];
    $id_jadwal = $_POST['id_jadwal'];
    $lokasi = $_POST['lokasi'];
    $pilihan_imunisasi = $_POST['pilihan_imunisasi'];
    $keterangan = $_POST['keterangan'];

    if (isset($_POST['create'])) {
        $stmt = $koneksi->prepare("INSERT INTO pelayanan_bayi (id_data_bayi, nama_bayi, id_jadwal, lokasi, pilihan_imunisasi, keterangan) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isisss", $id_data_bayi, $nama_bayi, $id_jadwal, $lokasi, $pilihan_imunisasi, $keterangan);
    } elseif (isset($_POST['update'])) {
        $stmt = $koneksi->prepare("UPDATE pelayanan_bayi SET id_data_bayi=?, nama_bayi=?, id_jadwal=?, lokasi=?, pilihan_imunisasi=?, keterangan=? WHERE id_pelayanan_bayi=?");
        $stmt->bind_param("isisssi", $id_data_bayi, $nama_bayi, $id_jadwal, $lokasi, $pilihan_imunisasi, $keterangan, $id);
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

// Fetch all data from pelayanan_bayi table
$sql = "SELECT * FROM pelayanan_bayi";
$result = $koneksi->query($sql);

// Fetch available id_data_bayi options
$data_bayi_options = $koneksi->query("SELECT id_data_bayi, nama_bayi FROM data_bayi");

// Fetch available id_jadwal options
$jadwal_options = $koneksi->query("SELECT id_jadwal, lokasi FROM jadwal");

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
                                                        <select class="form-control" id="id_data_bayi" name="id_data_bayi" onchange="fetchNamaBayi()" required>
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
                                                        <input type="text" class="form-control" id="nama_bayi" name="nama_bayi" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="id_jadwal" class="form-label">ID Jadwal</label>
                                                        <select class="form-control" id="id_jadwal" name="id_jadwal" onchange="fetchLokasi()" required>
                                                            <option value="">Pilih ID Jadwal</option>
                                                            <?php
                                                            if ($jadwal_options->num_rows > 0) {
                                                                while ($row = $jadwal_options->fetch_assoc()) {
                                                                    echo "<option value='" . $row['id_jadwal'] . "'>" . $row['id_jadwal'] . " - " . $row['lokasi'] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="lokasi" class="form-label">Lokasi</label>
                                                        <input type="text" class="form-control" id="lokasi" name="lokasi" readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="pilihan_imunisasi" class="form-label">Pilihan Imunisasi</label>
                                                        <select class="form-control" id="pilihan_imunisasi" name="pilihan_imunisasi" required>
                                                            <option value="Vitamin A">Vitamin A</option>
                                                            <option value="HBO">HBO</option>
                                                            <option value="Polio 1">Polio 1</option>
                                                            <option value="Polio 2">Polio 2</option>
                                                            <option value="Polio 3">Polio 3</option>
                                                            <option value="Campak/MR">Campak/MR</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                        <input type="text" class="form-control" id="keterangan" name="keterangan" required>
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
                                                <th>No</th>
                                                <th>ID Data Bayi</th>
                                                <th>Nama Bayi</th>
                                                <th>ID Jadwal</th>
                                                <th>Lokasi</th>
                                                <th>Pilihan Imunisasi</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                $no = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $no++;
                                            ?>
                                                    <tr>
                                                        <td><?php echo $no; ?></td>
                                                        <td><?php echo $row['id_data_bayi']; ?></td>
                                                        <td><?php echo $row['nama_bayi']; ?></td>
                                                        <td><?php echo $row['id_jadwal']; ?></td>
                                                        <td><?php echo $row['lokasi']; ?></td>
                                                        <td><?php echo $row['pilihan_imunisasi']; ?></td>
                                                        <td><?php echo $row['keterangan']; ?></td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <button type="button" class="btn btn-link btn-warning" data-bs-toggle="modal" data-bs-target="#pelayananBayiModal" onclick="editData(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <a href="?delete=<?php echo $row['id_pelayanan_bayi']; ?>" class="btn btn-link btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='8' class='text-center'>No data available</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <script>
                                    function fetchNamaBayi() {
                                        const selectedId = document.getElementById('id_data_bayi').value;
                                        const namaBayi = document.querySelector(`#id_data_bayi option[value="${selectedId}"]`).textContent.split(' - ')[1];
                                        document.getElementById('nama_bayi').value = namaBayi;
                                    }

                                    function fetchLokasi() {
                                        const selectedId = document.getElementById('id_jadwal').value;
                                        const lokasi = document.querySelector(`#id_jadwal option[value="${selectedId}"]`).textContent.split(' - ')[1];
                                        document.getElementById('lokasi').value = lokasi;
                                    }

                                    function editData(data) {
                                        document.getElementById('id').value = data.id_pelayanan_bayi;
                                        document.getElementById('id_data_bayi').value = data.id_data_bayi;
                                        document.getElementById('nama_bayi').value = data.nama_bayi;
                                        document.getElementById('id_jadwal').value = data.id_jadwal;
                                        document.getElementById('lokasi').value = data.lokasi;
                                        document.getElementById('pilihan_imunisasi').value = data.pilihan_imunisasi;
                                        document.getElementById('keterangan').value = data.keterangan;

                                        document.getElementById('createBtn').classList.add('d-none');
                                        document.getElementById('updateBtn').classList.remove('d-none');
                                    }

                                    function resetForm() {
                                        document.getElementById('pelayananBayiForm').reset();
                                        document.getElementById('createBtn').classList.remove('d-none');
                                        document.getElementById('updateBtn').classList.add('d-none');
                                    }
                                </script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
