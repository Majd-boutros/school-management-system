<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Grade extends Model
{
    use HasTranslations;

    protected $table = "grades";

    protected $fillable = ['name','notes'];

    public $translatable = ['name'];

    protected function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }
}
