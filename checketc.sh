#!/bin/bash

LOG_FILE="/var/log/checketc.log"
EMAIL="root@localhost"
LAST_STATE="/var/log/etc_snapshot.txt"
CURRENT_STATE="/var/log/etc_snapshot_tmp.txt"

TIMESTAMP=$(date "+%H:%M:%S %d/%m/%Y")

echo "[Log checketc - $TIMESTAMP]" > "$LOG_FILE"

find /etc -type f -print0 | xargs -0 stat --format "%Y %n" | sort > "$CURRENT_STATE"

if [ ! -f "$LAST_STATE" ]; then
    mv "$CURRENT_STATE" "$LAST_STATE"
    echo "Trạng thái ban đầu của /etc." >> "$LOG_FILE"
    exit 0
fi

echo "=== File tạo mới ===" >> "$LOG_FILE"
comm -13 <(cut -d' ' -f2- "$LAST_STATE") <(cut -d' ' -f2- "$CURRENT_STATE") | while read -r file; do
    echo "$file" >> "$LOG_FILE"
    if file "$file" | grep -q "text"; then
        echo "------ Nội dung 10 dòng đầu tiên ------" >> "$LOG_FILE"
        head -n 10 "$file" >> "$LOG_FILE"
        echo "--------------------------------------" >> "$LOG_FILE"
    fi
done

echo "" >> "$LOG_FILE"

echo "=== File sửa đổi ===" >> "$LOG_FILE"
awk 'NR==FNR{a[$2]=$1; next} ($2 in a) && ($1 != a[$2]) {print $2}' "$LAST_STATE" "$CURRENT_STATE" >> "$LOG_FILE"

echo "" >> "$LOG_FILE"

echo "=== File bị xóa ===" >> "$LOG_FILE"
comm -23 <(cut -d' ' -f2- "$LAST_STATE") <(cut -d' ' -f2- "$CURRENT_STATE") >> "$LOG_FILE"

mv "$CURRENT_STATE" "$LAST_STATE"

mail -s "Báo cáo kiểm tra thư mục /etc" "$EMAIL" < "$LOG_FILE"
