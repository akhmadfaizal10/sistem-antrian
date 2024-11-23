void cetak() {
    int tombol = digitalRead(pin_tombol);
    resetTerakhir = digitalRead(pin_reset);  // Membaca status tombol reset

    // Jika tombol utama ditekan dan status terakhir adalah tidak ditekan
    if (tombol == HIGH && tombolTerakhir == LOW) {
        hitung++;  // Tambah hitung
        Serial.print("Tombol tertekan. Antrian ke: ");
        Serial.println(hitung);
        uploadToDatabase("antrian ke "+String(hitung));

        // Kirim data hitung ke Arduino melalui I2C
        Wire.beginTransmission(I2C_ADDRESS);
        Wire.write(hitung);  // Mengirim data hitung (sebagai byte)
        Wire.endTransmission();

        delay(200);  // Debounce delay
    }

    // Jika tombol reset ditekan dan status terakhir adalah tidak ditekan (dengan debounce)
    if (resetTerakhir == HIGH && tombolTerakhirReset == LOW) {
        hitung = 0; 
        String reset = "reset"; // Reset hitung
        Serial.println("Antrian direset.");
        uploadToDatabase(String(reset));
        // Kirim data reset (0) ke Arduino
        Wire.beginTransmission(I2C_ADDRESS);
        Wire.write(hitung);  // Kirimkan angka 0 (reset)
        Wire.endTransmission();

        delay(300);  // Debounce delay
    }

    // Simpan status tombol terakhir
    tombolTerakhir = tombol;
    tombolTerakhirReset = resetTerakhir;  // Simpan status tombol reset terakhir
}
