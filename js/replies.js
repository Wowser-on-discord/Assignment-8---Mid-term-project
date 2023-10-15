document.addEventListener("DOMContentLoaded", function () {
    
    var replyButtons = document.querySelectorAll(".reply-button");
    replyButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            var postId = button.getAttribute("data-postid");
            var replyTextarea = document.querySelector("#post-" + postId + " .reply-textarea");

            if (replyTextarea.style.display === "none") {
                replyTextarea.style.display = "block";
            } else {
                replyTextarea.style.display = "none";
            }
        });
    });

    
    var submitReplyButtons = document.querySelectorAll(".submit-reply-button");
    submitReplyButtons.forEach(function (submitReplyButton) {
        submitReplyButton.addEventListener("click", function () {
            var postId = submitReplyButton.getAttribute("data-postid");
            var replyText = document.querySelector("#post-" + postId + " .reply-text").value;

            if (replyText) {
                var formData = new FormData();
                formData.append('postId', postId);
                formData.append('replyText', replyText);

                // Send the reply data to the server using the fetch API
                fetch('replies.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Handle the response from the server 
                    console.log(data);
                    // Clear the reply textarea
                    document.querySelector("#post-" + postId + " .reply-text").value = "";
                })
                .catch(error => {
                    console.error('An error occurred:', error);
                });
            }
        });
    });
});
