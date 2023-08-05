$(document).ready(function() {
    $('#login-form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.post('../model/login_model.php', formData, function(response) {
            if (response.trim() === "success") {
                $.post('../model/check_model.php', formData, function(response) {
                    if (response.trim() === "success") {
                        window.location.href = "home_page.html";
                    } else {
                        alert(response); // Show error message
                    }
                });
            } else {
                alert(response); // Show error message
            }
        });
    });
});
