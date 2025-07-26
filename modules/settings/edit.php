<?php
include '../../includes/auth.php';
include '../../includes/header.php';
include '../../config/database.php';

$id = $_GET['id'] ?? null;
$setting = ['name' => '', 'value' => '', 'type' => 'text'];

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM settings WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $setting = $stmt->get_result()->fetch_assoc();
}
?>

<div class="container py-4" style="font-family: Georgia, serif;">
    <div class="vintage-header mb-3">
        <h2 class="fw-bold"><i class="bi bi-pencil-square me-2"></i><?= $id ? 'Edit' : 'Tambah' ?> Pengaturan</h2>
    </div>

    <form method="POST" action="save.php">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="card vintage-card p-4">
            <div class="mb-3">
                <label class="form-label">Nama Pengaturan</label>
                <input type="text" name="name" required class="form-control" value="<?= htmlspecialchars($setting['name']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Nilai</label>
                <textarea name="value" rows="2" class="form-control"><?= htmlspecialchars($setting['value']) ?></textarea>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-vintage px-4">Simpan</button>
            </div>
        </div>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
