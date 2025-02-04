<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bot Oluşturma</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-container {
            width: 50%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h2>Telegram Botu Oluştur</h2>

    <div class="form-container">
        <!-- Form Başlangıcı -->
        <form action="botnet.php" method="POST">
            <label for="token">Telegram API Token:</label><br>
            <input type="text" id="token" name="token" placeholder="API Token'i buraya girin" required><br><br>

            <label for="filename">Dosya Adı (varsayılan: telegram_bot.php):</label><br>
            <input type="text" id="filename" name="filename" value="telegram_bot.php"><br><br>

            <input type="submit" value="Botu Oluştur">
        </form>
    </div>
</body>
</html>
