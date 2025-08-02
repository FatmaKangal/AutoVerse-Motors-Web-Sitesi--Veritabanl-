<?php
$host = "localhost";        // Veritabanı sunucusu: genelde localhost
$dbname = "autoverse";      // phpMyAdmin'de oluşturduğun veritabanı adı
$username = "root";         // XAMPP için varsayılan kullanıcı adı
$password = "";             // XAMPP için varsayılan şifre (boş)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Veritabanına bağlandı!";
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>
