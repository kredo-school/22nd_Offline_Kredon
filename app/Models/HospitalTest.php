<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalTest extends Model
{
    protected $table = 'hospitals_test';

    /* 目的： mass asignment(一括で代入)を許可 */
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(Hospital::class, 'hospital_id');
    }
}
