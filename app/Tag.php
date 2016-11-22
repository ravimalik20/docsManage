<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
      foreach($request->tag as $tag) {
        $table = Tag::firstOrNew(array('name' => $tag));
        $table->name = $tag;
        $table->save();
        $tags[$tag] = $table->id;
      }
      return $tags;
    }
}
