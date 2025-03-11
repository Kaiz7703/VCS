#!/bin/bash

echo "===== Thông tin hệ thống ====="

echo "Tên máy: $(hostname)"
echo "Bản phân phối: $(lsb_release -d | cut -f2)"

echo "Phiên bản hệ điều hành: $(uname -r)"

echo "Thông tin CPU:"
lscpu | grep -E "Model name|Architecture|CPU MHz" | sed 's/^/  /'

echo "Tổng bộ nhớ vật lý: $(free -m | awk '/Mem:/ {print $2}') MB"

echo "Dung lượng ổ đĩa trống: $(df -BM --total | awk '/^total/ {print $4}')"

echo "Danh sách địa chỉ IP:"
ip -4 addr show | awk '/inet / {print "  "$2}'

echo "Danh sách user:"
cut -d: -f1 /etc/passwd | sort

echo "Tiến trình chạy với quyền root:"
ps -U root -u root u | awk '{print $11}' | sort | uniq

echo "Các port đang mở:"
ss -tuln | awk 'NR>1 {print $5}' | awk -F: '{print $NF}' | sort -n | uniq

echo "Các thư mục có quyền ghi cho other:"
find / -type d -perm -o=w 2>/dev/null

echo "Danh sách gói phần mềm đã cài:"
dpkg-query -W -f='${binary:Package} ${Version}\n' | sort

echo "===== Kết thúc ====="
