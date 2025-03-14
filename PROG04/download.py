import socket
import re
import argparse

def download(url, remote_file):
    match = re.match(r'http://([^/:]+)(?::(\d+))?(/.*)?', url)
    if not match:
        return
    
    host, port, path = match.groups()
    port = int(port) if port else 80
    path = path if path else remote_file

    request = f"GET {path} HTTP/1.1\r\nHost: {host}\r\nConnection: close\r\n\r\n"

    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((host, port))
    s.sendall(request.encode())

    response = b""
    while True:
        data = s.recv(4096)
        if not data:
            break
        response += data
    s.close()

    header_end = response.find(b"\r\n\r\n")
    if header_end == -1:
        print("Lỗi khi tải file!")
        return

    body = response[header_end+4:]
    
    if body:
        print(f"Kích thước file ảnh: {len(body)} bytes")
    else:
        print("Không tìm thấy file ảnh!")

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("--url", required=True, help="URL của trang WordPress")
    parser.add_argument("--remote-file", required=True, help="Đường dẫn file cần tải")
    args = parser.parse_args()

    download(args.url, args.remote_file)
