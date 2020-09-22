<?php

namespace App\Modells;

use Illuminate\Database\Eloquent\Model;

class ApplicationSubmissions extends Model
{
    //
    protected $table = "application_submissions";

    protected $fillable = [
        'cand_fname',
        'cand_lname',
        'cand_age', 
        'guardian', 
        'guardian_rel', 
        'class', 
        'photo', 
        'payment_status', 
        'can_examscore',
        'reg_status', 
        'admission_id',
        'slug'  
    ];

    public function admission()
    {
        return $this->belongsTo('App\Modells\Admission', 'admission_id');
    }
}
