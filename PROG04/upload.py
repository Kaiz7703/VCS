import socket
import re
import argparse
import os
import mimetypes

def upload(url, username, password, file_path):
    match = re.match(r'http://([^/:]+)(?::(\d+))?(/.*)?', url)
    if not match:
        return
    
    host, port, path = match.groups()
    port = int(port) if port else 80
    path = path if path else "/wp-admin/async-upload.php"

    if not os.path.exists(file_path):
        print("File không tồn tại!")
        return

    file_name = os.path.basename(file_path)
    file_type = mimetypes.guess_type(file_path)[0] or "application/octet-stream"

    # Đọc nội dung file ảnh
    with open(file_path, "rb") as f:
        file_data = f.read()

    boundary = "----WebKitFormBoundary123456"
    body = (
        f"--{boundary}\r\n"
        f'Content-Disposition: form-data; name="async-upload"; filename="{file_name}"\r\n'
        f"Content-Type: {file_type}\r\n\r\n"
    ).encode() + file_data + (
        f"\r\n--{boundary}--\r\n"
    ).encode()

    request = (
        f"POST {path} HTTP/1.1\r\n"
        f"Host: {host}\r\n"
        f"Content-Type: multipart/form-data; boundary={boundary}\r\n"
        f"Content-Length: {len(body)}\r\n"
        f"Connection: close\r\n\r\n"
    ).encode() + body

    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((host, port))
    s.sendall(request)

    response = b""
    while True:
        data = s.recv(4096)
        if not data:
            break
        response += data
    s.close()

    response_text = response.decode(errors="ignore")

    match = re.search(r'"url":"(.*?)"', response_text)
    if match:
        print(f"Upload thành công. File URL: {match.group(1)}")
    else:
        print("Upload thất bại!")

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("--url", required=True, help="URL của trang WordPress")
    parser.add_argument("--user", required=True, help="Tên đăng nhập")
    parser.add_argument("--password", required=True, help="Mật khẩu")
    parser.add_argument("--local-file", required=True, help="Đường dẫn file cần upload")
    args = parser.parse_args()

    upload(args.url, args.user, args.password, args.local_file)
