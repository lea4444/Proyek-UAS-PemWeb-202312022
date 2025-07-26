<?php
require '../../includes/auth.php';
require '../../includes/header.php';
require '../../config/database.php';
require 'settings_functions.php';

$settings = get_all_settings($conn);
?>

<style>
    body {
        background-color: #f8f1e4;
        font-family: 'Georgia', serif;
    }

    .vintage-header {
        border-bottom: 2px solid #9e835c;
        padding-bottom: 10px;
    }

    .table {
        background-color: #fffaf0;
        border: 1px solid #d1bfa7;
    }

    .table th {
        background-color: #e8dcc7;
        color: #5c3b18;
        font-weight: bold;
    }

    .btn-vintage {
        background-color: #a67c52;
        color: white;
        border: none;
        padding: 10px 20px;
        font-weight: bold;
    }

    .btn-vintage:hover {
        background-color: #8a6242;
    }

    .alert-success {
        background-color: #d8e3d0;
        color: #4b6f44;
        border: 1px solid #b7cba3;
    }

    input.form-control {
        border: 1px solid #c3a783;
        background-color: #fffdf8;
    }
</style>

<div class="container py-4">
    <div class="vintage-header mb-3">
        <h2 class="text-secondary"><i class="bi bi-gear-fill"></i> Pengaturan Aplikasi</h2>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div class="alert alert-success">Perubahan berhasil disimpan.</div>
    <?php endif; ?>

    <form method="POST" action="save.php">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Nama Pengaturan</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($settings as $index => $setting): ?>
                    <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($setting['name']) ?></td>
                        <td>
                            <input type="text" name="settings[<?= $setting['id'] ?>]" class="form-control"
                                   value="<?= htmlspecialchars($setting['value']) ?>">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-vintage">Simpan Perubahan</button>
        </div>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
