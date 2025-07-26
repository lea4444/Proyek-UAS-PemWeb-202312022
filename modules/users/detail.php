<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$user = mysqli_fetch_assoc($data);
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

    .badge-admin {
        background-color: #b85c38;
        color: #fff;
    }

    .badge-user {
        background-color: #8d8577;
        color: #fff;
    }

    .label {
        color: #5b4433;
        font-weight: 600;
    }

    .btn-vintage {
        background-color: #a67c52;
        color: #fff;
        border: none;
    }

    .btn-vintage:hover {
        background-color: #8b6a41;
    }
</style>

<div class="container mt-5">
    <div class="card-vintage">
        <h4 class="mb-4">Detail Pengguna</h4>
        <dl class="row">
            <dt class="col-sm-3 label">ID</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($user['id']); ?></dd>

            <dt class="col-sm-3 label">Username</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($user['username']); ?></dd>

            <dt class="col-sm-3 label">Email</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($user['email']); ?></dd>

            <dt class="col-sm-3 label">Role</dt>
            <dd class="col-sm-9">
                <span class="badge <?= $user['role'] === 'admin' ? 'badge-admin' : 'badge-user'; ?>">
                    <?= htmlspecialchars($user['role']); ?>
                </span>
            </dd>

            <dt class="col-sm-3 label">Dibuat Pada</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($user['created_at']); ?></dd>
        </dl>

        <a href="index.php" class="btn btn-secondary mt-3">← Kembali</a>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
