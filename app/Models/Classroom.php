<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Classroom extends Model
{
    use HasTranslations;
    protected $table = 'classrooms';
    protected $fillable = ['name_class','grade_id'];
    protected $hidden = ['created_at','updated_at'];
    public $translatable = ['name_class'];
    public $timestamps = true;

    protected function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    public function grade(){
        return $this->belongsTo('App\Models\Grade','grade_id','id');
    }


}
