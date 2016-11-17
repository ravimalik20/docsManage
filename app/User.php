<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;
use Auth, Session;
use App\Models\Folder,App\Models\File, App\Models\DocumentPermission, App\Models\History, App\Models\UserManage;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract,
                                    BillableContract
{
    use Authenticatable, Authorizable, CanResetPassword, Billable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    const TYPE_ADMIN = "admin";

    const TYPE_ADMIN_CLIENT = "admin_client";

    const TYPE_CLIENT = "client";

    const TYPE_CLIENT_CLIENT = "client_client";

    public static function lists()
    {
      return User::where("id","!=",Auth::user()->id)->get();
    }

    public static function documents($user,$folderID)
    {
        $data = [];
        $folder = Folder::find($folderID);

        if ($folder) {
            return self::folderDocuments($user,$folder);
        }

        return self::rootDocuments($user);
    }

    public static function rootDocuments($user)
    {
        $data = [];
        $folders = Folder::rootFolders($user);

        if (count($folders) > 0)
            $data["folders"] = $folders;

        $files = File::rootFiles($user);

        if (count($files) > 0)
            $data["files"] = $files;

        return $data;
    }

    public static function folderDocuments($user,$folder)
    {
        $data = [];
        $folders = $folder->folders($user);

        if (count($folders) > 0)
            $data["folders"] = $folders;

        $files = $folder->files($user);

        if (count($files) > 0)
            $data["files"] = $files;

        return $data;
    }

    public static function sharedFiles($user)
    {
        $sharedFileIds = self::sharedFilesIds($user);
        $files = File::whereIn("id",$sharedFileIds)
          ->orderBy("name")
          ->get();

        return $files;
    }

    public static function sharedFilesIds($user)
    {
        $ids = [];
        $sharedFolderIds = DocumentPermission::select("files.id")
                  ->join("users","users.id","=","document_permission.user_id")
                  ->join("files","document_permission.document_id","=","files.id")
                  ->where("document_permission.user_id",Auth::user()->id)
                  ->where("type","file")
                  ->where("files.created_by","!=",Auth::user()->id)
                  ->where("files.created_by",$user->id)
                  ->distinct()
                  ->get();

        if(count($sharedFolderIds)>0){
            $sharedFolderIds = $sharedFolderIds->toArray();

            foreach ($sharedFolderIds as $id) {
                array_push($ids,$id["id"]);
            }
        }

        return $ids;
    }

    public static function sharedUserLists()
    {
        $sharedFolderIds = self::sharedUserIds();

        return User::whereIn("id",$sharedFolderIds)->get();
    }

    public static function sharedUserIds()
    {
        $ids = [];
        $sharedFolderIds = DocumentPermission::select("files.created_by")
                  ->join("users","users.id","=","document_permission.user_id")
                  ->join("files","document_permission.document_id","=","files.id")
                  ->where("document_permission.user_id",Auth::user()->id)
                  ->where("files.created_by","!=",Auth::user()->id)
                  ->where("type","file")
                  ->distinct()
                  ->get();

        if (count($sharedFolderIds) > 0) {
            $sharedFolderIds = $sharedFolderIds->toArray();

            foreach ($sharedFolderIds as $id) {
                array_push($ids,$id["created_by"]);
            }
        }

      $manageUsers = UserManage::where('user_id',Auth::user()->id)->get();
      if(count($manageUsers) > 0 ){
        foreach($manageUsers as $manageUser){
          if(!in_array($manageUser->manage_user_id,$ids)){
            array_push($ids, $manageUser->manage_user_id);
          }
        }

      }
        return $ids;
    }

    public function history()
    {
        return History::where("user_id",$this->id)->get();
    }

    public static function nonAdminUsers()
    {
        $users = User::where("role",'!=','admin')
              ->orWhereNull('role')
              ->get();

        return $users;
    }

    public function renderFolderStructureTable()
    {
        $folders = Folder::where("user_id", $this->id)
            ->where("parent", NULL)
            ->get();

        $html = $this->generateTree($folders, $this, true);

        return $html;
    }

    public function generateTree($folders, $user, $first=false)
    {
        $html = "";

        if (isset($folders) && count($folders) > 0) {

            $html = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

            foreach ($folders as $folder) {
                $html .= view('user.includes.table_folder', compact('folder'));

                $child_folders = Folder::where("user_id", $user->id)
                    ->where("parent", $folder->id)
                    ->get();

                if (count($child_folders) > 0)
                    $html .= $this->generateTree($child_folders, $user);

                $child_files = File::where("folder_id", $folder->id)
                    ->where("created_by", $user->id)
                    ->get();
                if (count($child_files) > 0) {
                    $html .= '<table class="table"><tr>
					<th>File Name</th><th>Description</th><th>Type</th><th>Tax Year</th><th>Actions</th><th></th><th></th><th></th><th></th>
					</tr><tbody>';

                    foreach ($child_files as $file) {
                        $html .= view('user.includes.table_file', compact('file'));
                    }

                    $html .= "</tbody></table>";
                }

                $html .= "</div></div></div>";
            }

            $html .= "</div>";

        }

        if ($first == true) {
            $files = File::where("folder_id", NULL)
                ->where("created_by", $user->id)
                ->get();

            if (count($files) > 0) {
                $html .= '<div class="col-lg-12">';

                $html .= '<table class="table"><tr>
					<th>File Name</th><th>Description</th><th>Type</th><th>Tax Year</th><th>Actions</th><th></th><th></th><th></th><th></th>
					</tr><tbody>';

                foreach ($files as $file) {
                    $html .= view('user.includes.table_file', compact('file'));
                }

                $html .= "</tbody></table>";

                $html .= '</div>';
            }
        }

        return $html;
    }

    public static function users()
    {
        return User::where("role",'!=','admin')->get();
    }

    public function getNameAttribute($val)
    {
        return htmlspecialchars($val);
    }

    public static function authUserType($client_id = null)
    {
        $user = \Auth::user();

        $type = "";

        if (\Session::has("selected_user") && $user->id != \Session::get("selected_user")) {
            $type = self::TYPE_ADMIN_CLIENT;
        }
        else if ($user->role == "admin") {
            $type = self::TYPE_ADMIN;
        }
        else if ($client_id) /* Check for client managing other client */ {
            $type = self::TYPE_CLIENT_CLIENT;
        }
        else if ($user->role == null) {
            $type = self::TYPE_CLIENT;
        }

        return $type;
    }

    public static function paymentRequests(){
      return User::where('amount_due', '!=', '')->get();
    }
}
