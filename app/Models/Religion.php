<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Religion extends Model
{
    use HasTranslations;

    protected $table = 'religions';
    protected $fillable = ['name'];
    public $translatable = ['name'];
    protected $hidden = ['created_at','updated_at'];
    public $timestamps = true;

    protected function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }
}






