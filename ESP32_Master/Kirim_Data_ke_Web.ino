void uploadToDatabase(String data) {
    if (WiFi.status() == WL_CONNECTED) {  // Pastikan sudah terhubung ke WiFi
        HTTPClient http;
        http.begin(serverName);  // Inisialisasi HTTP client
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");  // Header request

        // Siapkan data POST
        String postData = "data=" + data;

        // Kirim data POST
        int httpResponseCode = http.POST(postData);

        if (httpResponseCode > 0) {
            String response = http.getString();  // Ambil respons dari server
            Serial.print("HTTP Response code: ");
            Serial.println(httpResponseCode);
            Serial.println("Response: " + response);
        } else {
            Serial.print("Error code: ");
            Serial.println(httpResponseCode);
        }

        http.end();  // Tutup koneksi
    } else {
        Serial.println("WiFi Disconnected");
    }
}