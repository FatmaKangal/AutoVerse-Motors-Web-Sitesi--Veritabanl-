<?php
require_once 'auth.php';  // Oturum kontrolü ve session_start içerir
require_once 'config/db.php'; // Veritabanı bağlantısı

// Araçları çek (en yeniden eskiye)
$stmt = $conn->query("SELECT * FROM cars ORDER BY id DESC");
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Admin Panel - Araç Listesi</title>
    <link rel="stylesheet" href="assets/css/admin-style.css" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        img {
            max-width: 120px;
            height: auto;
        }
        .btn-delete {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Admin Panel - Araçlar</h1>
    <nav>
        <a href="ekle.php">Yeni Araç Ekle</a> | 
        <a href="dashboard.php">Ana Sayfa</a> | 
        <a href="logout.php">Çıkış Yap</a>
    </nav>
    <br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Resim</th>
                <th>Marka</th>
                <th>Model</th>
                <th>Yıl</th>
                <th>Fiyat</th>
                <th>Tür</th>
                <th>Açıklama</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($cars) > 0): ?>
                <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?= htmlspecialchars($car['id']) ?></td>
                    <td>
                        <?php if (!empty($car['resim_yolu'])): ?>
                            <img src="../<?= htmlspecialchars($car['resim_yolu']) ?>" alt="<?= htmlspecialchars($car['marka'].' '.$car['model']) ?>">
                        <?php else: ?>
                            Resim yok
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($car['marka']) ?></td>
                    <td><?= htmlspecialchars($car['model']) ?></td>
                    <td><?= htmlspecialchars($car['yil']) ?></td>
                    <td><?= htmlspecialchars(number_format($car['fiyat'], 2, ',', '.')) ?> ₺</td>
                    <td><?= htmlspecialchars($car['tur']) ?></td>
                    <td><?= htmlspecialchars($car['aciklama']) ?></td>
                    <td>
                        <a href="duzenle.php?id=<?= $car['id'] ?>">Düzenle</a> | 
                        <a href="car-delete.php?id=<?= $car['id'] ?>" class="btn-delete" onclick="return confirm('Bu aracı silmek istediğinize emin misiniz?');">Sil</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="9">Kayıtlı araç bulunamadı.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
