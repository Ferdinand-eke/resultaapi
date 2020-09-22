<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    //
    protected $table = "classes";

    protected $fillable = [
        'name',
        'admin_id',
        'slug',  
    ];

    public function admissionRegs(){

        
        return $this->hasMany('App\Model\AdmissionReg', 'id');
    }

}
