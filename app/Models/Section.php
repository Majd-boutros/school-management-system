<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasTranslations;

    protected $table = 'sections';
    protected $fillable = ['name_section','status','grade_id','class_id'];
    protected $hidden = ['created_at','updated_at'];
    public $translatable = ['name_section'];
    public $timestamps = true;

    public function grade(){
        return $this->belongsTo('App\Models\Grade','grade_id','id');
    }

    public function my_class(){
        return $this->belongsTo('App\Models\Classroom','class_id','id');
    }
}

