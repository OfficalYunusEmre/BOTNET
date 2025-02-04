<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: index.php");
    exit;
}

// Veritabanı bağlantısı
include 'database.php';

// Saldırıları almak için veritabanına sorgu
$stmt = $pdo->query("SELECT * FROM attacks ORDER BY attack_time DESC"); // Saldırıları tarihine göre sıralıyoruz
$attacks = $stmt->fetchAll(PDO::FETCH_ASSOC); // Sonuçları alıyoruz
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saldırı Geçmişi</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        /* Genel stil */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #2d2d2d;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #1a1a1a, #3d3d3d);
        }

        /* Panel konteyneri */
        .panel-container {
            background-color: #333;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            width: 80%;
            max-width: 900px;
            text-align: center;
        }

        h2 {
            color: #fff;
            font-size: 2.5rem;
            margin-bottom: 30px;
            font-weight: bold;
        }

        /* Saldırılar tablosu */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #555;
            padding: 10px;
        }

        th {
            background-color: #444;
            color: white;
        }

        td {
            background-color: #555;
            color: white;
        }

        /* Responsive Tasarım */
        @media (max-width: 768px) {
            .panel-container {
                width: 95%;
                padding: 20px;
            }

            h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="panel-container">
        <h2>Saldırı Geçmişi</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hedef URL</th>
                    <th>Bot Sayısı</th>
                    <th>Saldırı Zamanı</th>
                    <th>Durum</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attacks as $attack): ?>
                <tr>
                    <td><?php echo htmlspecialchars($attack['id']); ?></td>
                    <td><?php echo htmlspecialchars($attack['target_url']); ?></td>
                    <td><?php echo htmlspecialchars($attack['bot_count']); ?></td>
                    <td><?php echo htmlspecialchars($attack['attack_time']); ?></td>
                    <td><?php echo htmlspecialchars($attack['status']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
