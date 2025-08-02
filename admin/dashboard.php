<?php
require_once 'auth.php';  // Oturum kontrolü ve session_start burada
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Admin Panel - Ana Sayfa</title>
    <link rel="stylesheet" href="assets/css/admin-style.css" />
</head>
<body>
    <h1>Hoş Geldin, <?php echo htmlspecialchars($_SESSION['admin_name'] ?? ''); ?>!</h1>
    <p>Admin paneline başarıyla giriş yaptın.</p>
    <nav>
        <a href="ekle.php">Araç Ekle</a> |
        <a href="cars-list.php">Araç Listesi</a> |
        <a href="admin_users.php">Kullanıcı Yönetimi</a> |
        <a href="logout.php">Çıkış Yap</a>
    </nav>
</body>
</html>
