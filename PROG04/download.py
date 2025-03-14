def http_download(host, path, filename):
    request = f"GET {path} HTTP/1.1\r\nHost: {host}\r\nConnection: close\r\n\r\n"

    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
        s.connect((host, 80))
        s.sendall(request.encode())

        response = b""
        while True:
            data = s.recv(4096)
            if not data:
                break
            response += data

    # Lấy phần dữ liệu từ HTTP response
    content = response.split(b"\r\n\r\n", 1)[1]

    # Ghi file
    with open(filename, "wb") as f:
        f.write(content)
    
    print(f"File {filename} đã được tải về.")

# Download ảnh hoặc tài liệu từ WordPress
http_download("blogtest.vnprogramming.com", "/wp-content/uploads/sample.pdf", "sample.pdf")
