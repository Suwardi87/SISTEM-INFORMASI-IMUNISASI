<?php
include 'layout/header.php';
include '../koneksi.php';

// Handle form submission for create and update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $tgl_lhr = $_POST['tgl_lhr'];
    $tmp_lhr = $_POST['tmp_lhr'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    if (isset($_POST['create'])) {
        $stmt = $koneksi->prepare("INSERT INTO pengguna (nama_lengkap, alamat, tgl_lhr, tmp_lhr, username, password, level) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nama_lengkap, $alamat, $tgl_lhr, $tmp_lhr, $username, $password, $level);
    } elseif (isset($_POST['update'])) {
        $stmt = $koneksi->prepare("UPDATE pengguna SET nama_lengkap=?, alamat=?, tgl_lhr=?, tmp_lhr=?, username=?, password=?, level=? WHERE id_pengguna=?");
        $stmt->bind_param("sssssssi", $nama_lengkap, $alamat, $tgl_lhr, $tmp_lhr, $username, $password, $level, $id);
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
    $stmt = $koneksi->prepare("DELETE FROM pengguna WHERE id_pengguna=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record successfully deleted.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM pengguna";
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
                    <h3 class="fw-bold mb-3">Kelola Pengguna</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Data Pengguna</h4>
                                    <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#penggunaModal" onclick="resetForm()">
                                        <i class="fa fa-plus"></i>
                                        Tambah Pengguna
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="modal fade" id="penggunaModal" tabindex="-1" aria-labelledby="penggunaModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="penggunaModalLabel">Tambah Pengguna</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="penggunaForm" method="POST" action="">
                                                    <input type="hidden" id="id" name="id">
                                                    <div class="mb-3">
                                                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="alamat" class="form-label">Alamat</label>
                                                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tgl_lhr" class="form-label">Tanggal Lahir</label>
                                                        <input type="date" class="form-control" id="tgl_lhr" name="tgl_lhr" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tmp_lhr" class="form-label">Tempat Lahir</label>
                                                        <input type="text" class="form-control" id="tmp_lhr" name="tmp_lhr" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="username" class="form-label">Username</label>
                                                        <input type="text" class="form-control" id="username" name="username" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">Password</label>
                                                        <input type="password" class="form-control" id="password" name="password" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="level" class="form-label">Level</label>
                                                        <select class="form-control" id="level" name="level" required>
                                                            <option value="admin">Admin</option>
                                                            <option value="kader">Kader</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary" name="create" id="createBtn">Tambah</button>
                                                    <button type="submit" class="btn btn-primary d-none" name="update" id="updateBtn">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="penggunaTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Lengkap</th>
                                                <th>Alamat</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Tempat Lahir</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Level</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $row['id_pengguna']; ?></td>
                                                        <td><?php echo $row['nama_lengkap']; ?></td>
                                                        <td><?php echo $row['alamat']; ?></td>
                                                        <td><?php echo $row['tgl_lhr']; ?></td>
                                                        <td><?php echo $row['tmp_lhr']; ?></td>
                                                        <td><?php echo $row['username']; ?></td>
                                                        <td><?php echo $row['password']; ?></td>
                                                        <td><?php echo $row['level']; ?></td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <button type="button" class="btn btn-link btn-primary btn-lg" onclick="editPengguna(<?php echo $row['id_pengguna']; ?>, '<?php echo $row['nama_lengkap']; ?>', '<?php echo $row['alamat']; ?>', '<?php echo $row['tgl_lhr']; ?>', '<?php echo $row['tmp_lhr']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['password']; ?>', '<?php echo $row['level']; ?>')">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <a href="?delete=<?php echo $row['id_pengguna']; ?>" class="btn btn-link btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='9'>Tidak ada data</td></tr>";
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
        document.getElementById('penggunaForm').reset();
        document.getElementById('penggunaModalLabel').textContent = 'Tambah Pengguna';
        document.getElementById('createBtn').classList.remove('d-none');
        document.getElementById('updateBtn').classList.add('d-none');
    }

    function editPengguna(id, nama_lengkap, alamat, tgl_lhr, tmp_lhr, username, password, level) {
        document.getElementById('id').value = id;
        document.getElementById('nama_lengkap').value = nama_lengkap;
        document.getElementById('alamat').value = alamat;
        document.getElementById('tgl_lhr').value = tgl_lhr;
        document.getElementById('tmp_lhr').value = tmp_lhr;
        document.getElementById('username').value = username;
        document.getElementById('password').value = password;
        document.getElementById('level').value = level;
        document.getElementById('penggunaModalLabel').textContent = 'Edit Pengguna';
        document.getElementById('createBtn').classList.add('d-none');
        document.getElementById('updateBtn').classList.remove('d-none');
        var myModal = new bootstrap.Modal(document.getElementById('penggunaModal'), {});
        myModal.show();
    }
</script>