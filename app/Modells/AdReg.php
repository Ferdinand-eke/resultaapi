<?php

namespace App\Modells;

use Illuminate\Database\Eloquent\Model;

class AdReg extends Model
{
    //
    protected $table = "ad_regs";

    protected $fillable = [
        
        'slug',  
    ];

    public function admission(){
        return $this->belongsTo('App\Modells\Admission', 'admission_id');
    }

    public function regforms()
    {
        return $this->hasMany('App\Models\RegForm', 'id');
    }
}
