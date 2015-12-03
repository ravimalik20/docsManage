<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Extension extends Model
{
    protected $table = 'extensions';

    protected $fillable = ['name'];

    public static function validate($input)
    {
        $rules = [
            "name" => "required|string",
        ];

        return Validator::make($input, $rules);
    }
}
