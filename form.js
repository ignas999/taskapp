$(document).ready(function () {

    // Function to handle AJAX form submission
    function submitForm(url, formData) {
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            datatype: "json"
        }).done(function (data) {
            if (data.status === 'error') {
                displayErrors(data.messages);
            } else {
                $("#errorDiv").empty();
            }
        });
    }

    // Function to display error messages
    function displayErrors(messages) {
        $("#errorDiv").empty();
        messages.forEach(function (message) {
            $("#errorDiv").append('<div class="alert alert-warning">' + message + '</div>');
        });
    }

    // Function to reload content after form submission
    function reloadContent() {
        $.ajax({
            type: "GET",
            url: "search.php",
        }).done(function (response) {
            $("#commentSection").html(response); // Update comment section
        });
    }

    // Handle main form submission
    $("form").submit(function (event) {
        event.preventDefault();

        $("#errorDiv").empty();

        var formData = {
            name: $("#name").val(),
            email: $("#email").val(),
            content: $("#content").val(),
        };

        submitForm("c_submit.php", formData);
        reloadContent();
        reloadContent();
    });

    // Handle reply button click
    $(document).on("click", ".reply-btn", function () {
        $(".miniForm").remove();

        var commentId = $(this).data("commentid");

        var formHtml = `
            <div class="d-flex .flex-column container-md justify-content-center mb-2">
                <form class="miniForm p-4 border rounded bg-light" action="c_submit.php" method="POST">
                    <input type="hidden" id="parent_id" name="parent_id" value="${commentId}">
                    <div class="form-group d-flex">
                        <div class="p-2">
                            <label class="form-label font-weight-bold">* Email</label>
                            <input type="text" class="form-control" id="repl_email" name="repl_email" required>
                        </div>
                        <div class="p-2">
                            <label class="form-label font-weight-bold">* Name</label>
                            <input type="text" class="form-control" id="repl_name" name="repl_name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label font-weight-bold">* Content</label>
                        <textarea class="form-control" id="repl_content" name="repl_content" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-info mt-3">Submit</button>
                </form>
            </div>
        `;

        $(this).closest('.media-body').after(formHtml);
    });

    // Handle submission of reply form
    $(document).on("submit", ".miniForm", function (event) {
        event.preventDefault();

        $("#errorDiv").empty();

        var formData = {
            name: $("#repl_name").val(),
            email: $("#repl_email").val(),
            content: $("#repl_content").val(),
            parent_id: $("#parent_id").val(),
        };

        submitForm("c_submit.php", formData);
        reloadContent();
        reloadContent();
    });

});
