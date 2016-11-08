function wrapData(user){
    var viewp = "";
    var deletep = "";
    var print = "";
    var download = "";

    if(typeof(user.sharedFiles)!="undefined"){
      var per = user.sharedFiles.permissions;
      if(per.indexOf(1) > -1 || per.indexOf("1") > -1)
          viewp = "checked";
      if(per.indexOf(2) > -1 || per.indexOf("2") > -1){
          deletep = "checked";
        }
      if(per.indexOf(3) > -1 || per.indexOf("3") > -1){
          print = "checked";
        }
      if(per.indexOf(4) > -1 || per.indexOf("4") > -1){
          download = "checked";
        }
    }

    var html = '<div class="folder col-lg-2 col-sm-2 col-xs-3"><div class="row"><input name="users['+user.id+']" type="hidden" value="2"/><div class="file_icon text-center"><a href="javascript:void(0);"><i class="fa fa-user fa-5x"></i></a></div><div class="file_name text-center"><span>' + user.name + '</span></div><div class="folder_checkbox permission_check"><input type="checkbox" '+viewp+' name="users['+user.id+'][permission][]" value="1" autocomplete="off"> view</div><div class="folder_checkbox permission_check"><input type="checkbox" name="users['+user.id+'][permission][]" value="2" '+deletep+' autocomplete="off"> delete</div><div class="folder_checkbox permission_check"><input type="checkbox" name="users['+user.id+'][permission][]" value="3" '+print+' autocomplete="off"> print</div><div class="folder_checkbox permission_check"><input type="checkbox" name="users['+user.id+'][permission][]" value="4" '+download+' autocomplete="off"> download</div></div></div>';
    return html;
}


