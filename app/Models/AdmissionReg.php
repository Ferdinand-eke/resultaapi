<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionReg extends Model
{
    //
    protected $table = "admission_regs";

    protected $fillable = [
        'automatic_admission',
        'e_exam_required',
        'class_id',
        'max_class_count',
        'application_fee_required',
        'application_fee',
        'application_starts',
        'application_ends',
        'cut_off',
        'brief',
        'strict',
        'admin_id',
        'admission_reg_status',
        'slug',  
    ];

    public function classes(){
        return $this->belongsTo('App\Model\Classes','class_id'); 
    }
}
