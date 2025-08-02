<?php
session_start();
require_once 'auth.php';
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST['ad'];
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];
    $yetki = $_POST['yetki'];

    $stmt = $conn->prepare("INSERT INTO admin_users (ad, email, sifre, yetki) VALUES (?, ?, ?, ?)");
    $stmt->execute([$ad, $email, $sifre, $yetki]);

    header("Location: admin_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Yeni Admin Kullanıcısı Ekle</title>
</head>
<body>
  <h2>Yeni Kullanıcı Ekle</h2>
  <form method="POST">
    <input type="text" name="ad" placeholder="Adı" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="sifre" placeholder="Şifre" required><br><br>
    <select name="yetki" required>
      <option value="admin">Admin</option>
      <option value="editor">Editör</option>
    </select><br><br>
    <button type="submit">Ekle</button>
  </form>
</body>
</html>
