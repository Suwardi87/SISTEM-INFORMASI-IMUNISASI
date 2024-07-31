<?php
include 'layout/header.php';
include '../koneksi.php';

// Handle form submission for create and update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Hash the password
    $level = $_POST['level'];

    if (isset($_POST['create'])) {
        // Create new user in 'user' table using prepared statements
        $stmt_user = $koneksi->prepare("INSERT INTO admin (nama, username, password, level) VALUES (?, ?, ?, ?)");
        $stmt_user->bind_param("ssss", $nama, $username, $password, $level);

        if ($stmt_user->execute()) {
            if ($level == 'wisatawan') {
                // Create new wisatawan
                $stmt = $koneksi->prepare("INSERT INTO wisatawan (nama, username, password) VALUES (?, ?, ?)");
            } elseif ($level == 'staff') {
                // Create new staffPengelola
                $stmt = $koneksi->prepare("INSERT INTO staffPengelola (nama, username, password) VALUES (?, ?, ?)");
            }

            if (isset($stmt)) {
                $stmt->bind_param("sss", $nama, $username, $password);
                if ($stmt->execute()) {
                    echo "New record created successfully in both user and $level tables";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        } else {
            echo "Error: " . $stmt_user->error;
        }
        $stmt_user->close();
    } elseif (isset($_POST['update'])) {
        // Update existing user in 'user' table using prepared statements
        $stmt_user = $koneksi->prepare("UPDATE admin SET nama=?, username=?, password=?, level=? WHERE id=?");
        $stmt_user->bind_param("ssssi", $nama, $username, $password, $level, $id);

        if ($stmt_user->execute()) {
            if ($level == 'wisatawan') {
                // Update existing wisatawan
                $stmt = $koneksi->prepare("UPDATE wisatawan SET nama=?, username=?, password=? WHERE idWisatawan=?");
            } elseif ($level == 'staff') {
                // Update existing staffPengelola
                $stmt = $koneksi->prepare("UPDATE staffPengelola SET nama=?, username=?, password=? WHERE idStaff=?");
            }

            if (isset($stmt)) {
                $stmt->bind_param("sssi", $nama, $username, $password, $id);
                if ($stmt->execute()) {
                    echo "Record updated successfully in both user and $level tables";
                } else {
                    echo "Error updating record: " . $stmt->error;
                }
                $stmt->close();
            }
        } else {
            echo "Error updating record: " . $stmt_user->error;
        }
        $stmt_user->close();
    }
}

// Handle delete request
if (isset($_GET['delete']) && isset($_GET['level'])) {
    $id = $_GET['delete'];
    $level = $_GET['level'];

    // Determine which table to delete from based on $level
    if ($level == 'wisatawan') {
        $stmt = $koneksi->prepare("DELETE FROM wisatawan WHERE idWisatawan=?");
    } elseif ($level == 'staff') {
        $stmt = $koneksi->prepare("DELETE FROM staffPengelola WHERE idStaff=?");
    } else {
        // Handle case where $level is neither 'wisatawan' nor 'staff'
        echo "Invalid level specified for deletion.";
        exit(); // Exit script to prevent further execution
    }

    // Perform the deletion query using prepared statements
    if (isset($stmt)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // If deletion is successful, redirect back to this page or display success message
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: SQL statement is empty or undefined.";
    }
}

$sql = "SELECT * FROM admin";
$result = $koneksi->query($sql);
?>

<div class="wrapper">
    <!-- Sidebar -->
   
    <!-- End Sidebar -->

    <div class="main-panel">
        <div class="main-header">
            <div class="main-header-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="index.html" class="logo">
                        <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <!-- Navbar Header -->
            <?php include 'layout/navbar.php'; ?>
            <!-- End Navbar -->
        </div>

        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <h3 class="fw-bold mb-3">Kelola Akun</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Data User</h4>
                                    <button type="button" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetForm()">
                                        <i class="fa fa-plus"></i>
                                        Tambah User
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Modal -->
                                <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="userModalLabel">Tambah User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="userForm" method="POST" action="">
                                                    <input type="hidden" id="id" name="id">
                                                    <div class="mb-3">
                                                        <label for="nama" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" id="nama" name="nama" required>
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
                                                            <option value="wisatawan">Wisatawan</option>
                                                            <option value="staff">Staff</option>
                                                            <option value="admin">Admin</option>
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
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>password</th>
                                                <th>Level</th>
                                                <th style="width: 10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['id']; ?></td>
                                                        <td><?php echo $row['nama']; ?></td>
                                                        <td><?php echo $row['username']; ?></td>
                                                        <td><?php echo $row['password']; ?></td>
                                                        <td><?php echo $row['level']; ?></td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <button type="button" class="btn btn-link btn-primary btn-lg" onclick="editUser(<?php echo $row['id']; ?>, '<?php echo $row['nama']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['password']; ?>', '<?php echo $row['level']; ?>')">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <a href="?delete=<?php echo $row['id']; ?>&level=<?php echo $row['level']; ?>" class="btn btn-link btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
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

        <?php include 'layout/footer.php'; ?>

        <script>
            function resetForm() {
                document.getElementById('userForm').reset();
                document.getElementById('userModalLabel').textContent = 'Tambah User';
                document.getElementById('createBtn').classList.remove('d-none');
                document.getElementById('updateBtn').classList.add('d-none');
            }

            function editUser(id, nama, username, password, level) {
                document.getElementById('id').value = id;
                document.getElementById('nama').value = nama;
                document.getElementById('username').value = username;
                document.getElementById('password').value = password;
                document.getElementById('level').value = level;
                document.getElementById('userModalLabel').textContent = 'Edit User';
                document.getElementById('createBtn').classList.add('d-none');
                document.getElementById('updateBtn').classList.remove('d-none');
                var myModal = new bootstrap.Modal(document.getElementById('userModal'), {});
                myModal.show();
            }
        </script>
    </div>
</div>
