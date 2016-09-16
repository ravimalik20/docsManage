$(document).ready(function () {
    $(".user_select").change(function () {
        var user_id = $(this).val();

        $.get("/user/"+user_id+"/select", {}, function (response) {
            if (response.status == "success") {
                location.href="/";
            }
        });
    });

    $("body").on("click", ".form_submit_link", function () {
        if ($(this).attr("data-confirm") == "true")
            if (confirm("Are you sure?") == false)
                return false;

        $(this).closest("form").submit();
    });
});
