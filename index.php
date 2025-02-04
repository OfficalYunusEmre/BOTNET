<?php
session_start(); // Oturum başlatılıyor

// Eğer kullanıcı zaten giriş yaptıysa, doğrudan panel.php sayfasına yönlendir
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: panel.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kullanıcıdan gelen token
    if (isset($_POST['token'])) {
        $token = $_POST['token']; // Token'ı alıyoruz
    } else {
        $error = "Token eksik.";
    }

    // Eğer token var ise veritabanına bağlanıp kontrol yapıyoruz
    if (isset($token)) {
        // Veritabanı bağlantısı
        include 'database.php';

        // Token'ı veritabanında kontrol et
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login_token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Eğer token geçerli bir kullanıcıya aitse
        if ($user) {
            // Kullanıcıyı giriş yapmış olarak işaretle
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username']; // Kullanıcı adını oturumda saklayalım
            header("location: panel.php"); // Panel sayfasına yönlendir
            exit;
        } else {
            // Hatalı token durumu
            $error = "Geçersiz token.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Token ile Giriş Yap</h2>
        
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        
        <form method="POST">
            <input type="text" name="token" placeholder="Giriş Token'ı" required>
            <button type="submit">Giriş Yap</button>
        </form>
    </div>
</body>
</html>
