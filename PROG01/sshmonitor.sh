#!/bin/bash

LOG_FILE="/var/log/sshmonitor.log"
LAST_LOG="/var/log/ssh_last.log"
CURRENT_LOG="/var/log/ssh_current.log"
EMAIL="root@localhost"

touch "$LAST_LOG" "$CURRENT_LOG" "$LOG_FILE"

who | awk '{print $1, $5}' | sort > "$CURRENT_LOG"

if [ ! -s "$LAST_LOG" ]; then
    cp "$CURRENT_LOG" "$LAST_LOG"
    echo "Lần chạy đầu tiên, lưu trạng thái SSH ban đầu." >> "$LOG_FILE"
    exit 0
fi
NEW_LOGINS=$(comm -13 "$LAST_LOG" "$CURRENT_LOG")

echo "DEBUG: Last log:" >> "$LOG_FILE"
cat "$LAST_LOG" >> "$LOG_FILE"
echo "DEBUG: Current log:" >> "$LOG_FILE"
cat "$CURRENT_LOG" >> "$LOG_FILE"
echo "DEBUG: New logins detected:" >> "$LOG_FILE"
echo "$NEW_LOGINS" >> "$LOG_FILE"

if [ -n "$NEW_LOGINS" ]; then
    TIMESTAMP=$(date "+%H:%M:%S %d/%m/%Y")
    echo "[SSH Monitor - $TIMESTAMP]" >> "$LOG_FILE"
    echo "=== Danh sách phiên SSH mới ===" >> "$LOG_FILE"
    echo "$NEW_LOGINS" >> "$LOG_FILE"
    echo "-----------------------------------" >> "$LOG_FILE"

    echo "$NEW_LOGINS" | mail -s "Cảnh báo: Phát hiện đăng nhập SSH mới!" "$EMAIL"
fi

cp "$CURRENT_LOG" "$LAST_LOG"
