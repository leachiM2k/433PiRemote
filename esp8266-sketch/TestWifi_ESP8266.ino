#include <ESP8266WiFi.h>
#include <WiFiManager.h>
#include <ESP8266mDNS.h>
#include <ESP8266WebServer.h>
#include <ArduinoJson.h>
#include <ESPiLight.h>
#include <FS.h>

#define TRANSMITTER_PIN D3

ESPiLight rf(TRANSMITTER_PIN);

const char* hostname = "leaNode1";

WiFiManager wifiManager;

ESP8266WebServer server(80);

void handleNotFound() {
  String message = "File Not Found\n\n";
  message += "URI: ";
  message += server.uri();
  message += "\nMethod: ";
  message += (server.method() == HTTP_GET) ? "GET" : "POST";
  message += "\nArguments: ";
  message += server.args();
  message += "\n";
  for (uint8_t i = 0; i < server.args(); i++) {
    message += " " + server.argName(i) + ": " + server.arg(i) + "\n";
  }
  server.send(404, "text/plain", message);
}

const char PROGMEM APPLICATION_JSON[] = "application/json";

const int ROWS = 3;
String switches[ROWS][4] = {
  {"Schrank","elro_800_switch","{\"systemcode\":6,\"unitcode\":1,\"on\":1}","{\"systemcode\":6,\"unitcode\":1,\"off\":1}"},
  {"Fenster","elro_800_switch","{\"systemcode\":6,\"unitcode\":2,\"on\":1}","{\"systemcode\":6,\"unitcode\":2,\"off\":1}"},
  {"Sessel","elro_800_switch","{\"systemcode\":6,\"unitcode\":4,\"on\":1}","{\"systemcode\":6,\"unitcode\":4,\"off\":1}"}
};

void setup() {
  Serial.begin(115200);
  Serial.println();
  Serial.println("Starting ...");

  wifiManager.setConfigPortalTimeout(3 * 60);
  if (!wifiManager.autoConnect("leaNode1-SETUP", "lacklack")) {
    Serial.println(F("Setup timed out, starting AP"));
    WiFi.mode(WIFI_AP);
    WiFi.softAP("leaNode1", "lacklack");
  }

  Serial.print(F("Connected! IP address: "));
  Serial.println(WiFi.localIP());

  // start mdns service
  MDNS.begin(hostname);

  SPIFFS.begin();
  {
    Serial.println("SPIFFS contents:");

    Dir dir = SPIFFS.openDir("/");
    while (dir.next()) {
      String fileName = dir.fileName();
      size_t fileSize = dir.fileSize();
      Serial.printf("FS File: %s, size: %s\n", fileName.c_str(), String(fileSize).c_str());
    }
    Serial.printf("\n");
  }
  
  server.on("/", HTTP_GET, []() {
    File file = SPIFFS.open("/index.html.gz", "r");
    server.streamFile(file, "text/html");
    file.close();
  });

  server.on("/api", HTTP_GET, []() {
    String output = "";
    
    const size_t capacity = JSON_ARRAY_SIZE(2) + 2*JSON_OBJECT_SIZE(3);
    DynamicJsonDocument doc(1024);

    for (int i = 0; i < ROWS; i++) {
      JsonObject doc_0 = doc.createNestedObject();
      doc_0["name"] = switches[i][0];
      //doc_0["protocol"] = switches[i][1];
      //doc_0["on"] = switches[i][2];
      //doc_0["off"] = switches[i][3];
    }
    
    serializeJson(doc, output);
    server.send(200, APPLICATION_JSON, output);
  });

  server.on("/api/switch", HTTP_GET, []() {
    int id = server.arg("id").toInt();
    String action = server.arg("action");
    char c[50];
    sprintf(c, "Do action '%s' on switch %s (%s)", action.c_str(), switches[id][0].c_str(), switches[id][1].c_str());
    Serial.println(c);
    if(action == "off") {
      Serial.println(switches[id][3]);
      rf.send(switches[id][1], switches[id][3]);
    } else if(action == "on") {
      Serial.println(switches[id][2]);
      rf.send(switches[id][1], switches[id][2]);
    }
    server.send(200, APPLICATION_JSON, F("{\"success\":true}"));
  });
  
  server.onNotFound(handleNotFound);
  server.begin();
  Serial.println("HTTP server started");
}

void loop() {
  server.handleClient();
}
