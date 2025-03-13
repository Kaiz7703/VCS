#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <pwd.h>
#include <grp.h>
#include <unistd.h>

void print_user_info(const char *username) {
    struct passwd *pwd = getpwnam(username);
    if (pwd == NULL) {
        printf("User '%s' không tồn tại.\n", username);
        return;
    }

    printf("Thông tin user:\n");
    printf("Username: %s\n", pwd->pw_name);
    printf("UID: %d\n", pwd->pw_uid);
    printf("GID: %d\n", pwd->pw_gid);
    printf("Home Directory: %s\n", pwd->pw_dir);

    struct group *grp;
    int ngroups = 0;
    gid_t *groups;
    
    // Lấy số lượng group
    getgrouplist(username, pwd->pw_gid, NULL, &ngroups);
    
    groups = malloc(ngroups * sizeof(gid_t));
    if (groups == NULL) {
        perror("malloc");
        return;
    }

    // Lấy danh sách group
    if (getgrouplist(username, pwd->pw_gid, groups, &ngroups) == -1) {
        perror("getgrouplist");
        free(groups);
        return;
    }

    printf("Groups: ");
    for (int i = 0; i < ngroups; i++) {
        grp = getgrgid(groups[i]);
        if (grp != NULL) {
            printf("%s ", grp->gr_name);
        }
    }
    printf("\n");

    free(groups);
}

int main() {
    char username[256];

    printf("Nhập username: ");
    scanf("%255s", username);

    print_user_info(username);
    return 0;
}