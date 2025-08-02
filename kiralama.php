<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AutoVerse Motors - Kiralama</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  
  <style>
    /* Arama formu gizli başlar */
    #searchForm {
      display: none;
      position: absolute;
      top: 60px; /* header altı */
      right: 10px;
      background: white;
      padding: 5px 10px;
      border-radius: 4px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      z-index: 1001;
    }
    #searchForm.active {
      display: block;
    }
    #searchInput {
      border: 1px solid #ccc;
      padding: 6px 10px;
      border-radius: 4px;
      width: 180px;
      font-size: 1rem;
    }

    /* Hamburger stil */
    .hamburger {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      width: 25px;
      height: 20px;
      cursor: pointer;
      border: none;
      background: transparent;
      padding: 0;
      margin-left: 10px;
      z-index: 1100;
    }
    .hamburger span {
      display: block;
      height: 3px;
      background: #222;
      border-radius: 2px;
    }

    /* Yan menü */
    .side-menu {
      position: fixed;
      top: 0;
      right: -280px; /* gizli */
      width: 280px;
      height: 100%;
      background: #fff;
      box-shadow: -2px 0 8px rgba(0,0,0,0.2);
      padding: 20px;
      transition: right 0.3s ease;
      z-index: 1100;
      overflow-y: auto;
    }
    .side-menu.active {
      right: 0;
    }
    .side-menu ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .side-menu ul li {
      margin-bottom: 15px;
    }
    .side-menu ul li a {
      text-decoration: none;
      color: #222;
      font-weight: 600;
      font-size: 1.1rem;
    }

    /* Overlay */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.4);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease;
      z-index: 1050;
    }
    .overlay.active {
      opacity: 1;
      visibility: visible;
    }

    /* Nav container */
    nav.top-nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      background: #f5f5f5;
      position: relative;
      z-index: 1000;
    }
    nav.top-nav ul.menu {
      display: flex;
      gap: 20px;
      margin: 0;
      padding: 0;
      list-style: none;
    }
    nav.top-nav ul.menu li a {
      text-decoration: none;
      color: #222;
      font-weight: 600;
      font-size: 1rem;
    }
    .nav-actions {
      display: flex;
      align-items: center;
    }
    .nav-actions button#searchBtn {
      background: transparent;
      border: none;
      font-size: 1.2rem;
      cursor: pointer;
      color: #222;
    }

    /* Responsive */
    @media (max-width: 768px) {
      nav.top-nav ul.menu {
        display: none;
      }
      .hamburger {
        display: flex;
      }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Arama aç/kapa
      const searchBtn = document.getElementById('searchBtn');
      const searchForm = document.getElementById('searchForm');
      const searchInput = document.getElementById('searchInput');

      searchBtn.addEventListener('click', () => {
        if(searchForm.classList.contains('active')){
          searchForm.classList.remove('active');
          searchInput.value = '';
        } else {
          searchForm.classList.add('active');
          searchInput.focus();
        }
      });

      // Hamburger menü aç/kapa
      const hamburger = document.querySelector('.hamburger');
      const sideMenu = document.getElementById('sideMenu');
      const overlay = document.getElementById('overlay');

      function toggleMenu() {
        sideMenu.classList.toggle('active');
        overlay.classList.toggle('active');
        if(sideMenu.classList.contains('active')) {
          sideMenu.setAttribute('aria-hidden', 'false');
        } else {
          sideMenu.setAttribute('aria-hidden', 'true');
        }
      }

      hamburger.addEventListener('click', toggleMenu);
      overlay.addEventListener('click', toggleMenu);
    });
  </script>

