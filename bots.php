<?php
// Veritabanı bağlantısı
include 'database.php';

// Botları almak için veritabanına sorgu
$stmt = $pdo->query("SELECT * FROM bots ORDER BY created_at DESC"); // Botları eklenme sırasına göre sıralıyoruz
$bots = $stmt->fetchAll(PDO::FETCH_ASSOC); // Sonuçları alıyoruz
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Botlar</title>
    <style>
        /* Genel stil */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Konteyner stil */
        .container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 80%;
            max-width: 1200px;
        }

        /* Başlık stili */
        h2 {
            text-align: center;
            color: #333;
        }

        /* Tablo stili */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #2d2d2d;
            color: white;
            font-weight: bold;
        }

        table tr:hover {
            background-color: #f5f5f5;
        }

        /* Alternatif satır renkleri */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Düğme stili */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            width: 100%;
            max-width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Responsive Tasarım */
        @media (max-width: 768px) {
            table, th, td {
                font-size: 14px;
            }

            .container {
                width: 90%;
                padding: 10px;
            }

            button {
                width: 80%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Botlar Listesi</h2>
        <?php if (count($bots) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bot Adı</th>
                        <th>Durum</th>
                        <th>Aktif DDoS Saldırısı</th> <!-- Yeni sütun -->
                        <th>IP Adresi</th>
                        <th>Kullanıcı Aracısı</th>
                        <th>Oluşturulma Tarihi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bots as $bot): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($bot['id']); ?></td>
                            <td><?php echo htmlspecialchars($bot['bot_name']); ?></td>
                            <td><?php echo isset($bot['status']) ? htmlspecialchars($bot['status']) : 'N/A'; ?></td>
                            <!-- Aktif DDoS Durumu -->
                            <td><?php echo isset($bot['ddos_status']) ? htmlspecialchars($bot['ddos_status']) : 'Yok'; ?></td>
                            <td><?php echo htmlspecialchars($bot['ip_address']); ?></td>
                            <td><?php echo htmlspecialchars($bot['user_agent']); ?></td>
                            <td><?php echo htmlspecialchars($bot['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Hiç bot bulunmamaktadır.</p>
        <?php endif; ?>
    </div>
</body>
</html>
