void pin(){
  WiFi.mode(WIFI_STA);
  pinMode(pin_tombol, INPUT); // Mengatur pin tombol utama sebagai input
  pinMode(pin_reset, INPUT); // Mengatur pin tombol reset sebagai input
  WiFiManager wm;
  bool res;
  res = wm.autoConnect("AutoConnectAP",""); // password protected ap

  if(!res) {
      Serial.println("Failed to connect");
      // ESP.restart();
  } 
  else {
      //if you get here you have connected to the WiFi    
      Serial.println("connected...yeey :)");
  }
}