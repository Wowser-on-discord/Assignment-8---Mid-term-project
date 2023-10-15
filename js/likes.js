document.addEventListener("DOMContentLoaded", function () {
    var likeButtons = document.querySelectorAll(".like-button");

    likeButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            var postId = button.getAttribute("data-postid");
            var likesCountElement = document.getElementById("likes-count-" + postId);
            var isLiked = button.textContent === "💙"; 

            // Send an AJAX request to update the likes count
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_likes.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Parse the response as an integer (the updated likes count)
                    var newLikes = parseInt(xhr.responseText);

                    // Update the like count 
                    likesCountElement.textContent = newLikes;

                    // Toggle the like button 
                    button.textContent = isLiked ? '🤍' : '💙';
                }
            };

            xhr.send("postId=" + postId + "&action=" + (isLiked ? 'unlike' : 'like'));
        });
    });
});
