<?php
include 'layout/header.php';
include '../koneksi.php';

// Handle form submission for create and update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $nik_bayi = $_POST['nik_bayi'];
    $nama_bayi = $_POST['nama_bayi'];
    $tgl_lhr = $_POST['tgl_lhr'];
    $jns_kel = $_POST['jns_kel'];
    $nik_ayah = $_POST['nik_ayah'];
    $nama_ayah = $_POST['nama_ayah'];
    $nik_ibu = $_POST['nik_ibu'];
    $nama_ibu = $_POST['nama_ibu'];
    $alamat = $_POST['alamat'];
    $buku_kia = $_POST['buku_kia'];
    $berat_lhr = $_POST['berat_lhr'];
    $tinggi_lhr = $_POST['tinggi_lhr'];
    $waktu_kunjungan = $_POST['waktu_kunjungan'];
    
    if (isset($_POST['create'])) {
        $stmt = $koneksi->prepare("INSERT INTO data_bayi (nik_bayi, nama_bayi, tgl_lhr, jns_kel, nik_ayah, nama_ayah, nik_ibu, nama_ibu, alamat, buku_kia, berat_lhr, tinggi_lhr, waktu_kunjungan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssss", $nik_bayi, $nama_bayi, $tgl_lhr, $jns_kel, $nik_ayah, $nama_ayah, $nik_ibu, $nama_ibu, $alamat, $buku_kia, $berat_lhr, $tinggi_lhr, $waktu_kunjungan);
    } elseif (isset($_POST['update'])) {
        $stmt = $koneksi->prepare("UPDATE data_bayi SET nik_bayi=?, nama_bayi=?, tgl_lhr=?, jns_kel=?, nik_ayah=?, nama_ayah=?, nik_ibu=?, nama_ibu=?, alamat=?, buku_kia=?, berat_lhr=?, tinggi_lhr=?, waktu_kunjungan=? WHERE id_data_bayi=?");
        $stmt->bind_param("sssssssssssssi", $nik_bayi, $nama_bayi, $tgl_lhr, $jns_kel, $nik_ayah, $nama_ayah, $nik_ibu, $nama_ibu, $alamat, $buku_kia, $berat_lhr, $tinggi_lhr, $waktu_kunjungan, $id);
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
    $stmt = $koneksi->prepare("DELETE FROM data_bayi WHERE id_data_bayi=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record successfully deleted.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM data_bayi";
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
                    <h3 class="fw-bold mb-3">Kelola Data Bayi</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Data Bayi</h4>
                                    <button type="button" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#bayiModal" onclick="resetForm()">
                                        <i class="fa fa-plus"></i>
                                        Tambah  Bayi
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="modal fade" id="bayiModal" tabindex="-1" aria-labelledby="bayiModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="bayiModalLabel">Tambah Bayi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="bayiForm" method="POST" action="">
                                                    <input type="hidden" id="id" name="id">
                                                    <div class="mb-3">
                                                        <label for="nik_bayi" class="form-label">NIK Bayi</label>
                                                        <input type="text" class="form-control" id="nik_bayi" name="nik_bayi" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nama_bayi" class="form-label">Nama Bayi</label>
                                                        <input type="text" class="form-control" id="nama_bayi" name="nama_bayi" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tgl_lhr" class="form-label">Tanggal Lahir</label>
                                                        <input type="date" class="form-control" id="tgl_lhr" name="tgl_lhr" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="jns_kel" class="form-label">Jenis Kelamin</label>
                                                        <select class="form-control" id="jns_kel" name="jns_kel" required>
                                                            <option value="laki-laki">Laki-laki</option>
                                                            <option value="perempuan">Perempuan</option>
                                                        </select>
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
                                                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="buku_kia" class="form-label">Buku KIA</label>
                                                        <select class="form-control" id="buku_kia" name="buku_kia" required>
                                                            <option value="Ada">Ada</option>
                                                            <option value="Tidak Ada">Tidak Ada</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="berat_lhr" class="form-label">Berat Lahir</label>
                                                        <input type="text" class="form-control" id="berat_lhr" name="berat_lhr" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tinggi_lhr" class="form-label">Tinggi Lahir</label>
                                                        <input type="text" class="form-control" id="tinggi_lhr" name="tinggi_lhr" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="waktu_kunjungan" class="form-label">Waktu Kunjungan</label>
                                                        <select class="form-control" id="waktu_kunjungan" name="waktu_kunjungan" required>
                                                            <option value="Pagi">Pagi</option>
                                                            <option value="Sore">Sore</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" name="create" id="createBtn" class="btn btn-primary">Tambah</button>
                                                    <button type="submit" name="update" id="updateBtn" class="btn btn-primary d-none">Ubah</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
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
                                                <th>Aksi</th>
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
                                                    <td>
                                                        <button class='btn btn-warning btn-sm' onclick='editBayi(".json_encode($row).")'>Ubah</button>
                                                        <a href='?delete={$row['id_data_bayi']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                                                    </td>
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

<?php include 'layout/footer.php'; ?>

<script>
function editBayi(data) {
    document.getElementById('id').value = data.id_data_bayi;
    document.getElementById('nik_bayi').value = data.nik_bayi;
    document.getElementById('nama_bayi').value = data.nama_bayi;
    document.getElementById('tgl_lhr').value = data.tgl_lhr;
    document.getElementById('jns_kel').value = data.jns_kel;
    document.getElementById('nik_ayah').value = data.nik_ayah;
    document.getElementById('nama_ayah').value = data.nama_ayah;
    document.getElementById('nik_ibu').value = data.nik_ibu;
    document.getElementById('nama_ibu').value = data.nama_ibu;
    document.getElementById('alamat').value = data.alamat;
    document.getElementById('buku_kia').value = data.buku_kia;
    document.getElementById('berat_lhr').value = data.berat_lhr;
    document.getElementById('tinggi_lhr').value = data.tinggi_lhr;
    document.getElementById('waktu_kunjungan').value = data.waktu_kunjungan;

    document.getElementById('bayiModalLabel').textContent = 'Ubah Data Bayi';
    document.getElementById('createBtn').classList.add('d-none');
    document.getElementById('updateBtn').classList.remove('d-none');

    var bayiModal = new bootstrap.Modal(document.getElementById('bayiModal'));
    bayiModal.show();
}

function resetForm() {
    document.getElementById('id').value = '';
    document.getElementById('bayiForm').reset();
    document.getElementById('bayiModalLabel').textContent = 'Tambah Data Bayi';
    document.getElementById('createBtn').classList.remove('d-none');
    document.getElementById('updateBtn').classList.add('d-none');
}
</script>
