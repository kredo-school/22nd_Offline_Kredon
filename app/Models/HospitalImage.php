<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalImage extends Model
{
    protected $table = 'hospitals_images';

    protected $guarded = [];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }
}
