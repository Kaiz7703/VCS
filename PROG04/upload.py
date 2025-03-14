def http_upload(host, path, filename, username, password):
    boundary = "------WebKitFormBoundary123456"
    auth = f"{username}:{password}".encode()
    auth_base64 = base64.b64encode(auth).decode()

    with open(filename, "rb") as f:
        file_content = f.read()

    content = (
        f"--{boundary}\r\n"
        f'Content-Disposition: form-data; name="file"; filename="{filename}"\r\n'
        f"Content-Type: application/octet-stream\r\n\r\n"
        f"{file_content.decode()}\r\n"
        f"--{boundary}--\r\n"
    )

    request = (
        f"POST {path} HTTP/1.1\r\n"
        f"Host: {host}\r\n"
        f"Authorization: Basic {auth_base64}\r\n"
        f"Content-Type: multipart/form-data; boundary={boundary}\r\n"
        f"Content-Length: {len(content)}\r\n"
        f"Connection: close\r\n\r\n"
        f"{content}"
    )

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

# Upload file (nếu WordPress hỗ trợ)
http_upload(
    "blogtest.vnprogramming.com",
    "/wp-admin/async-upload.php",
    "upload_test.txt",
    "test",
    "test123QWE@AD"
)
