$(document).ready(function ()
{
    $(".print_file").click(function ()
    {   window.frames["file_content"].focus();
        window.frames["file_content"].print();
    });
});
