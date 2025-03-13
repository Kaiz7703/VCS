#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <shadow.h>
#include <crypt.h>

#define MAX_PASSWORD_LEN 128
#define SALT_LEN 16

// Hàm tạo salt ngẫu nhiên
void generate_salt(char *salt, int size) {
    const char charset[] = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    snprintf(salt, size, "$6$"); // Sử dụng SHA-512
    for (int i = 3; i < size - 1; i++) {
        salt[i] = charset[rand() % (sizeof(charset) - 1)];
    }
    salt[size - 1] = '\0';
}

void change_password(const char *username) {
    struct spwd *sp = getspnam(username);
    if (sp == NULL) {
        perror("Lỗi lấy thông tin mật khẩu");
        return;
    }

    char old_password[MAX_PASSWORD_LEN], new_password[MAX_PASSWORD_LEN], confirm_password[MAX_PASSWORD_LEN];

    printf("Nhập mật khẩu cũ: ");
    fgets(old_password, MAX_PASSWORD_LEN, stdin);
    old_password[strcspn(old_password, "\n")] = '\0';
    
    // Kiểm tra mật khẩu cũ
    char *encrypted_old = crypt(old_password, sp->sp_pwdp);
    if (strcmp(encrypted_old, sp->sp_pwdp) != 0) {
        printf("Sai mật khẩu.\n");
        return;
    }

    printf("Nhập mật khẩu mới: ");
    fgets(new_password, MAX_PASSWORD_LEN, stdin);
    new_password[strcspn(new_password, "\n")] = '\0';

    printf("Nhập lại mật khẩu mới: ");
    fgets(confirm_password, MAX_PASSWORD_LEN, stdin);
    confirm_password[strcspn(confirm_password, "\n")] = '\0';

    if (strcmp(new_password, confirm_password) != 0) {
        printf("Mật khẩu không khớp!\n");
        return;
    }

    // Tạo salt ngẫu nhiên
    char salt[SALT_LEN];
    generate_salt(salt, SALT_LEN);

    // Mã hóa mật khẩu mới
    char *encrypted_new = crypt(new_password, salt);

    // Cập nhật vào file /etc/shadow
    FILE *shadow = fopen("/etc/shadow", "r+");
    if (shadow == NULL) {
        perror("Không thể mở /etc/shadow");
        return;
    }

    FILE *temp = fopen("/tmp/shadow.tmp", "w");
    if (temp == NULL) {
        perror("Không thể tạo file tạm");
        fclose(shadow);
        return;
    }

    char line[512];
    while (fgets(line, sizeof(line), shadow)) {
        if (strncmp(line, username, strlen(username)) == 0 && line[strlen(username)] == ':') {
            fprintf(temp, "%s:%s:0:0:99999:7:::\n", username, encrypted_new); // Chỉ ghi một lần mật khẩu mới
        } else {
            fprintf(temp, "%s", line);
        }
    }

    fclose(shadow);
    fclose(temp);

    // Ghi đè file /etc/shadow
    if (rename("/tmp/shadow.tmp", "/etc/shadow") != 0) {
        perror("Không thể cập nhật mật khẩu");
    } else {
        printf("Mật khẩu đã thay đổi thành công.\n");
    }
}

int main() {
    if (getuid() != 0) {
        printf("Chương trình này phải chạy với quyền root.\n");
        return 1;
    }

    char username[256];
    printf("Nhập username: ");
    scanf("%255s", username);
    getchar();

    change_password(username);
    return 0;
}
