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

    $(".delete_file_folder").click(function ()
    {
        var folders = [];
        var token = $(this).attr("data-token");

        $("input[name=folders]:checked").each(function ()
        {   folders.push($(this).val());
        });

        var data = {
            "folders": folders,
            "_method": "DELETE",
            "_token": token,
            "_ajax": "true"
        };

        $.post("/folder", data, function (val)
        {   if (val.status == "success")
                location.reload();
        });

        console.log(folders);
    });
});
