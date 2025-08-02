<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AutoVerse Motors</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="js/script.js" defer></script>

  <style>
    /* Arama formu gizli başlar, açıldığında gösterilir */
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
    #searchForm input[type="text"] {
      border: 1px solid #ccc;
      padding: 6px 10px;
      border-radius: 4px;
      width: 180px;
      font-size: 1rem;
    }

    /* Hamburger stil: üç bar */
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
      right: -280px; /* başlangıçta gizli */
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

    /* Overlay arka plan karartma */
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
    #searchInput {
      margin-left: 10px;
      padding: 5px 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
      font-size: 1rem;
      display: none;
    }
    #searchInput.active {
      display: inline-block;
    }

    /* Responsive örnek */
    @media (max-width: 768px) {
      nav.top-nav ul.menu {
        display: none;
      }
      .hamburger {
        display: flex;
      }
    }
  </style>
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
<!-- Kahraman Alanı / Hero -->
  <section class="hero">
  <video autoplay muted loop playsinline class="hero-video">
    <source src="videos/video3.mp4" type="video/mp4" />
    Tarayıcınız video etiketini desteklemiyor.
  </video>

 
 
  <!-- Üçgen geçiş -->
  <div class="hero-triangle"></div>
</section>
<section class="about-section">
  <div class="container">
    <h2 class="section-title">Hakkımızda</h2>
    <p class="intro">
      <strong>AutoVerse Motors:</strong> 30 Yıldır Lüks Otomobil Dünyasının Güvenilir Adresi
    </p>

    <p>
      AutoVerse Motors, 1991 yılında İstanbul Boğazı'nın en güzel semtlerinden biri olan Yeniköy'den adını alarak kuruldu. 30 yılı aşkın süredir, dünyaca ünlü otomobil markalarının ithalat ve satışını başarıyla gerçekleştirerek, premium otomobil severlerin vazgeçilmez adreslerinden biri haline gelmiştir.
    </p>

    <p>
      Bugün, Türkiye'nin en geniş lüks otomobil portföyüne sahip olmanın yanı sıra; kurumsal kiralama, servis, sigorta ve gayrimenkul alanlarında da hizmet veren geniş bir şirketler topluluğuna dönüşmüştür. Yüksek hizmet kalitesi ve yaygın hizmet ağı sayesinde müşteri portföyünü her geçen gün genişletmektedir. 2015 yılında İzmir Folkart Towers'ta açılan ikinci showroom ile lüks otomobil dünyasında daha geniş bir kitleye hitap etmeye başlamıştır. Ayrıca Türkiye'de aradığı otomobili bulamayan müşterilerine, 30 gün içinde tüm yasal işlemleri tamamlayarak otomobil teslim garantisi sunmaktadır.
    </p>

    <p>
      2014 yılında alt yapı çalışmalarını tamamlayarak D&D Motorlu Araçlar A.Ş.'yi kurmuş ve 2015 yılında İngiliz efsanesi Aston Martin Türkiye distribütörlüğünü alarak otomotiv sektöründe önemli bir başarıya imza atmıştır. Firma, İstanbul ve İzmir şubeleri dahilinde, Aston Martin'in tüm satış ve satış sonrası hizmetlerini global standartlara uygun şekilde sunmaktadır. Aynı yıl İstanbul Maslak'ta açtığı servis ile sadece Aston Martin değil, tüm lüks otomobil markalarına en yüksek kalitede hizmet vermeye başlamıştır. Bu önemli adımlar sayesinde Yeniköy Motors, yalnızca otomobil satışıyla değil, satış sonrası hizmetleriyle de sektörde iddialı bir oyuncu haline gelmiştir.
    </p>

    <p>
      2023 yılında Çin'in en köklü ve prestijli otomobil markalarından Hongqi'nin Türkiye distribütörlüğünü üstlenerek dikkatleri üzerine çekmiştir. Hongqi, Çin otomotiv endüstrisinin en prestijli markalarından biri olarak, 1958 yılından bu yana lüks ve yüksek performanslı otomobiller üretmektedir. Hongqi Türkiye, lüks ve konforu bir araya getirerek benzersiz bir sürüş deneyimi sunmaktadır.
    </p>

    <p>
      2025 yılına büyük bir iş birliği ile giriş yapan Yeniköy Motors, ünlü İngiliz otomobil üreticisi Morgan Motor Company ile distribütörlük anlaşması imzalayarak Morgan Motor'ın ikonik ve tamamen el yapımı otomobillerini Türkiye yollarına kazandırmıştır. Morgan ile yaptığı anlaşmayla beraber Aston Martin'den sonra Türkiye'deki ikinci İngiliz markasını portföyüne katmıştır. Bu iş birliği, şirketin premium ve lüks otomobil markaları portföyünü genişletmesine ve Türkiye otomotiv pazarındaki konumunu daha da güçlendirmesine olanak sağlamıştır.
    </p>
  </div>
</section>
  <!-- Alt Bilgi / Footer -->
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

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Arama butonu ve inputu
      const searchBtn = document.getElementById('searchBtn');
      const searchInput = document.getElementById('searchInput');
      const searchForm = document.getElementById('searchForm');

      searchBtn.addEventListener('click', () => {
        if (searchInput.classList.contains('active')) {
          searchInput.classList.remove('active');
          searchForm.style.display = 'none';
        } else {
          searchForm.style.display = 'inline-block';
          searchInput.classList.add('active');
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
        // erişilebilirlik için
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
</body>
</html>
