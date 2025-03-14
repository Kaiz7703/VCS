import socket

HOST = "localhost"
PORT = 80
image_url = "/wp-content/uploads/test.jpg"  # Đường dẫn ảnh trên WordPress

request = f"GET {image_url} HTTP/1.1\r\nHost: {HOST}\r\nConnection: close\r\n\r\n"

# Kết nối TCP
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((HOST, PORT))
s.sendall(request.encode())

# Nhận phản hồi
response = b""
while True:
    data = s.recv(4096)
    if not data:
        break
    response += data

s.close()

# Tách phần header và dữ liệu file ảnh
header, _, body = response.partition(b"\r\n\r\n")

# Lưu ảnh
file_path = "downloaded.jpg"
with open(file_path, "wb") as f:
    f.write(body)

print(f"Ảnh đã tải về: {file_path}")
print(f"Kích thước file: {len(body)} bytes")
