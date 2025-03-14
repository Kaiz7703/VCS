import socket
import base64

HOST = "localhost"
PORT = 80
username = "test"
password = "test123QWE@AD"
image_path = "test.jpg"

# Đọc file ảnh
with open(image_path, "rb") as f:
    image_data = f.read()

boundary = "----WebKitFormBoundary7MA4YWxkTrZu0gW"
content_type = "image/jpeg"
auth_token = base64.b64encode(f"{username}:{password}".encode()).decode()

# Tạo HTTP multipart form-data request
body = f"""--{boundary}
Content-Disposition: form-data; name="file"; filename="{image_path}"
Content-Type: {content_type}

""".encode() + image_data + f"""
--{boundary}--""".encode()

headers = f"""POST /wp-json/wp/v2/media HTTP/1.1
Host: {HOST}
Authorization: Basic {auth_token}
Content-Type: multipart/form-data; boundary={boundary}
Content-Length: {len(body)}
Connection: close

""".replace("\n", "\r\n").encode()

# Gửi request
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((HOST, PORT))
s.sendall(headers + body)

# Nhận phản hồi
response = b""
while True:
    data = s.recv(4096)
    if not data:
        break
    response += data

s.close()

# In ra URL ảnh được upload
if b'"source_url":"' in response:
    url_start = response.find(b'"source_url":"') + len(b'"source_url":"')
    url_end = response.find(b'"', url_start)
    print("Ảnh được upload:", response[url_start:url_end].decode())
else:
    print("Upload thất bại!")
