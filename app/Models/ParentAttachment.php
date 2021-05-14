<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentAttachment extends Model
{
    protected $table = 'parent_attachments';
    protected $fillable = ['file_name','parent_id'];
    protected $hidden = ['created_at','updated_at'];
    public $timestamps = true;

    protected $casts = [
        'file_name' => 'array',
    ];

    public function myParent(){
        return $this->belongsTo('App\Models\My_Parent','parent_id','id');
    }

}
