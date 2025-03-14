import socket

HOST = "localhost"
PORT = 80

username = "test"
password = "test123QWE@AD"

post_data = f"log={username}&pwd={password}&wp-submit=Log+In"

request = f"""POST /wp-login.php HTTP/1.1
Host: {HOST}
Content-Type: application/x-www-form-urlencoded
Content-Length: {len(post_data)}
Connection: close

{post_data}"""

# Kết nối TCP
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((HOST, PORT))
s.sendall(request.replace("\n", "\r\n").encode())

# Nhận phản hồi
response = b""
while True:
    data = s.recv(4096)
    if not data:
        break
    response += data

s.close()

# Kiểm tra đăng nhập thành công hay thất bại
if b"Location: /wp-admin" in response:
    print("Đăng nhập thành công!")
else:
    print("Đăng nhập thất bại!")
