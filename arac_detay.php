<?php
include 'admin/config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: index.php");
    exit;
}

// Araç bilgilerini çek
$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->execute([$id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$car) {
    header("Location: index.php");
    exit;
}

// Araç teknik özelliklerini çek
$stmtTech = $conn->prepare("SELECT * FROM car_technical_specs WHERE car_id = ?");
$stmtTech->execute([$id]);
$tech = $stmtTech->fetch(PDO::FETCH_ASSOC);

// Araç görselleri
$stmtImg = $conn->prepare("SELECT image_path FROM cars_images WHERE car_id = ?");
$stmtImg->execute([$id]);
$images = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

// Görsel yolu düzeltme fonksiyonu
function fixImagePath($path) {
    $path = trim($path);
    if (strpos($path, '../') === 0) {
        $path = substr($path, 3);  // '../' kaldır
    }
    $dir = pathinfo($path, PATHINFO_DIRNAME);
    $file = pathinfo($path, PATHINFO_BASENAME);
    $encodedFile = rawurlencode($file);
    if ($dir === '.' || $dir === '') {
        return $dir . $encodedFile;
    }
    return $dir . '/' . $encodedFile;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= htmlspecialchars($car['marka'] . ' ' . $car['model']) ?> - Detaylar</title>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<style>
  /* Dark Mode Genel Ayar */
  body {
    background-color: #121212;
    color: #e0e0e0;
    font-family: Arial, sans-serif;
    margin: 0; padding: 0;
  }
  a {
    color: #3399ff;
    text-decoration: none;
  }
  a:hover {
    text-decoration: underline;
  }
  .container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
  }
  .car-title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 10px;
  }
  .car-price {
    font-size: 1.5rem;
    color: #ff6b6b;
    font-weight: bold;
    margin-bottom: 20px;
  }
  .car-details {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
  }
  .slider-container {
    flex: 1 1 600px;
    max-width: 600px;
  }
  .info-container {
    flex: 1 1 400px;
    max-width: 400px;
  }
  ul.info-list, ul.tech-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  ul.info-list li, ul.tech-list li {
    padding: 8px 0;
    border-bottom: 1px solid #333;
  }
  .description {
    margin-top: 20px;
    line-height: 1.6;
  }
  .btn-contact {
    display: inline-block;
    margin-top: 30px;
    padding: 12px 25px;
    background-color: #3399ff;
    color: white;
    font-weight: bold;
    border-radius: 4px;
    transition: background-color 0.3s ease;
  }
  .btn-contact:hover {
    background-color: #1a73e8;
  }
  /* Swiper */
  .swiper {
    width: 100%;
    height: 450px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0,0,0,0.7);
    background-color: #222;
  }
  .swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    background: #222;
    overflow: hidden;
  }
  .swiper-slide img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    border-radius: 8px;
  }
</style>
</head>
<body>

<div class="container">
  <h1 class="car-title"><?= htmlspecialchars($car['marka'] . ' ' . $car['model']) ?></h1>
  <div class="car-price"><?= number_format($car['fiyat'], 0, ',', '.') ?> TL</div>

  <div class="car-details">
    <div class="slider-container">
      <?php if ($images): ?>
        <div class="swiper mySwiper">
          <div class="swiper-wrapper">
            <?php foreach ($images as $img): ?>
              <div class="swiper-slide">
                <img src="<?= htmlspecialchars(fixImagePath($img['image_path'])) ?>" alt="Araç Fotoğrafı" />
              </div>
            <?php endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
      <?php else: ?>
        <img src="images/no-image.png" alt="Resim yok" style="width:100%; border-radius:8px;" />
      <?php endif; ?>
    </div>

    <div class="info-container">
      <ul class="info-list">
        <li><strong>Model Yılı:</strong> <?= htmlspecialchars($car['yil']) ?></li>
        <li><strong>Kilometre:</strong> <?= htmlspecialchars(number_format($car['km'] ?? 0, 0, ',', '.')) ?> km</li>
        <li><strong>Yakıt Türü:</strong> <?= htmlspecialchars($car['yakit'] ?? 'Belirtilmemiş') ?></li>
        <li><strong>Vites:</strong> <?= htmlspecialchars($car['vites'] ?? 'Belirtilmemiş') ?></li>
        <li><strong>Motor Hacmi:</strong> <?= htmlspecialchars($car['motor'] ?? 'Belirtilmemiş') ?> cc</li>
      </ul>

      <?php if ($tech): ?>
        <h3>Teknik Özellikler</h3>
        <ul class="tech-list">
          <li><strong>Motor Hacmi:</strong> <?= htmlspecialchars($tech['motor_hacmi'] ?? '-') ?> cc</li>
          <li><strong>Beygir Gücü:</strong> <?= htmlspecialchars($tech['beygir_gucu'] ?? '-') ?></li>
          <li><strong>Yakıt Türü:</strong> <?= htmlspecialchars($tech['yakit_turu'] ?? '-') ?></li>
          <li><strong>Vites Türü:</strong> <?= htmlspecialchars($tech['vites_turu'] ?? '-') ?></li>
          <li><strong>Çekiş:</strong> <?= htmlspecialchars($tech['cekis'] ?? '-') ?></li>
          <li><strong>Renk:</strong> <?= htmlspecialchars($tech['renk'] ?? '-') ?></li>
          <li><strong>Garanti Durumu:</strong> <?= htmlspecialchars($tech['garanti_durumu'] ?? '-') ?></li>
          <li><strong>Ek Bilgiler:</strong> <br><?= nl2br(htmlspecialchars($tech['ek_bilgiler'] ?? '-')) ?></li>
        </ul>
      <?php else: ?>
        <p>Teknik özellikler mevcut değil.</p>
      <?php endif; ?>

      <a href="iletisim.php?car=<?= urlencode($car['marka'] . ' ' . $car['model']) ?>" class="btn-contact">Teklif Al</a>
    </div>
  </div>

  <div class="description">
    <h2>Araç Hakkında</h2>
    <p><?= nl2br(htmlspecialchars($car['aciklama'])) ?></p>
  </div>
</div>

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
  const swiper = new Swiper(".mySwiper", {
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
</script>

</body>
</html>
