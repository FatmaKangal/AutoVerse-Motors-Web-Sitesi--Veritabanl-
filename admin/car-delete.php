<?php
include "auth.php"; // oturum kontrolü
include "config/db.php"; // veritabanı bağlantısı

if (isset($_GET['id'])) {
    $car_id = intval($_GET['id']);

    try {
        // 1. Araç resimlerini çek (cars_images tablosunu kullanıyorsan)
        $stmt = $conn->prepare("SELECT image_path FROM cars_images WHERE car_id = ?");
        $stmt->execute([$car_id]);
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Resimleri sunucudan sil
        foreach ($images as $image) {
            if (file_exists($image['image_path'])) {
                unlink($image['image_path']);
            }
        }

        // 2. Resimleri veritabanından sil
        $stmt = $conn->prepare("DELETE FROM cars_images WHERE car_id = ?");
        $stmt->execute([$car_id]);

        // 3. Aracı sil
        $stmt = $conn->prepare("DELETE FROM cars WHERE id = ?");
        $stmt->execute([$car_id]);

        header("Location: cars-list.php?status=silindi");
        exit();
    } catch (PDOException $e) {
        echo "Silme hatası: " . $e->getMessage();
    }
} else {
    echo "Geçersiz istek!";
}
?>
