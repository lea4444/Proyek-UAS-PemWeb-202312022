<?php
session_start();
include '../config/database.php';
include_once '../modules/activity_logs/functions.php'; // jalur yang benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' LIMIT 1");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Catat aktivitas login
        log_activity($conn, $user['id'], 'Login ke sistem');

        // Redirect sesuai peran
        if ($user['role'] === 'admin') {
            header('Location: ../admin/dashboard.php');
        } else {
            header('Location: ../user/dashboard.php');
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - literaid</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fdf6e3;
      font-family: 'Georgia', serif;
      color: #5b4636;
    }
    .login-card {
      background-color: #fff8e1;
      border: 2px solid #e0c68c;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 5px 15px rgba(124, 96, 50, 0.15);
    }
    .btn-vintage {
      background-color: #8b5e3c;
      color: #fff8e1;
      border: none;
    }
    .btn-vintage:hover {
      background-color: #6b4228;
    }
    .title {
      color: #8b5e3c;
      font-weight: bold;
      text-align: center;
    }
    .form-label {
      font-weight: bold;
    }
    .register-link {
      text-align: center;
      margin-top: 1rem;
    }
    .register-link a {
      color: #8b5e3c;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="login-card w-100" style="max-width: 400px;">
      <h3 class="title mb-4">📖 Login ke literaid</h3>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
      <?php endif; ?>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-vintage">🔐 Login</button>
        </div>
      </form>
      <div class="register-link">
        Belum punya akun? <a href="register.php">Daftar sekarang</a>
      </div>
    </div>
  </div>
</body>
</html>