</head>
<body>
  <header>
    <div class="top-bar">
      <div class="container">
        <span>📞 0555 111 22 33 | ✉ info@autoverse.com</span>
        <div class="social-icons">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>

    <nav class="top-nav">
      <ul class="menu">
        <li><a href="index.php">Anasayfa</a></li>
        <li><a href="hakkimizda.php">Hakkımızda</a></li>
        <li><a href="kiralama.php">Kurumsal Kiralama</a></li>
        <li><a href="iletisim.php">İletişim</a></li>
      </ul>

      <div class="nav-actions">
        <button id="searchBtn" aria-label="Arama Aç/Kapa"><i class="fas fa-search"></i></button>
        <form id="searchForm" method="GET" action="index.php" style="margin:0;">
          <input
            type="text"
            name="q"
            id="searchInput"
            placeholder="Ara..."
            autocomplete="off"
          />
        </form>

        <button class="hamburger" aria-label="Menüyü aç/kapa">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </nav>
  </header>

  <!-- Yan Menü -->
  <div class="side-menu" id="sideMenu" aria-hidden="true">
    <ul>
      <li><a href="index.php">Anasayfa</a></li>
      <li><a href="hakkimizda.php">Hakkımızda</a></li>
      <li><a href="kiralama.php">Kurumsal Kiralama</a></li>
      <li><a href="iletisim.php">İletişim</a></li>
    </ul>
  </div>

  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>

  <!-- Hero Bölümü -->
  <section class="hero">
    <video autoplay muted loop playsinline class="hero-video">
      <source src="videos/video3.mp4" type="video/mp4" />
      Tarayıcınız video etiketini desteklemiyor.
    </video>
    <div class="hero-overlay">
      <h1>Kurumsal Kiralama</h1>
      <p>İşiniz için en uygun lüks araçları kiralayın.</p>
    </div>
  </section>

  <!-- Kiralama İçeriği -->
  <section class="rental-section">
    <div class="container">
      <h2 class="section-title">Kurumsal Kiralama Hizmetleri</h2>
      <p>
        AutoVerse Motors olarak, iş dünyasının ihtiyaçlarına yönelik kurumsal kiralama hizmetleri sunuyoruz.
        Geniş araç filomuz ve esnek kiralama seçeneklerimizle, iş seyahatlerinizde konfor ve prestiji bir arada yaşayın.
      </p>

      <div class="rental-benefits">
        <div class="benefit">
          <i class="fas fa-check-circle"></i>
          <h3>Geniş Araç Seçeneği</h3>
          <p>Marka ve model çeşitliliği ile işiniz için en uygun aracı seçin.</p>
        </div>
        <div class="benefit">
          <i class="fas fa-check-circle"></i>
          <h3>Esnek Sözleşmeler</h3>
          <p>Kısa ve uzun dönem kiralama seçenekleriyle ihtiyaçlarınıza uygun çözümler.</p>
        </div>
        <div class="benefit">
          <i class="fas fa-check-circle"></i>
          <h3>7/24 Destek</h3>
          <p>Kiralama süresince kesintisiz müşteri hizmetleri ve teknik destek.</p>
        </div>
      </div>

      <h2 class="section-title">Kiralama Talep Formu</h2>
      <form class="rental-form" action="#" method="POST">
        <div class="form-group">
          <label for="company">Firma Adı</label>
          <input type="text" id="company" name="company" required placeholder="Firma adınızı giriniz" />
        </div>
        <div class="form-group">
          <label for="contactName">İlgili Kişi</label>
          <input type="text" id="contactName" name="contactName" required placeholder="İlgili kişi adı" />
        </div>
        <div class="form-group">
          <label for="phone">Telefon Numarası</label>
          <input type="tel" id="phone" name="phone" required placeholder="+90 5xx xxx xx xx" />
        </div>
        <div class="form-group">
          <label for="email">E-posta</label>
          <input type="email" id="email" name="email" required placeholder="E-posta adresiniz" />
        </div>
        <div class="form-group">
          <label for="carModel">Kiralama Araç Modeli</label>
          <select id="carModel" name="carModel" required>
            <option value="">Lütfen seçiniz</option>
            <option value="aston-martin">Aston Martin</option>
            <option value="morgan">Morgan Motor</option>
            <option value="hongqi">Hongqi</option>
            <option value="diger">Diğer</option>
          </select>
        </div>
        <div class="form-group">
          <label for="rentalPeriod">Kiralama Süresi</label>
          <input type="text" id="rentalPeriod" name="rentalPeriod" required placeholder="Örn: 1 ay, 6 ay" />
        </div>
        <div class="form-group">
          <label for="message">Ek Notlar</label>
          <textarea id="message" name="message" rows="4" placeholder="İsterseniz ek bilgiler yazabilirsiniz"></textarea>
        </div>
        <button type="submit" class="btn-submit">Talebi Gönder</button>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container footer-container">
      <div class="footer-section about">
        <h3>AutoVerse Motors</h3>
        <p>İstanbul’da 20 yılı aşkın deneyimle lüks araç satışında lideriz. Güvenilir hizmet için bize ulaşın.</p>
      </div>
      <div class="footer-section links">
        <h3>Hızlı Linkler</h3>
        <ul>
          <li><a href="index.php">Anasayfa</a></li>
          <li><a href="araclar.php">Araçlar</a></li>
          <li><a href="hakkimizda.php">Hakkımızda</a></li>
          <li><a href="kiralama.php">Kurumsal Kiralama</a></li>
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
    </div>
  </footer>

</body>
</html>
