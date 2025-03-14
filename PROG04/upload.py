import requests
import argparse
import os
from urllib.parse import urljoin
import re

def upload_to_wordpress(url, username, password, file_path):
    # Verify file exists
    if not os.path.exists(file_path):
        print("❌ File not found!")
        return

    # Create session for maintaining cookies
    session = requests.Session()

    # Login to WordPress
    login_url = urljoin(url, 'wp-login.php')
    login_data = {
        'log': username,
        'pwd': password,
        'wp-submit': 'Log In',
        'redirect_to': urljoin(url, 'wp-admin/')
    }

    response = session.post(login_url, data=login_data)
    if 'wordpress_logged_in' not in session.cookies.get_dict():
        print("❌ Login failed!")
        return

    # Get upload nonce
    media_new = session.get(urljoin(url, 'wp-admin/media-new.php'))
    nonce_match = re.search(r'name="_wpnonce" value="([^"]+)"', media_new.text)
    if not nonce_match:
        print("❌ Could not get upload nonce!")
        return

    # Prepare upload
    upload_url = urljoin(url, 'wp-admin/async-upload.php')
    files = {
        'async-upload': (
            os.path.basename(file_path),
            open(file_path, 'rb')
        )
    }
    data = {
        '_wpnonce': nonce_match.group(1),
        'action': 'upload-attachment'
    }

    # Upload file
    try:
        upload_response = session.post(upload_url, files=files, data=data)
        if upload_response.status_code == 200:
            result = upload_response.json()
            if 'data' in result and 'url' in result['data']:
                print(f"✅ Upload successful!\nFile URL: {result['data']['url']}")
            else:
                print("❌ Upload failed - Invalid response format")
        else:
            print(f"❌ Upload failed - Status code: {upload_response.status_code}")
    except Exception as e:
        print(f"❌ Upload failed: {str(e)}")
    finally:
        files['async-upload'][1].close()

def main():
    parser = argparse.ArgumentParser(description='Upload media to WordPress')
    parser.add_argument('--url', required=True, help='WordPress site URL')
    parser.add_argument('--user', required=True, help='WordPress username')
    parser.add_argument('--password', required=True, help='WordPress password')
    parser.add_argument('--local-file', required=True, help='Path to file to upload')
    
    args = parser.parse_args()
    upload_to_wordpress(args.url, args.user, args.password, args.local_file)

if __name__ == "__main__":
    main()