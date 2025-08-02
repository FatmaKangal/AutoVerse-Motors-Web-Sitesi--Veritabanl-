<?php
session_start();
include 'config/db.php'; // Veritabanı bağlantı dosyan

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];

    // Kullanıcıyı email'e göre getir
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Basit düz metin şifre kontrolü (İlerde hash kullanmanı öneririm)
    if ($user && $sifre === $user['sifre']) {
        // Oturum bilgilerini doldur
        $_SESSION['admin_user'] = $user['email'];
        $_SESSION['admin_name'] = $user['ad']; // Burası eksikti, eklendi

        header("Location: dashboard.php");
        exit;
    } else {
        $hata = "Email veya şifre hatalı.";
    }
}
?>

<!-- Giriş Formu -->
<form method="post">
  <input type="email" name="email" required placeholder="Email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
  <br>
  <input type="password" name="sifre" required placeholder="Şifre">
  <br>
  <button type="submit">Giriş Yap</button>
</form>

<?php if (isset($hata)) echo "<p style='color:red;'>$hata</p>"; ?>
