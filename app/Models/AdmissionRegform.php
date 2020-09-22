<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionRegform extends Model
{
    //
    protected $table = "admission_regforms";

    protected $fillable = [
        'admission_id',
        'regform_id', 
        'slug',  
    ];

}
