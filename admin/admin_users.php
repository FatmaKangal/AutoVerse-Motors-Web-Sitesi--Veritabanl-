<?php
// Oturum daha önce başlatılmadıysa başlat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'auth.php';
require_once 'config/db.php';

// Kullanıcıları getir
$stmt = $conn->prepare("SELECT * FROM admin_users");
$stmt->execute();
$kullanicilar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Admin Kullanıcıları</title>
</head>
<body>
  <h2>Admin Kullanıcıları</h2>
  <a href="admin_users_ekle.php">➕ Yeni Kullanıcı Ekle</a><br><br>

  <table border="1" cellpadding="10">
    <thead>
      <tr>
        <th>ID</th>
        <th>Ad</th>
        <th>Email</th>
        <th>Yetki</th>
        <th>İşlem</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($kullanicilar as $k): ?>
        <tr>
          <td><?= htmlspecialchars($k['id']) ?></td>
          <td><?= htmlspecialchars($k['ad']) ?></td>
          <td><?= htmlspecialchars($k['email']) ?></td>
          <td><?= htmlspecialchars($k['yetki']) ?></td>
          <td>
            <a href="admin_user_sil.php?id=<?= urlencode($k['id']) ?>" onclick="return confirm('Silmek istediğine emin misin?')">🗑️ Sil</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
