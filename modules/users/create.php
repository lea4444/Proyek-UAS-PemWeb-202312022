<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    $insert = mysqli_query($conn, "INSERT INTO users (username, email, password, role) 
                                   VALUES ('$username', '$email', '$password', '$role')");

    if ($insert) {
        header("Location: index.php");
        exit;
    } else {
        echo '<div class="alert alert-danger mt-3">Gagal menambahkan user.</div>';
    }
}
?>

<style>
    body {
        background-color: #fdfaf5;
        font-family: 'Georgia', serif;
    }

    .card-vintage {
        background-color: #fffaf0;
        border: 1px solid #e6d3b3;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .btn-vintage {
        background-color: #a67c52;
        color: #fff;
        border: none;
    }

    .btn-vintage:hover {
        background-color: #8b6a41;
    }

    .label {
        color: #5b4433;
        font-weight: 600;
    }
</style>

<div class="container mt-5">
    <div class="card-vintage">
        <h4 class="mb-4">Tambah Pengguna Baru</h4>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="mb-3">
                <label class="form-label label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
                <label class="form-label label">Role</label>
                <select class="form-select" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <button type="submit" class="btn btn-vintage">Simpan</button>
            <a href="index.php" class="btn btn-secondary ms-2">← Kembali</a>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
