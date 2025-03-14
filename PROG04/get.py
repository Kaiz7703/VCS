import socket

def http_get(host, path="/"):
    request = f"GET {path} HTTP/1.1\r\nHost: {host}\r\nConnection: close\r\n\r\n"

    # Tạo socket và kết nối đến server
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
        s.connect((host, 80))
        s.sendall(request.encode())

        response = b""
        while True:
            data = s.recv(4096)
            if not data:
                break
            response += data

    print(response.decode())

# Gửi GET request
http_get("blogtest.vnprogramming.com", "/")
