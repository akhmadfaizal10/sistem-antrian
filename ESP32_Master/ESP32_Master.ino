#include <Wire.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiManager.h>
#define I2C_ADDRESS 8       // Alamat I2C Arduino

// Inisialisasi I2C
const int pin_tombol = 13; // Pin untuk tombol utama
const int pin_reset = 12; // Pin untuk tombol reset
bool tombolTerakhir = LOW; // Status terakhir tombol utama
bool resetTerakhir = LOW; // Status terakhir tombol reset
int tombolTerakhirReset = LOW;   // Store the previous state of the reset button
int hitung = 0; // Inisialisasi variabel hitung

const char* serverName = "http://192.168.43.7/antrian/upload.php"; // Ganti dengan alamat server

void setup() {
    Serial.begin(115200); // Memulai komunikasi serial untuk debugging
    Wire.begin(21, 22);    // Inisialisasi I2C pada pin 21 (SDA) dan 22 (SCL)
    pin();

}

void loop() {
    cetak();
}


