<?php
// Form g nderildiğinde dosya işleme işlemleri yapılacak
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gelen form verilerini alalım
    $ip = isset($_POST['ip']) ? $_POST['ip'] : '';
    $port = isset($_POST['port']) ? $_POST['port'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';

    // Eğer eksik alan varsa
    if (empty($ip) || empty($port) || empty($format)) {
        // Hata mesajı g sterilecek
        echo "<div style='color: red;'>Form doğru şekilde g nderilmedi. L tfen t m alanları doldurduğunuzdan emin olun.</div>";
    } else {
        // Formda t m alanlar varsa işlem yapılacak
        echo "<div style='color: green;'>Botnet başarılı bir şekilde başlatıldı. IP: $ip, Port: $port, Format: $format</div>";

        // Botnet başlatma betiği oluşturulacak
        $botnet_script = "import os\nimport sys\nimport subprocess\n\ndef start_botnet(ip, port, format):\n    # Botnet başlatma işlemini gerçekleştirmek için gerekli kodları ekleyin.\n    # Örneğin, botnet başlatma işlemini bir Python betiği içinde yapabilirsiniz.\n    # Bu  rnek, basit bir botnet başlatma işlemi gerçekleştirmek için kullanılmaktadır.\n    print(\"Botnet başlatılıyor...\")\n    print(f\"IP: {ip}, Port: {port}, Format: {format}\")\n\n    # Botnet başlatma işlemini gerçekleştirmek için gerekli kodları ekleyin.\n    # Örneğin, botnet başlatma işlemini bir Python betiği içinde yapabilirsiniz\n    \nstart_botnet(\"$ip\", $port, \"$format\")\n";

        // Betiği bir dosyaya kaydedelim
        $filename = "botnet_" . date('YmdHis') . ".py";
        file_put_contents($filename, $botnet_script);

        // Betiği çalıştıralım
        exec("python " . $filename);

        // Betiği sunucuya kaydetmek isterseniz
        // move_uploaded_file($filename, "server/$filename");

        // Formu temizleyerek tekrar g nderilmesini engelleyebiliriz
        $ip = '';
        $port = '';
        $format = '';
    }
}
?>

<!-- HTML kodu -->
<html>
<head>
    <title>Bot Net Programı</title>
    <style>
        /* CSS kodları */
    </style>
</head>
<body>
    <!-- HTML formu -->
    <form action="botnet.php" method="POST">
        <label for="ip">IP Adresi:</label>
        <input type="text" id="ip" name="ip" placeholder="IP adresini girin" value="<?php echo $ip; ?>" required>

        <label for="port">Port Numarası:</label>
        <input type="number" id="port" name="port" placeholder="Port numarasını girin" value="<?php echo $port; ?>" required>

        <label for="format">Dosya Formatı Seçin:</label>
        <select name="format" id="format" required>
            <option value="">Seçiniz</option>
            <option value="exe" <?php if ($format == 'exe') echo 'selected'; ?>>.exe</option>
            <option value="jpg" <?php if ($format == 'jpg') echo 'selected'; ?>>.jpg</option>
            <option value="py" <?php if ($format == 'py') echo 'selected'; ?>>.py</option>
        </select>

        <input type="submit" value="Botnet' serverini olusturunuz">
    </form>

    <div class="footer">
        <p>Desteklenen dosya formatları: .exe, .jpg, .py</p>
    </div>
</body>
</html>