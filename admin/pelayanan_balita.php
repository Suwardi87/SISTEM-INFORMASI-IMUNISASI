<?php
include 'layout/header.php';
include '../koneksi.php';

// Fetch id_data_balita options
$data_balita_query = "SELECT id_data_balita, nama_balita FROM data_balita";
$data_balita_result = $koneksi->query($data_balita_query);

// Fetch data_balita options
$data_balita_options = [];
while ($row = $data_balita_result->fetch_assoc()) {
    $data_balita_options[] = $row;
}

// Fetch id_jadwal options
$jadwal_query = "SELECT id_jadwal, lokasi FROM jadwal";
$jadwal_result = $koneksi->query($jadwal_query);

// Handle form submission for create and update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $id_data_balita = $_POST['id_data_balita'];
    $nama_balita = $_POST['nama_balita'];
    $id_jadwal = $_POST['id_jadwal'];
    $lokasi = $_POST['lokasi'];
    $berat_badan = $_POST['berat_badan'];
    $tinggi_badan = $_POST['tinggi_badan'];
    $vitamin_a = $_POST['vitamin_a'];
    $keterangan = $_POST['keterangan'];

    if (isset($_POST['create'])) {
        $stmt = $koneksi->prepare("INSERT INTO pelayanan_balita (id_data_balita, nama_balita, id_jadwal, lokasi, berat_badan, tinggi_badan, vitamin_a, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssddss", $id_data_balita, $nama_balita, $id_jadwal, $lokasi, $berat_badan, $tinggi_badan, $vitamin_a, $keterangan);
    } elseif (isset($_POST['update'])) {
        $stmt = $koneksi->prepare("UPDATE pelayanan_balita SET id_data_balita=?, nama_balita=?, id_jadwal=?, lokasi=?, berat_badan=?, tinggi_badan=?, vitamin_a=?, keterangan=? WHERE id_pelayanan_balita=?");
        $stmt->bind_param("isssddssi", $id_data_balita, $nama_balita, $id_jadwal, $lokasi, $berat_badan, $tinggi_badan, $vitamin_a, $keterangan, $id);
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
                                                    <select class="form-control" id="id_data_balita" name="id_data_balita" onchange="fetchNamaBalita()" required>
                                                        <option value="">Pilih ID Data Balita</option>
                                                        <?php foreach ($data_balita_options as $option) : ?>
                                                            <option value="<?php echo $option['id_data_balita']; ?>"><?php echo $option['id_data_balita'] . ' - ' . $option['nama_balita']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_balita" class="form-label">Nama Balita</label>
                                                    <input type="text" class="form-control" id="nama_balita" name="nama_balita" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="id_jadwal" class="form-label">ID Jadwal</label>
                                                    <select class="form-control" id="id_jadwal" name="id_jadwal" onchange="fetchLokasi()" required>
                                                        <option value="">Pilih ID Jadwal</option>
                                                        <?php
                                                        if ($jadwal_result->num_rows > 0) {
                                                            while ($row = $jadwal_result->fetch_assoc()) {
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
                                                    <label for="berat_badan" class="form-label">Berat Badan</label>
                                                    <input type="number" class="form-control" id="berat_badan" name="berat_badan" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
                                                    <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="vitamin_a" class="form-label">Vitamin A</label>
                                                    <select class="form-control" id="vitamin_a" name="vitamin_a" required>
                                                        <option value="Iya">Iya</option>
                                                        <option value="Tidak">Tidak</option>
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
                                <table id="pelayananBalitaTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="d-none">ID Data Balita</th>
                                            <th>Nama Balita</th>
                                            <th class="d-none">ID Jadwal</th>
                                            <th>Lokasi</th>
                                            <th>Berat Badan</th>
                                            <th>Tinggi Badan</th>
                                            <th>Vitamin A</th>
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
                                                    <td class="d-none"><?php echo $row['id_data_balita']; ?></td>
                                                    <td><?php echo $row['nama_balita']; ?></td>
                                                    <td class="d-none"><?php echo $row['id_jadwal']; ?></td>
                                                    <td><?php echo $row['lokasi']; ?></td>
                                                    <td><?php echo $row['berat_badan'].' kg'; ?></td>
                                                    <td><?php echo $row['tinggi_badan'].' cm'; ?></td>
                                                    <td><?php echo $row['vitamin_a']; ?></td>
                                                    <td><?php echo $row['keterangan']; ?></td>
                                                    <td>
                                                        <div class="form-button-action d-flex">
                                                            <button class="btn btn-primary btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#pelayananBalitaModal" onclick="editPelayananBalita(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                                                <i class="fa fa-edit text-light"></i>
                                                            </button>
                                                            <a href="?delete=<?php echo $row['id_pelayanan_balita']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')">
                                                                <i class="fa fa-times text-light"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='10' class='text-center'>No records found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include 'layout/footer.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function fetchNamaBalita() {
        const selectedId = document.getElementById('id_data_balita').value;
        const namaBalita = document.querySelector(`#id_data_balita option[value="${selectedId}"]`).textContent.split(' - ')[1];
        document.getElementById('nama_balita').value = namaBalita;
    }

    function fetchLokasi() {
        const selectedId = document.getElementById('id_jadwal').value;
        const lokasi = document.querySelector(`#id_jadwal option[value="${selectedId}"]`).textContent.split(' - ')[1];
        document.getElementById('lokasi').value = lokasi;
    }

    function resetForm() {
        document.getElementById('pelayananBalitaForm').reset();
        document.getElementById('id').value = '';
        document.getElementById('createBtn').classList.remove('d-none');
        document.getElementById('updateBtn').classList.add('d-none');
        document.getElementById('pelayananBalitaModalLabel').textContent = 'Tambah Pelayanan Balita';
    }

    function editPelayananBalita(data) {
        document.getElementById('pelayananBalitaModalLabel').innerText = "Edit Pelayanan Balita";
        document.getElementById('createBtn').classList.add('d-none');
        document.getElementById('updateBtn').classList.remove('d-none');

        document.getElementById('id').value = data.id_pelayanan_balita;
        document.getElementById('id_data_balita').value = data.id_data_balita;
        document.getElementById('nama_balita').value = data.nama_balita;
        document.getElementById('id_jadwal').value = data.id_jadwal;
        document.getElementById('lokasi').value = data.lokasi;
        document.getElementById('berat_badan').value = data.berat_badan;
        document.getElementById('tinggi_badan').value = data.tinggi_badan;
        document.getElementById('vitamin_a').value = data.vitamin_a;
        document.getElementById('keterangan').value = data.keterangan;
    }
</script>
