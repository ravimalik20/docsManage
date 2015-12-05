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

        var info_ref = $("#info_div");
        if (info_ref)
        {   var folder_id = info_ref.attr("data-folder-id");
            if (folder_id)
                data["folder_id"] = folder_id;
        }

        $.post("/folder", data, function (val)
        {   if (val.status == "success")
                location.reload();
        });
    });

    $(".delete_file_folder").click(function ()
    {
        var folders = [];
        var files = [];

        var token = $(this).attr("data-token");

        $("input[name=folders]:checked").each(function ()
        {   folders.push($(this).val());
        });

        $("input[name=files]:checked").each(function ()
        {   files.push($(this).val());
        });

        var data = {
            "folders": folders,
            "files": files,
            "_method": "DELETE",
            "_token": token,
            "_ajax": "true"
        };

        $.post("/folder", data, function (val)
        {   if (val.status == "success")
                location.reload();
        });
    });

    Dropzone.autoDiscover = false;

    var token = $("#file_upload_form").attr("data-token");

    var myDropzone = new Dropzone("#file_upload_form", {
        maxFilesize: 20,
        sending: function(file, xhr, formData) {
            formData.append("_token", token);
        }
    });

    $(".files_modal_close").click(function ()
    {   location.reload();
    });

});
