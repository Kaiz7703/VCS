import requests
import argparse
from urllib.parse import urljoin

# Thiết lập đối số dòng lệnh
parser = argparse.ArgumentParser()
parser.add_argument("--url", required=True, help="URL trang đăng nhập WordPress")
parser.add_argument("--user", required=True, help="Tên đăng nhập")
parser.add_argument("--password", required=True, help="Mật khẩu")
args = parser.parse_args()

# URL đăng nhập và URL gốc
login_url = args.url
base_url = "/".join(login_url.split("/")[:3])  # Lấy `http://localhost`

# Dữ liệu đăng nhập
data = {
    "log": args.user,
    "pwd": args.password,
    "wp-submit": "Log In",
    "redirect_to": "/wp-admin/"
}

# Gửi request đăng nhập
session = requests.Session()
response = session.post(login_url, data=data, allow_redirects=False)

# Xử lý phản hồi
if "Location" in response.headers:
    redirect_url = response.headers["Location"]

    # Xử lý URL chuyển hướng
    if redirect_url == "/wp-admin/":
        redirect_url = urljoin(login_url, "/wordpress/wp-admin/")
    elif redirect_url.startswith("/"):
        redirect_url = urljoin(login_url, redirect_url)

    print(f"Redirecting to: {redirect_url}")

    # Kiểm tra nếu đã đăng nhập thành công
    if "/wp-admin/" in redirect_url:
        print("Đăng nhập thành công!")
    else:
        print("Đăng nhập thất bại!")
else:
    print("Không có redirect, có thể đăng nhập không thành công!")
