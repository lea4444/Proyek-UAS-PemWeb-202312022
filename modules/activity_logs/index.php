<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$query = "
    SELECT l.*, u.username
    FROM activity_logs l
    LEFT JOIN users u ON l.user_id = u.id
    ORDER BY l.log_time DESC
";
$result = mysqli_query($conn, $query);
$no = 1;
?>

<style>
    body {
        background-color: #f3efe3;
        font-family: 'Georgia', serif;
    }

    .vintage-header {
        background-color: #d7c8b6;
        padding: 10px 20px;
        border-left: 10px solid #7b5e42;
        border-radius: 8px;
        color: #4b3621;
        margin-bottom: 20px;
    }

    .vintage-card {
        background-color: #fdfaf6;
        border: 1px solid #b6a489;
        border-radius: 8px;
    }

    .vintage-table thead {
        background-color: #e8dccb;
        color: #5c4433;
    }

    .table td, .table th {
        font-size: 0.95rem;
    }
</style>

<div class="container py-4">
    <div class="vintage-header">
        <h2 class="fw-bold m-0">
            <i class="bi bi-clock-history me-2"></i> Log Aktivitas Pengguna
        </h2>
    </div>

    <div class="card vintage-card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle vintage-table">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Aktivitas</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['username'] ?? 'Tidak diketahui') ?></td>
                                    <td><?= htmlspecialchars($row['activity']) ?></td>
                                    <td><?= date('d M Y H:i', strtotime($row['log_time'])) ?></td>
                                </tr>
                            <?php endwhile ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada aktivitas tercatat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
