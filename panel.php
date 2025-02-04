<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOTNET PANELİ</title>
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

        /* Bağlantılar ve butonlar */
        .panel-container a, .panel-container form {
            display: inline-block;
            margin: 15px 0;
            text-decoration: none;
            color: #fff;
        }

        .panel-container button {
            background-color: #28a745;
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            width: 250px;
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .panel-container button:hover {
            background-color: #218838;
        }

        /* Icon Button */
        .panel-container button i {
            margin-right: 10px;
        }

        .panel-container a:hover, .panel-container button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
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
        <h2>BOTNET YONETİCİ PANELİ</h2>

        <!-- Botları Görüntüle Linki -->
        <a href="bots.php">
            <button><i class="material-icons">group</i>Botları Görüntüle</button>
        </a>

        <!-- Kullanıcı Ekleme -->
        <form action="add_user.php" method="POST">
            <button type="submit"><i class="material-icons">person_add</i>Kullanıcı Ekle</button>
        </form>

        <!-- Harita Görüntüleme -->
        <a href="map.php">
            <button><i class="material-icons">map</i>Harita Görüntüle</button>
        </a>

        <!-- Bot Net Programı Oluştur -->
        <form action="botnet.php" method="POST">
            <button type="submit"><i class="material-icons">power</i>Bot Net Programı Oluştur</button>
        </form>

        <!-- Saldırıları Görüntüle -->
        <a href="attacks.php">
            <button><i class="material-icons">history</i>Saldırıları Görüntüle</button>
        </a>

        <!-- Çıkış Yap -->
        <a href="logout.php">
            <button><i class="material-icons">exit_to_app</i>Çıkış Yap</button>
        </a>
    </div>
</body>
</html>
