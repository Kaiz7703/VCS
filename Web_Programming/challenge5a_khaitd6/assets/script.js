document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript Loaded!");

    // Ví dụ: Hiển thị cảnh báo khi gửi tin nhắn
    let messageForm = document.querySelector("form[action*='message.php']");
    if (messageForm) {
        messageForm.addEventListener("submit", function (e) {
            let messageContent = document.querySelector("textarea[name='content']").value;
            if (messageContent.trim() === "") {
                e.preventDefault();
                alert("Nội dung tin nhắn không được để trống!");
            }
        });
    }
});
