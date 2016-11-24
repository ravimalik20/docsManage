<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FileTag;
class Tag extends Model
{
    protected $table = 'tags';
    protected $guarded = array();

    public static function store($request)
    {

    }

    public static function findTag($request)
    {
      $tags = [];
      FileTag::where('file_id', $request->file_id)->delete();
      foreach($request->tag as $tag) {
        $table = Tag::firstOrNew(array('name' => $tag));
        $table->name = $tag;
        $table->save();
        $tags[$tag] = $table->id;
      }
      return $tags;
    }
}
