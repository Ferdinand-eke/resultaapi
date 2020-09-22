<?php

namespace App\Modells;

use Illuminate\Database\Eloquent\Model;

class AsmissionFormFields extends Model
{
    //
    protected $table = "asmission_form_fields";

    protected $fillable = [
        'admission_id',
        'label',
        'type', 
        'option', 
        'key_name',   
    ];

    public function admission()
    {
        return $this->belongsTo('App\Modells\Admission', 'admission_id');
    }

}
