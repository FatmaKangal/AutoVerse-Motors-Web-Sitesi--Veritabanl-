<?php
include 'auth.php';
include 'config/db.php';

// ID kontrolü
if (!isset($_GET['id'])) {
    header("Location: cars-list.php");
    exit;
}

$id = $_GET['id'];

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $yil = $_POST['yil'];
    $fiyat = str_replace(['.', ','], '', $_POST['fiyat']); // Noktalı girişlerde sorun olmaması için
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

    // Eski resmi al
    $stmt = $conn->prepare("SELECT resim_yolu FROM cars WHERE id = ?");
    $stmt->execute([$id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
    $eski_resim = $car['resim_yolu'];

    // Yeni resim kontrolü
    if (!empty($_FILES['resim']['name'])) {
        $resim_ad = uniqid() . '_' . basename($_FILES['resim']['name']);
        $hedef_dosya = '../uploads/' . $resim_ad;
        move_uploaded_file($_FILES['resim']['tmp_name'], $hedef_dosya);
    } else {
        $resim_ad = $eski_resim;
    }

    // Araç tablosunu güncelle
    $stmt = $conn->prepare("UPDATE cars SET marka = ?, model = ?, yil = ?, fiyat = ?, tur = ?, resim_yolu = ?, aciklama = ? WHERE id = ?");
    $stmt->execute([$marka, $model, $yil, $fiyat, $tur, $resim_ad, $aciklama, $id]);

    // Teknik özelliklerin varlığını kontrol et, varsa güncelle, yoksa ekle
    $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM car_technical_specs WHERE car_id = ?");
    $stmtCheck->execute([$id]);
    $exists = $stmtCheck->fetchColumn();

    if ($exists) {
        // Güncelle
        $stmtSpec = $conn->prepare("UPDATE car_technical_specs SET 
            motor_hacmi = ?, beygir_gucu = ?, yakit_turu = ?, vites_turu = ?, cekis = ?, renk = ?, garanti_durumu = ?, ek_bilgiler = ?
            WHERE car_id = ?");
        $stmtSpec->execute([$motor_hacmi, $beygir_gucu, $yakit_turu, $vites_turu, $cekis, $renk, $garanti_durumu, $ek_bilgiler, $id]);
    } else {
        // Ekle
        $stmtSpec = $conn->prepare("INSERT INTO car_technical_specs 
            (car_id, motor_hacmi, beygir_gucu, yakit_turu, vites_turu, cekis, renk, garanti_durumu, ek_bilgiler) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtSpec->execute([$id, $motor_hacmi, $beygir_gucu, $yakit_turu, $vites_turu, $cekis, $renk, $garanti_durumu, $ek_bilgiler]);
    }

    header("Location: cars-list.php");
    exit;
}

// Araç bilgisi ve teknik özellikleri çek
$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->execute([$id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    echo "Araç bulunamadı.";
    exit;
}

$stmtSpec = $conn->prepare("SELECT * FROM car_technical_specs WHERE car_id = ?");
$stmtSpec->execute([$id]);
$techSpecs = $stmtSpec->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Araç Düzenle</title>
</head>
<body>
    <h2>Araç Bilgilerini Düzenle</h2>

    <form method="post" enctype="multipart/form-data">
        Marka: <input type="text" name="marka" value="<?= htmlspecialchars($car['marka']) ?>" required><br><br>
        Model: <input type="text" name="model" value="<?= htmlspecialchars($car['model']) ?>" required><br><br>
        Yıl: <input type="number" name="yil" value="<?= $car['yil'] ?>" required><br><br>
        
        Fiyat (TL): <input type="text" name="fiyat" value="<?= number_format($car['fiyat'], 0, ',', '.') ?>" required><br><br>
        
        Tür: <input type="text" name="tur" value="<?= htmlspecialchars($car['tur']) ?>" required><br><br>
        Açıklama: <br>
        <textarea name="aciklama" rows="4" cols="40"><?= htmlspecialchars($car['aciklama']) ?></textarea><br><br>

        Mevcut Resim: <br>
        <img src="../uploads/<?= htmlspecialchars($car['resim_yolu']) ?>" width="150"><br><br>

        Yeni Resim (isteğe bağlı): <input type="file" name="resim"><br><br>

        <h3>Teknik Özellikler</h3>
        <label>Motor Hacmi: <input type="text" name="motor_hacmi" value="<?= htmlspecialchars($techSpecs['motor_hacmi'] ?? '') ?>"></label><br><br>
        <label>Beygir Gücü: <input type="text" name="beygir_gucu" value="<?= htmlspecialchars($techSpecs['beygir_gucu'] ?? '') ?>"></label><br><br>
        <label>Yakıt Türü: <input type="text" name="yakit_turu" value="<?= htmlspecialchars($techSpecs['yakit_turu'] ?? '') ?>"></label><br><br>
        <label>Vites Türü: <input type="text" name="vites_turu" value="<?= htmlspecialchars($techSpecs['vites_turu'] ?? '') ?>"></label><br><br>
        <label>Çekiş: <input type="text" name="cekis" value="<?= htmlspecialchars($techSpecs['cekis'] ?? '') ?>"></label><br><br>
        <label>Renk: <input type="text" name="renk" value="<?= htmlspecialchars($techSpecs['renk'] ?? '') ?>"></label><br><br>
        <label>Garanti Durumu: <input type="text" name="garanti_durumu" value="<?= htmlspecialchars($techSpecs['garanti_durumu'] ?? '') ?>"></label><br><br>
        <label>Ek Bilgiler:<br>
          <textarea name="ek_bilgiler" rows="3" cols="40"><?= htmlspecialchars($techSpecs['ek_bilgiler'] ?? '') ?></textarea>
        </label><br><br>

        <button type="submit">Güncelle</button>
    </form>
</body>
</html>
