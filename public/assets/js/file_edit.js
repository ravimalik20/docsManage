$(document).ready( function () {
    // trigger extension
    ace.require("ace/ext/language_tools");

    var language = $("#editor").attr("data-language");

    var editor = ace.edit("editor");
    if (language)
        editor.session.setMode("ace/mode/"+language);
    editor.setTheme("ace/theme/tomorrow");

    // enable autocompletion and snippets
    editor.setOptions({
        enableBasicAutocompletion: true,
        enableSnippets: true,
        enableLiveAutocompletion: false
    });

    $(".edit_file").click(function ()
    {   $("#editor_form").submit();
    });

    $("#editor_form").submit(function ()
    {
        var content = editor.getValue();
        $(this).find("input[name=content]").val(content);
    });
});
