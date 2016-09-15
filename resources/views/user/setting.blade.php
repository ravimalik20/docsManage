<div class="row folders_area">
        <div class="row email folder">
            <h3>Email Setting</h3>
            <form action="/setting" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
              <div>
                <input type="checkbox" name="emailsettings[]" value="file_upload" <?php
                  if(count($settings) > 0 && in_array("file_upload",$settings)){
                    echo  "checked";
                  }
                ?>
                > File Upload
                <input type="checkbox" name="emailsettings[]" value="file_delete" <?php
                  if(count($settings) > 0 && in_array("file_delete",$settings)){
                    echo  "checked";
                  }
                ?>> File Delete
              </div>
              <br></br>
              <div><button type="submit" class="btn btn-primary">Confirm</button></div>
          </form>
        </div>
</div>
