import socket
import re
import argparse

def get_title(url):
    # Phân tích URL
    match = re.match(r'http://([^/:]+)(?::(\d+))?(/.*)?', url)
    if not match:
        return
    
    host, port, path = match.groups()
    port = int(port) if port else 80
    path = path if path else "/"

    # Kết nối đến server
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((host, port))

    # Gửi yêu cầu GET
    request = f"GET {path} HTTP/1.1\r\nHost: {host}\r\nConnection: close\r\n\r\n"
    s.sendall(request.encode())

    # Nhận phản hồi
    response = b""
    while True:
        data = s.recv(4096)
        if not data:
            break
        response += data
    s.close()

    # Chuyển đổi sang dạng text
    response_text = response.decode(errors="ignore")

    # Kiểm tra nếu có chuyển hướng 301/302
    if re.search(r"^HTTP/1\.[01] 3\d\d", response_text):
        location_match = re.search(r"Location: (.+)", response_text)
        if location_match:
            return get_title(location_match.group(1).strip())

    # Trích xuất title
    match = re.search(r'<title>(.*?)</title>', response_text, re.IGNORECASE)
    if match:
        print("Title:", match.group(1))

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("--url", required=True, help="URL của trang cần GET")
    args = parser.parse_args()
    
    get_title(args.url)
