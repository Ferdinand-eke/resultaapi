<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegForm extends Model
{
    //
    protected $table = "reg_forms";

    protected $fillable = [
        'cand_fname',
        'cand_lname',
        'cand_age', 
        'guardian', 
        'guardian_rel', 
        'class', 
        'photo', 
        'admission_id', 
        'payment_status', 
        'can_examscore',
        'reg_status', 
        'slug',  
    ];

    public function adreg()
    {
        return $this->belongsTo('App\Modells\AdReg', 'admission_id');
    }


}
