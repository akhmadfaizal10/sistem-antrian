#include "USBPrinter.h"
#include "ESC_POS_Printer.h"
#include <Wire.h>
#define I2C_ADDRESS 8 // Alamat I2C Arduino (sesuaikan dengan ESP32)

class PrinterOper : public USBPrinterAsyncOper {
public:
    uint8_t OnInit(USBPrinter *pPrinter);
};

uint8_t PrinterOper::OnInit(USBPrinter *pPrinter) {
    Serial.println(F("USB Printer OnInit"));
    return 0;
}

USB myusb;
PrinterOper AsyncOper;
USBPrinter uprinter(&myusb, &AsyncOper);
ESC_POS_Printer printer(&uprinter);

int receivedData = 0;  // Variabel untuk menyimpan data yang diterima dari ESP32

void setup() {
  Serial.begin(115200);     // Memulai komunikasi serial untuk debugging
  pin();
}

void loop() {
  myusb.Task();
  delay(100);
}

// Fungsi untuk menerima data dari ESP32 (master)
void receiveData(int byteCount) {
  while (Wire.available()) {
    receivedData = Wire.read();  // Membaca data yang diterima dari master
    Serial.print("Data diterima dari ESP32: ");
    Serial.println(receivedData);
    delay(200); // Debounce delay

    printer.reset();
    printer.setDefault();

    printer.justify('C');  // Pusatkan teks
    printer.setSize('L');  // Ukuran besar
    printer.println(F("Nomor Antrian"));
    printer.setSize('M');  // Ukuran sedang
    printer.println(receivedData);  // Cetak nomor antrian
    printer.feed(10);
    printer.lidatacutter();  // Potong kertas

  }
}
