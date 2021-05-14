<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class My_Parent extends Model
{
    use HasTranslations;

    protected $table = 'my_parents';
    protected $fillable = ['email','password','father_name','father_national_id','father_phone',
        'father_job','father_address','nationality_father_id','blood_type_father','religion_father',
        'mother_name','mother_national_id','mother_phone','mother_job','mother_address','nationality_mother_id',
        'blood_type_mother','religion_mother'
    ];
    public $translatable = ['father_name','father_job','mother_name','mother_job'];
    protected $hidden = ['created_at','updated_at'];
    public $timestamps = true;

    protected function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    public function attachments(){
        return $this->hasMany('App\Models\ParentAttachment','parent_id','id');
    }
}
