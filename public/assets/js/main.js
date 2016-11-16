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
        if(confirm("Are you sure? you want to delete"))
          $(this).closest("form").submit();
    });

    $('#openaddpaymentamount').click(function(){
      var form = $('#addpaymentamountuser');
      form.attr('action', '/add_payment/' + $(this).attr('data-user'));
    });
});
