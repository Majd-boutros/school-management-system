<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Grade extends Model
{
    use HasTranslations;

    protected $table = "grades";
    protected $fillable = ['name','notes'];
    protected $hidden = ['created_at','updated_at'];
    public $timestamps = true;

    public $translatable = ['name'];

    protected function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    public function classes(){
        return $this->hasMany('App\Models\Classroom','grade_id','id');
    }

}
