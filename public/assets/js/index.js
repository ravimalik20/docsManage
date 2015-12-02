$(document).ready(function ()
{
    $(".add_folder").click(function ()
    {
        var name = $("#folderAddModal").find("input[name=folder_name]").val();
        var token = $("#folderAddModal").find("input[name=folder_name]").attr("data-token");

        var data = {
            "name" : name,
            "_ajax" : "true",
            "_token" : token
        };

        $.post("/folder", data, function (val)
        {   if (val.status == "success")
                location.reload();
        });
    });
});
