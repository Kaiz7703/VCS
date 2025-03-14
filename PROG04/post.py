def http_post(host, path, data, username, password):
    auth = f"{username}:{password}".encode()
    auth_base64 = base64.b64encode(auth).decode()
    
    request_body = "&".join(f"{k}={v}" for k, v in data.items())
    content_length = len(request_body)

    request = (
        f"POST {path} HTTP/1.1\r\n"
        f"Host: {host}\r\n"
        f"Authorization: Basic {auth_base64}\r\n"
        f"Content-Type: application/x-www-form-urlencoded\r\n"
        f"Content-Length: {content_length}\r\n"
        f"Connection: close\r\n\r\n"
        f"{request_body}"
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

# Login test
http_post(
    "blogtest.vnprogramming.com",
    "/wp-login.php",
    {"log": "test", "pwd": "test123QWE@AD", "wp-submit": "Log In"},
    "test",
    "test123QWE@AD"
)
