import socket
import argparse
import re
import os

def get_response(s):
    response = b""
    while True:
        chunk = s.recv(4096)
        if not chunk:
            break
        response += chunk
    return response.decode()

# Thiết lập parser để lấy tham số từ dòng lệnh
parser = argparse.ArgumentParser(description="Upload an image to WordPress Media Library")
parser.add_argument("--url", required=True, help="WordPress URL (e.g., http://localhost/wordpress)")
parser.add_argument("--user", required=True, help="WordPress username")
parser.add_argument("--password", required=True, help="WordPress password")
parser.add_argument("--local-file", required=True, help="Path to the image file")

args = parser.parse_args()

# Lấy thông tin từ tham số dòng lệnh
url = args.url.rstrip("/")  # Xóa dấu "/" cuối cùng nếu có
user = args.user
password = args.password
local_file = args.local_file

# Kiểm tra file tồn tại
if not os.path.isfile(local_file):
    print("File không tồn tại!")
    exit(1)

filename = os.path.basename(local_file)
filetype = filename.split(".")[-1]

# Tách domain từ URL
host = url.replace("http://", "").replace("https://", "").split("/")[0]

# Bước 1: Đăng nhập để lấy cookie
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((host, 80))
login_data = f"log={user}&pwd={password}&wp-submit=Log+In"
request = f"POST /wordpress/wp-login.php HTTP/1.1\r\nHost: {host}\r\n"
request += f"Content-Length: {len(login_data)}\r\n"
request += "Content-Type: application/x-www-form-urlencoded\r\n\r\n"
request += login_data
s.send(request.encode())

response = get_response(s)
s.close()

# Kiểm tra xem đăng nhập thành công không
if "Set-Cookie" not in response:
    print("Đăng nhập thất bại!")
    exit(1)

# Lấy cookie
cookies = "; ".join(re.findall(r"Set-Cookie: ([^;]+);", response))

# Bước 2: Lấy `_wpnonce` từ trang `media-new.php`
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((host, 80))
request = f"GET /wordpress/wp-admin/media-new.php HTTP/1.1\r\nHost: {host}\r\nCookie: {cookies}\r\n\r\n"
s.send(request.encode())

response = get_response(s)
s.close()

match = re.search(r'id="_wpnonce" name="_wpnonce" value="([a-zA-Z0-9]+)"', response)
if not match:
    print("Không tìm thấy _wpnonce!")
    exit(1)

_wpnonce = match.group(1)

# Bước 3: Upload file
boundary = "----WebKitFormBoundary123456"
with open(local_file, "rb") as f:
    file_content = f.read()

upload_data = (
    f"--{boundary}\r\n"
    f'Content-Disposition: form-data; name="name"\r\n\r\n{filename}\r\n'
    f"--{boundary}\r\n"
    f'Content-Disposition: form-data; name="action"\r\n\r\nupload-attachment\r\n'
    f"--{boundary}\r\n"
    f'Content-Disposition: form-data; name="_wpnonce"\r\n\r\n{_wpnonce}\r\n'
    f"--{boundary}\r\n"
    f'Content-Disposition: form-data; name="async-upload"; filename="{filename}"\r\n'
    f"Content-Type: image/{filetype}\r\n\r\n"
).encode() + file_content + f"\r\n--{boundary}--\r\n".encode()

request = (
    f"POST /wordpress/wp-admin/async-upload.php HTTP/1.1\r\n"
    f"Host: {host}\r\n"
    f"Cookie: {cookies}\r\n"
    f"Content-Length: {len(upload_data)}\r\n"
    f"Content-Type: multipart/form-data; boundary={boundary}\r\n"
    f"Connection: close\r\n\r\n"
).encode() + upload_data

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((host, 80))
s.send(request)

response = get_response(s)
s.close()

# Kiểm tra kết quả upload
if '"success":true' in response:
    match = re.search(r'"url":"(http[^"]+)"', response)
    if match:
        upload_url = match.group(1).replace("\\/", "/")
        print(f"Upload thành công. URL đến file: {upload_url}")
    else:
        print("Upload thành công nhưng không thấy URL.")
else:
    print("Upload thất bại.")