void pin(){
  Wire.begin(I2C_ADDRESS);  // Inisialisasi Arduino sebagai slave pada alamat I2C
  Wire.onReceive(receiveData); // Menentukan fungsi callback untuk menerima data
  while (!Serial && millis() < 3000) delay(1);
  if (myusb.Init())
      Serial.println(F("USB host failed to initialize"));

  delay(200);
  Serial.println(F("USB Host init OK"));
}