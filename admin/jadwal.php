<?php
include 'layout/header.php';
include '../koneksi.php';

// Handle form submission for create and update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $tgl = $_POST['tgl'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $lokasi = $_POST['lokasi'];
    $kegiatan = $_POST['kegiatan'];
    
    if (isset($_POST['create'])) {
        $stmt = $koneksi->prepare("INSERT INTO jadwal (tgl, waktu_mulai, waktu_selesai, lokasi, kegiatan) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $tgl, $waktu_mulai, $waktu_selesai, $lokasi, $kegiatan);
    } elseif (isset($_POST['update'])) {
        $stmt = $koneksi->prepare("UPDATE jadwal SET tgl=?, waktu_mulai=?, waktu_selesai=?, lokasi=?, kegiatan=? WHERE id_jadwal=?");
        $stmt->bind_param("sssssi", $tgl, $waktu_mulai, $waktu_selesai, $lokasi, $kegiatan, $id);
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
    $stmt = $koneksi->prepare("DELETE FROM jadwal WHERE id_jadwal=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record successfully deleted.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM jadwal";
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
                    <h3 class="fw-bold mb-3">Kelola Jadwal</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Data Jadwal</h4>
                                    <button type="button" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#jadwalModal" onclick="resetForm()">
                                        <i class="fa fa-plus"></i>
                                        Tambah Jadwal
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="modal fade" id="jadwalModal" tabindex="-1" aria-labelledby="jadwalModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="jadwalModalLabel">Tambah Jadwal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="jadwalForm" method="POST" action="">
                                                    <input type="hidden" id="id" name="id">
                                                    <div class="mb-3">
                                                        <label for="tgl" class="form-label">Tanggal</label>
                                                        <input type="date" class="form-control" id="tgl" name="tgl" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                                        <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="lokasi" class="form-label">Lokasi</label>
                                                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="kegiatan" class="form-label">Kegiatan</label>
                                                        <input type="text" class="form-control" id="kegiatan" name="kegiatan" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary" name="create" id="createBtn">Tambah</button>
                                                    <button type="submit" class="btn btn-primary d-none" name="update" id="updateBtn">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                                                        <td><?php echo $row['tgl']; ?></td>
                                                        <td><?php echo $row['waktu_mulai']; ?></td>
                                                        <td><?php echo $row['waktu_selesai']; ?></td>
                                                        <td><?php echo $row['lokasi']; ?></td>
                                                        <td><?php echo $row['kegiatan']; ?></td>
                                                        <td>
                                                            <div class="form-button-action d-flex">
                                                                <button type="button" class="btn btn-link btn-primary text-light" onclick="editJadwal(<?php echo $row['id_jadwal']; ?>, '<?php echo $row['tgl']; ?>', '<?php echo $row['waktu_mulai']; ?>', '<?php echo $row['waktu_selesai']; ?>', '<?php echo $row['lokasi']; ?>', '<?php echo $row['kegiatan']; ?>')">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <a href="?delete=<?php echo $row['id_jadwal']; ?>" class="btn btn-link text-light btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
        document.getElementById('jadwalForm').reset();
        document.getElementById('jadwalModalLabel').textContent = 'Tambah Jadwal';
        document.getElementById('createBtn').classList.remove('d-none');
        document.getElementById('updateBtn').classList.add('d-none');
    }

    function editJadwal(id, tgl, waktu_mulai, waktu_selesai, lokasi, kegiatan) {
        document.getElementById('id').value = id;
        document.getElementById('tgl').value = tgl;
        document.getElementById('waktu_mulai').value = waktu_mulai;
        document.getElementById('waktu_selesai').value = waktu_selesai;
        document.getElementById('lokasi').value = lokasi;
        document.getElementById('kegiatan').value = kegiatan;
        document.getElementById('jadwalModalLabel').textContent = 'Edit Jadwal';
        document.getElementById('createBtn').classList.add('d-none');
        document.getElementById('updateBtn').classList.remove('d-none');
        var myModal = new bootstrap.Modal(document.getElementById('jadwalModal'), {});
        myModal.show();
    }
</script>