$(document).ready(function ()
{
  var folders = [];
  var files = [];
  var url = '/folder/0/file';

  $("input[name=files]").on("ifToggled",function(){
    var selectedFolders = [],selectedFiles = [];
    var parentHtml  = $(this).parent().parent().parent();
    if($(this).is(":checked")){
      parentHtml.find(".permissionbtn").show();
    }else{
      parentHtml.find(".permissionbtn").hide();
    }

  });

  var token = $("#folderAddModal").find("input[name=folder_name]").attr("data-token");
    $(".add_folder").click(function ()
    {
        var admin =  false;
        var user_id = null;
        var name = $("#folderAddModal").find("input[name=folder_name]").val();
        var token = $("#folderAddModal").find("input[name=folder_name]").attr("data-token");
         admin = $("#folderAddModal").find("input[name=admin]").val();
         user_id = $("#folderAddModal").find("input[name=user_id]").val();

        var data = {
            "name"    : name,
            "_ajax"   : "true",
            "_token"  : token,
            "admin"   : admin,
            "user_id" : user_id
        };

        var info_ref = $("#info_div");
        if (info_ref)
        {   var folder_id = info_ref.attr("data-folder-id");
            if (folder_id)
                data["folder_id"] = folder_id;
        }
        console.log(data);

        $.post("/folder", data, function (val)
        {   if (val.status == "success")
              {
                  location.reload();
              }

        });
    });

    $(".delete_file_folder").click(function ()
    {


        var token = $(this).attr("data-token");

        $("input[name=folders]:checked").each(function ()
        {   folders.push($(this).val());
        });

        $("input[name=files]:checked").each(function ()
        {   files.push($(this).val());
        });

        if(!confirm('Are you sure?'))
            return false;

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
        init: function() {
          this.on("processing", function(file) {
            this.options.url = url;
          });
        },
        sending: function(file, xhr, formData) {
            formData.append("_token", token);
            var text = $('textarea[name=description]').val();
            var type = $('input[name=type]').val();
            var requestId = $('input[name=filerequestId]').val();
            formData.append("description", text);
            formData.append('type', type);
            formData.append('filerequestId', requestId);
        }
    });

    $(".files_modal_close").click(function ()
    {   location.reload();
    });

    $(".add_permision_btn").click(function(){
      var selectedFolders = [], selectedFiles = [];
      var docId = $(this).attr("data-id");
      var type = $(this).attr("data-type");
      selectedFolders.push(docId);

      var data = {
          "folders": selectedFolders,
          "files": selectedFiles,
          "_token": token,
          "_ajax": "true"
      };
      $("#document").val(docId);
      $("#document_type").val(type);
      $.post("/document_permissions", data, function (response)
      {
         response = JSON.parse(response);
         if(response.status == "success"){

           $("#addPermissionModal").modal("show");
           var html = '';
           $.each(response.users,function(key,value){

              console.log(value);
              html += wrapData(value);

           });

           $('.add_permission_area').html(html);
         }
      });
    });


    $("input[name=userpermisson]").on('ifChanged',function(event){
      var userids = [];

      $("input[name=userpermisson]:checked").each(function ()
      {
        console.log($(this).val());
        userids.push($(this).val());
      });

      console.log("i am here",userids);
      if(userids.length){
        $('.user-manage-permission').show();
      }else{
        $('.user-manage-permission').hide();
      }
    });

    $('.user-manage-permission').click(function(){
      var userids = [];

      $("input[name=userpermisson]:checked").each(function ()
      {
        console.log($(this).val());
        userids.push($(this).val());
      });


      var data = {
          "ids": userids,
          "_token": token,
          "_ajax": "true"
      };

      $.post("/usermanage", data, function (response)
      {
        if(response.status == 'success'){
          window.location.reload();
        }
      });
    });
    $('.newfilerequestmodal').click(function(){
      console.log('i am here');
        getfolders();
    });
    $('.fileAddModalclick').click(function(){
        getfolders();

    });

    function getfolders () {

      var data = {
          "id": $(".metadata").attr("data-id"),
          "_token": token,
          "_ajax": "true"
      };

      $.post("/getuserfolders", data, function (response)
      {
        console.log('response', response);
        if(response.folders){
          var html = '<option value="">Select folder</option><option value="0">root</option>';
          $.each(response.folders, function(key,value){
            html +='<option value='+value.id+'>'+value.name+'</option>';
          });
          $('.folder-select').html(html);
        }
      });

      $('.folder-select').on('change',function(){
        var selectV = $('.folder-select option:selected').val();
        if( selectV !=''){
            $('.dropzone').removeClass('dz-remove-click');
            url  = '/folder/'+selectV+'/file';
            $('#file_upload_form').attr('action','/folder/'+selectV+'/file');
        }
        else{
          $('.dropzone').addClass('dz-remove-click');
        }
      });
    }
      $('.fileRequestMessageModal').click(function(){
          $('#file_request_id').val($(this).attr('data-id'));
          $('#file_message_receiver').val($(this).attr('data-receiver_id'));
      });

     $('.requestfileupload').click(function(){
        var ref = $(this).closest(".file_request_row");

        var description = ref.find(".description").html();
        var type = ref.find(".type").html();

        $("#fileRequestDesc").val(description);
        $("#fileRequestType").val(type);

        $('#filerequestId').val($(this).attr('data-id'));
        console.log('folder id', $(this).attr('data-folderId'));
        var folderId = $(this).attr('data-folderId');

        setTimeout(function(){
          $('.folder-select option').each(function(){
              if($(this).attr('value') == folderId) {
                $(this).prop('selected', 'selected');
                $('.folder-select').attr("disabled", true);
                url  = '/folder/'+folderId+'/file';
                $('.dropzone').removeClass('dz-remove-click');
              }
          });
      }, 200);


    });

  $('.cancel-file-request').click(function(){
    console.log('cancel file request');
    var _this = $(this);
    var data = {
        "id": $(this).attr('data-id'),
        "_token": token,
        "_ajax": "true"
    };

    $.post("/cancel-file-request", data, function (response)
    {
        if(response.status == 'success'){
            _this.parent().parent().remove();
        }

        if(response.status == 'error') {
            alert('Something went wrong!');
        }
    });

  });


});
