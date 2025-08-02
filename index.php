<?php
// Veritabanı bağlantısı
include 'admin/config/db.php';

// Filtre ve arama değerlerini al
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';
$model = isset($_GET['model']) ? trim($_GET['model']) : '';
$price = isset($_GET['price']) ? trim($_GET['price']) : '';
$year = isset($_GET['year']) ? trim($_GET['year']) : '';
$km = isset($_GET['km']) ? trim($_GET['km']) : '';
$sort = isset($_GET['sort']) ? trim($_GET['sort']) : '';

// WHERE koşulları ve parametreler
$where = [];
$params = [];

// Arama metni varsa
if ($search !== '') {
    $where[] = "(marka LIKE ? OR model LIKE ? OR aciklama LIKE ?)";
    $searchTerm = '%' . $search . '%';
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

// Marka filtresi
if ($brand !== '') {
    $where[] = "marka = ?";
    $params[] = $brand;
}

// Model filtresi
if ($model !== '') {
    $where[] = "model = ?";
    $params[] = $model;
}

// Fiyat filtresi
if ($price !== '') {
    if ($price === '200000+') {
        $where[] = "fiyat >= ?";
        $params[] = 200000;
    } else {
        list($minPrice, $maxPrice) = explode('-', $price);
        $where[] = "fiyat BETWEEN ? AND ?";
        $params[] = (int)$minPrice;
        $params[] = (int)$maxPrice;
    }
}

// Model yılı filtresi
if ($year !== '') {
    $where[] = "yil = ?";
    $params[] = $year;
}

// KM filtresi
if ($km !== '') {
    if ($km === '100000+') {
        $where[] = "km >= ?";
        $params[] = 100000;
    } else {
        list($minKm, $maxKm) = explode('-', $km);
        $where[] = "km BETWEEN ? AND ?";
        $params[] = (int)$minKm;
        $params[] = (int)$maxKm;
    }
}

// SQL sorgu oluştur
$sql = "SELECT * FROM cars";
if (count($where) > 0) {
    $sql .= " WHERE " . implode(' AND ', $where);
}

// Sıralama
switch ($sort) {
    case 'price_asc':
        $sql .= " ORDER BY fiyat ASC";
        break;
    case 'price_desc':
        $sql .= " ORDER BY fiyat DESC";
        break;
    case 'year_desc':
        $sql .= " ORDER BY yil DESC";
        break;
    case 'km_asc':
        $sql .= " ORDER BY km ASC";
        break;
    default:
        $sql .= " ORDER BY id DESC";
}

// Sorguyu hazırla ve çalıştır
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Görsel yolu düzeltme fonksiyonu
function fixImagePath($path) {
    return str_replace('../', '', $path);
}
?>



<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoVerse Motors</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <script src="js/script.js" defer></script>
  <style>
    .swiper {
      width: 100%;
      height: 250px;
      border-radius: 10px;
      overflow: hidden;
    }
    .swiper-slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>
</head>
<body>

<header>
  <div class="top-bar">
    <div class="container">
      <span>📞 0555 111 22 33 | ✉ info@autoverse.com</span>
      <div class="social-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
  </div>

  <nav class="top-nav">
    <div class="container nav-container">
      <ul class="menu">
        <li><a href="index.php">Anasayfa</a></li>
        <li><a href="hakkimizda.php">Hakkımızda</a></li>
        <li><a href="kiralama.php">Kurumsal Kiralama</a></li>
        <li><a href="iletisim.php">İletişim</a></li>
      </ul>

      <div class="nav-actions">
        <button class="search-toggle"><i class="fas fa-search"></i></button>

        <!-- Hamburger animasyonlu yapıldı -->
        <button class="hamburger-toggle" id="hamburgerToggle" aria-label="Menu Toggle">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </button>
      </div>
    </div>

   <form id="searchForm" class="search-box" method="GET" action="index.php">
  <input type="text" name="q" placeholder="Ara..." value="<?= htmlspecialchars($search) ?>" />
</form>


    <!-- Efektli yan menü -->
    <div class="side-menu" id="sideMenu">
      <ul>
        <li><a href="index.php">Anasayfa</a></li>
        <li><a href="hakkimizda.php">Hakkımızda</a></li>
        <li><a href="kiralama.php">Kurumsal Kiralama</a></li>
        <li><a href="iletisim.php">İletişim</a></li>
      </ul>
      <div class="mobile-search">
        <input type="text" placeholder="Ara..." />
      </div>
    </div>

    <!-- Arka plan karartma -->
    <div class="overlay" id="overlay"></div>
  </nav>
</header>

<section class="hero">
  <video autoplay muted loop playsinline class="hero-video">
    <source src="videos/video3.mp4" type="video/mp4" />
    Tarayıcınız video etiketini desteklemiyor.
  </video>

  <div class="hero-content">
    <h1>Hoşgeldiniz</h1>
    <p>AutoVerse Motors'a özel araçlar</p>
  </div>
</section>

<section class="filter-section">
  <form id="carFilterForm" class="filter-form" method="GET" action="index.php">
    <div class="filter-fields">
      <div class="filter-row">
        <label for="brandSelect">Marka</label>
        <select id="brandSelect" name="brand">
          <option value="">Marka Seçiniz</option>
          <option value="bmw">BMW</option>
          <option value="mercedes">Mercedes</option>
          <option value="audi">Audi</option>
        </select>
      </div>

      <div class="filter-row">
        <label for="modelSelect">Model</label>
        <select id="modelSelect" name="model" disabled>
          <option value="">Tümü</option>
        </select>
      </div>

      <div class="filter-row">
        <label for="priceRange">Fiyat Aralığı</label>
        <select id="priceRange" name="price">
          <option value="">Fiyat Seçiniz</option>
          <option value="0-50000">0 - 50.000 TL</option>
          <option value="50000-100000">50.000 - 100.000 TL</option>
          <option value="100000-200000">100.000 - 200.000 TL</option>
          <option value="200000+">200.000 TL ve üzeri</option>
        </select>
      </div>

      <div class="filter-row">
        <label for="yearSelect">Model Yılı</label>
        <select id="yearSelect" name="year">
          <option value="">Model yılı seçiniz</option>
          <option value="2025">2025</option>
          <option value="2024">2024</option>
          <option value="2023">2023</option>
          <option value="2022">2022</option>
        </select>
      </div>

      <div class="filter-row">
        <label for="kmSelect">KM</label>
        <select id="kmSelect" name="km">
          <option value="">Kilometre seçiniz</option>
          <option value="0-10000">0 - 10.000 km</option>
          <option value="10000-50000">10.000 - 50.000 km</option>
          <option value="50000-100000">50.000 - 100.000 km</option>
          <option value="100000+">100.000 km ve üzeri</option>
        </select>
      </div>

      <div class="filter-row">
        <label for="sortSelect">Gelişmiş Sıralama</label>
        <select id="sortSelect" name="sort">
          <option value="">Seçiniz</option>
          <option value="price_asc">Fiyata göre Artan</option>
          <option value="price_desc">Fiyata göre Azalan</option>
          <option value="year_desc">Model yılına göre Yeni-Eski</option>
          <option value="km_asc">Kilometreye göre Azalan</option>
        </select>
      </div>
    </div>

    <div class="filter-submit">
      <button type="submit">Araçları Göster</button>
    </div>
  </form>
</section>
<!-- Araç kartları kısmı -->
<div class="car-list">
  <?php foreach ($cars as $car): ?>
    <?php
      // Açıklama kontrolü
      $aciklama = !empty($car['aciklama']) ? trim($car['aciklama']) : 'Açıklama yok';

      // Fiyat kontrolü
      $fiyat_tl = isset($car['fiyat']) ? (float)$car['fiyat'] : 0;

      // Araç görsellerini çek
      $stmtImg = $conn->prepare("SELECT image_path FROM cars_images WHERE car_id = ?");
      $stmtImg->execute([$car['id']]);
      $images = $stmtImg->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="car-card">
      <a href="arac_detay.php?id=<?= $car['id'] ?>" style="display: block; color: inherit; text-decoration: none;">
        <div class="car-image">
          <?php if ($images): ?>
            <div class="swiper mySwiper-<?= $car['id'] ?>">
              <div class="swiper-wrapper">
                <?php foreach ($images as $img): ?>
                  <div class="swiper-slide">
                    <img src="<?= htmlspecialchars(fixImagePath($img['image_path'])) ?>" alt="Araç Görseli">
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="swiper-pagination"></div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          <?php else: ?>
            <img src="images/no-image.png" alt="Resim yok">
          <?php endif; ?>
        </div>

        <div class="car-info">
          <h3><?= htmlspecialchars($car['marka'] . ' ' . $car['model']) ?></h3>
          <p><?= htmlspecialchars($aciklama) ?></p>
          <span class="price">
            <?= $fiyat_tl > 0 ? htmlspecialchars(number_format($fiyat_tl, 0, ',', '.') . ' TL') : 'Fiyat yok' ?>
          </span>
        </div>
      </a>
    </div>
  <?php endforeach; ?>
</div>

<section class="sell-car">
  <div class="container">
    <h2 class="section-title">Aracınızı Satmak İster misiniz?</h2>
    <p class="form-info">
      Lüks aracınızı kolayca değerlendirin. Formu doldurun, danışmanlarımız sizi arasın.
    </p>
    <form class="sell-form">
      <div class="form-row">
        <div class="form-group">
          <input type="text" placeholder="Ad Soyad" required />
        </div>
        <div class="form-group">
          <input type="tel" placeholder="Telefon Numarası" required />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <input type="email" placeholder="E-Posta Adresi" />
        </div>
        <div class="form-group">
          <input type="text" placeholder="Araç Markası ve Modeli" required />
        </div>
      </div>
      <div class="form-group full">
        <textarea placeholder="Araç Bilgileri (Kilometre, Yıl, Yakıt, Durum vb.)" required></textarea>
      </div>
      <button type="submit" class="form-button">Bilgilerimi Gönder</button>
    </form>
  </div>
</section>

<section class="contact">
  <div class="container contact-container">
    <div class="contact-form">
      <h2 class="section-title">Bize Ulaşın</h2>
      <form>
        <input type="text" placeholder="Adınız" required />
        <input type="email" placeholder="E-posta Adresiniz" required />
        <textarea placeholder="Mesajınız" required></textarea>
        <button type="submit">Gönder</button>
      </form>
    </div>
    <div class="contact-map">
      <h2 class="section-title">Showroom Lokasyonumuz</h2>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12093.573784841658!2d29.02531361763571!3d41.08621082904613!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cab6a9a6a710b1%3A0xd0f3852f0a8df9c5!2sYenik%C3%B6y%2C%20İstanbul!5e0!3m2!1str!2str!4v1683230026412!5m2!1str!2str"
        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
      ></iframe>
    </div>
  </div>
</section>

<footer>
  <div class="container footer-container">
      <div class="footer-section about">
        <h3>AutoVerse Motors</h3>
        <p>İstanbul’da 20 yılı aşkın deneyimle lüks araç satışında lideriz. Güvenilir hizmet ve kaliteli araçlar için bizimle iletişime geçin.</p>
      </div>

      <div class="footer-section links">
        <h3>Hızlı Linkler</h3>
        <ul>
          <li><a href="index.php">Anasayfa</a></li>
          <li><a href="araclar.php">Araçlar</a></li>
          <li><a href="hakkimizda.php">Hakkımızda</a></li>
          <li><a href="iletisim.php">İletişim</a></li>
        </ul>
      </div>

      <div class="footer-section contact">
        <h3>İletişim</h3>
        <p>📍 Yeniköy, İstanbul</p>
        <p>📞 +90 212 123 45 67</p>
        <p>✉ info@autoversemotors.com</p>
        <div class="socials">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 AutoVerse Motors. Tüm hakları saklıdır.</p>
      <p>Bu web sitesi, modern ve hızlı çözümler sunan Sufa Studio ile hazırlanmıştır.</p>
    </div>
</footer>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
  <?php foreach ($cars as $car): ?>
    new Swiper(".mySwiper-<?php echo $car['id']; ?>", {
      loop: true,
      pagination: {
        el: ".mySwiper-<?php echo $car['id']; ?> .swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".mySwiper-<?php echo $car['id']; ?> .swiper-button-next",
        prevEl: ".mySwiper-<?php echo $car['id']; ?> .swiper-button-prev",
      },
    });
  <?php endforeach; ?>
</script>

<div class="quick-contact">
  <a href="https://wa.me/905551112233" target="_blank" class="quick-contact-btn whatsapp" aria-label="WhatsApp">
    <i class="fab fa-whatsapp"></i>
  </a>
  <a href="tel:+905551112233" class="quick-contact-btn phone" aria-label="Telefon">
    <i class="fas fa-phone-alt"></i>
  </a>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
  const hamburgerToggle = document.getElementById('hamburgerToggle');
  const sideMenu = document.getElementById('sideMenu');
  const overlay = document.getElementById('overlay');

  function toggleMenu() {
    sideMenu.classList.toggle('active');
    overlay.classList.toggle('active');
  }

  hamburgerToggle.addEventListener('click', toggleMenu);
  overlay.addEventListener('click', toggleMenu);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchToggle = document.querySelector('.search-toggle');
  const searchForm = document.getElementById('searchForm');

  searchToggle.addEventListener('click', () => {
    searchForm.classList.toggle('active');

    if (searchForm.classList.contains('active')) {
      searchForm.querySelector('input[name="q"]').focus();
    }
  });
});

</script>
</body>
</html>
