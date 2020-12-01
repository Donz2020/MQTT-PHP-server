@echo off
START /b /d "C:\Users\dony9\Desktop\mosquitto2\" mosquitto.exe -c "mosquitto.conf"


START /b /d "D:\progetti_stage\mqtt-php\"
START /b php .\server.php

