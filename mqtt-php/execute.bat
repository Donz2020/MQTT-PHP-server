@echo off
START /b /d "C:\Users\stage\Downloads\mosquitto\" mosquitto.exe -c "mosquitto.conf"


START /b /d "C:\Users\stage\Downloads\mqtt-php\"
START /b php .\server.php --server "localhost:8883" --logfile "connLog.txt" --user "test" --pass "test" --database "LEOonline"