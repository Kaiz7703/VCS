import socket
import re

HOST = "localhost"  
PORT = 80  

request = f"GET / HTTP/1.1\r\nHost: {HOST}\r\nConnection: close\r\n\r\n"

# Kết nối TCP đến server
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((HOST, PORT))
s.sendall(request.encode())

# Nhận dữ liệu từ server
response = b""
while True:
    data = s.recv(4096)
    if not data:
        break
    response += data

s.close()

# Giải mã phản hồi HTTP
html = response.decode(errors="ignore")

# Trích xuất title bằng regex
match = re.search(r"<title>(.*?)</title>", html, re.IGNORECASE)
if match:
    print("Title:", match.group(1))
else:
    print("Không tìm thấy tiêu đề.")
