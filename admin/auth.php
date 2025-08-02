<?php
session_start();

include 'config/db.php'; // Veritabanı bağlantısı

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Formdan gelen veriler (temizlemeden direkt aldım, istersen filtre ekleyebilirsin)
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        echo "Lütfen email ve şifre alanlarını doldurunuz.";
        exit;
    }

    // Kullanıcı sorgulama
    $sql = "SELECT * FROM admin_users WHERE email = :email LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':email' => $email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        // Şifre kontrolü (DÜZ METİN kontrolü - önerim hash kullanman)
        if ($password === $admin['sifre']) {

            // Giriş başarılı - session oluştur
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['ad'];
            $_SESSION['admin_yetki'] = $admin['yetki'];

            // Admin paneline yönlendir
            header("Location: admin-panel.php");
            exit();
        } else {
            echo "Hatalı şifre.";
        }
    } else {
        echo "Kullanıcı bulunamadı.";
    }
} else {
    // POST değilse formdan gelmedi demek
    echo "Lütfen giriş formunu kullanarak giriş yapınız.";
}
?>
