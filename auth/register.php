<?php
session_start();
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username atau email sudah digunakan
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username atau email sudah terdaftar!";
    } else {
        // Default role: user
        $query = mysqli_query($conn, "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')");
        if ($query) {
            $_SESSION['success'] = "Registrasi berhasil, silakan login.";
            header('Location: login.php');
            exit;
        } else {
            $error = "Gagal mendaftar. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - literaid</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fdf6e3;
      font-family: 'Georgia', serif;
      color: #5b4636;
    }
    .register-card {
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
    .login-link {
      text-align: center;
      margin-top: 1rem;
    }
    .login-link a {
      color: #8b5e3c;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="register-card w-100" style="max-width: 400px;">
      <h3 class="title mb-4">📝 Daftar akun literaid</h3>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-vintage">📝 Daftar</button>
        </div>
      </form>
      <div class="login-link">
        Sudah punya akun? <a href="login.php">Login di sini</a>
      </div>
    </div>
  </div>
</body>
</html>
