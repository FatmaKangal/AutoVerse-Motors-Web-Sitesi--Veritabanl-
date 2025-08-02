<?php
include 'config/db.php'; // Veritabanı bağlantısı

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $yil = (int) $_POST['yil'];

    // Fiyat: Nokta ve virgül farkını düzelterek float yap
    $fiyat_raw = str_replace(['.', ','], ['', '.'], $_POST['fiyat']);
    $fiyat = floatval($fiyat_raw);

    $tur = $_POST['tur'];
    $aciklama = $_POST['aciklama'];

    // Teknik özellikler
    $motor_hacmi = $_POST['motor_hacmi'] ?? '';
    $beygir_gucu = $_POST['beygir_gucu'] ?? '';
    $yakit_turu = $_POST['yakit_turu'] ?? '';
    $vites_turu = $_POST['vites_turu'] ?? '';
    $cekis = $_POST['cekis'] ?? '';
    $renk = $_POST['renk'] ?? '';
    $garanti_durumu = $_POST['garanti_durumu'] ?? '';
    $ek_bilgiler = $_POST['ek_bilgiler'] ?? '';

    try {
        // 1. Araç bilgilerini ekle
        $stmt = $conn->prepare("INSERT INTO cars (marka, model, yil, fiyat, tur, aciklama) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$marka, $model, $yil, $fiyat, $tur, $aciklama]);
        $car_id = $conn->lastInsertId();

        // 2. Teknik özellikleri ekle
        $stmtSpec = $conn->prepare("INSERT INTO car_technical_specs 
          (car_id, motor_hacmi, beygir_gucu, yakit_turu, vites_turu, cekis, renk, garanti_durumu, ek_bilgiler) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtSpec->execute([$car_id, $motor_hacmi, $beygir_gucu, $yakit_turu, $vites_turu, $cekis, $renk, $garanti_durumu, $ek_bilgiler]);

        // 3. Görselleri yükle
        if (!empty($_FILES['resimler']['name'][0])) {
            $uploadDir = '../uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['resimler']['tmp_name'] as $index => $tmpName) {
                $fileName = basename($_FILES['resimler']['name'][$index]);
                $targetFile = $uploadDir . time() . '_' . $fileName;

                if (move_uploaded_file($tmpName, $targetFile)) {
                    $stmtImg = $conn->prepare("INSERT INTO cars_images (car_id, image_path) VALUES (?, ?)");
                    $stmtImg->execute([$car_id, $targetFile]);
                }
            }
        }

        echo "<p style='color:green;'>Araç başarıyla eklendi!</p>";
    } catch (Exception $e) {
        echo "<p style='color:red;'>Hata: " . $e->getMessage() . "</p>";
    }
}
?>

<h2>Yeni Araç Ekle</h2>
<form action="" method="post" enctype="multipart/form-data">
  <label>Marka: <input type="text" name="marka" required></label><br><br>
  <label>Model: <input type="text" name="model" required></label><br><br>
  <label>Yıl: <input type="number" name="yil" required></label><br><br>

  <label>Fiyat (sadece rakam, örn: 1550000): 
    <input type="text" name="fiyat" required pattern="[\d.,]+" title="Sadece rakam, nokta veya virgül kullanın">
  </label><br><br>

  <label>Tür: <input type="text" name="tur" required></label><br><br>

  <label>Açıklama:<br>
    <textarea name="aciklama" rows="4" cols="50"></textarea>
  </label><br><br>

  <h3>Teknik Özellikler</h3>
  <label>Motor Hacmi: <input type="text" name="motor_hacmi"></label><br><br>
  <label>Beygir Gücü: <input type="text" name="beygir_gucu"></label><br><br>
  <label>Yakıt Türü: <input type="text" name="yakit_turu"></label><br><br>
  <label>Vites Türü: <input type="text" name="vites_turu"></label><br><br>
  <label>Çekiş: <input type="text" name="cekis"></label><br><br>
  <label>Renk: <input type="text" name="renk"></label><br><br>
  <label>Garanti Durumu: <input type="text" name="garanti_durumu"></label><br><br>
  <label>Ek Bilgiler:<br>
    <textarea name="ek_bilgiler" rows="3" cols="50"></textarea>
  </label><br><br>

  <label>Görseller (çoklu): <input type="file" name="resimler[]" multiple></label><br><br>

  <button type="submit">Aracı Ekle</button>
</form>
