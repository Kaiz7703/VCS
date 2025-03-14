import requests
import argparse
from urllib.parse import urljoin

parser = argparse.ArgumentParser()
parser.add_argument("--url", required=True, help="URL trang đăng nhập WordPress")
parser.add_argument("--user", required=True, help="Tên đăng nhập")
parser.add_argument("--password", required=True, help="Mật khẩu")
args = parser.parse_args()

login_url = args.url
base_url = "/".join(login_url.split("/")[:3])  # Lấy `http://localhost`

data = {
    "log": args.user,
    "pwd": args.password,
    "wp-submit": "Log In",
    "redirect_to": "/wp-admin/"
}

session = requests.Session()
response = session.post(login_url, data=data, allow_redirects=False)

from urllib.parse import urljoin

from urllib.parse import urljoin

if "Location" in response.headers:
    redirect_url = response.headers["Location"]
    
    # Nếu redirect_url bị sai (chỉ có /wp-admin/)
    if redirect_url == "/wp-admin/":
        redirect_url = "http://localhost/wordpress/wp-admin/"
    
    # Hoặc tự động nối URL đúng
    elif redirect_url.startswith("/"):
        redirect_url = urljoin(login_url, redirect_url)
    
    print(f"🔄 Redirecting to: {redirect_url}")
else:
    print("❌ Không có redirect!")
