<?php
$host = "localhost";
$username = "root"; // Veritabanı kullanıcı adı
$password = ""; // Veritabanı şifresi
$dbname = "panel_db"; // Veritabanı adı

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // PDO hata modunu etkinleştir
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantısı hatası: " . $e->getMessage());
}
?>
