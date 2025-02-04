<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Botnet Haritası</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .map-container {
            height: 100%;
        }

        /* Responsive Tasarım */
        @media (max-width: 768px) {
            .map-container {
                height: 400px;
            }
        }

        /* Harita üzerine bazı stil eklemeler */
        #map {
            width: 100%;
            height: 100%;
        }

        .popup-content {
            font-size: 14px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .coordinates {
            margin-top: 10px;
        }

        .botnet-info {
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>
    <div class="map-container" id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // Harita işlevselliği
        var map = L.map('map').setView([37.7749, -122.4194], 2); // Başlangıç merkezi

        // OpenStreetMap ile harita katmanını ekle
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Botnet verilerini almak için API'yi çağırma
        function getBotnetCount(country, lat, lng) {
            fetch('botnet_data.php?country=' + country)
                .then(response => response.json())
                .then(data => {
                    var botnetCount = data.botnet_count;
                    showPopup(lat, lng, country, botnetCount);
                })
                .catch(error => console.error('Error fetching botnet data:', error));
        }

        // Popup içeriği oluşturma
        function showPopup(lat, lng, country, botnetCount) {
            var popupContent = `
                <div class="popup-content">
                    <div class="title">Tıklanan Ülke: ${country}</div>
                    <div class="botnet-info">
                        Bu ülkede tespit edilen botnet sayısı: ${botnetCount}
                    </div>
                </div>
            `;

            // Popup'ı açmak
            L.popup()
                .setLatLng([lat, lng])
                .setContent(popupContent)
                .openOn(map);
        }

        // Haritaya tıklama olayı
        map.on('click', function(event) {
            var lat = event.latlng.lat;
            var lng = event.latlng.lng;

            // Koordinatlar üzerinden ülke bilgisi alınıyor (Bu, API veya başka bir yöntemle yapılabilir)
            var country = 'TR'; // Örneğin Türkiye'yi varsayıyoruz

            // Botnet sayısını almak
            getBotnetCount(country, lat, lng);
        });
    </script>
</body>
</html>
