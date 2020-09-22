<?php

namespace App\Modells;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    //
    protected $table = "admissions";

    protected $fillable = [
        'application_starts',
        'application_ends',
        'brief',
        'admin_id',
        'automatic_admission',
        'e_exam_required',
        'class_id',
        'max_class_count',
        'application_fee_required',
        'application_fee',
      
        'cut_off',
  
        'strict',
        'admission_id',
        'admission_reg_status',
        'slug',  
    ];

    public function apllicationSubs(){
        return $this->hasMany('App\Modells\ApplicationSubmissions', 'id');
    }

    public function AsmissionFormFields(){
        return $this->hasMany('App\Modells\AsmissionFormFields', 'id');
    }

    public function fields(){
       // return $this->hasMany('App\Modells\AsmissionFormFields', 'id');
    } 



}
