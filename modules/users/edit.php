<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$user = mysqli_fetch_assoc($data);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $role     = $_POST['role'];

    $query = mysqli_query($conn, "UPDATE users SET 
                    username = '$username',
                    email = '$email',
                    role = '$role'
                    WHERE id = $id");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo '<div class="alert alert-danger mt-3">Gagal mengupdate user.</div>';
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
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .btn-vintage {
        background-color: #a67c52;
        color: #fff;
        border: none;
    }

    .btn-vintage:hover {
        background-color: #8b6a41;
    }

    .form-label {
        color: #5b4433;
        font-weight: 600;
    }

    .form-control, .form-select {
        border-radius: 0.5rem;
        border: 1px solid #c8b08e;
    }
</style>

<div class="container mt-5">
    <div class="card-vintage">
        <h4 class="mb-4">Edit Pengguna</h4>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="<?= htmlspecialchars($user['username']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                </select>
            </div>

            <button type="submit" class="btn btn-vintage">Update</button>
            <a href="index.php" class="btn btn-secondary ms-2">← Kembali</a>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
