<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristSpotPhoto extends Model
{
    use HasFactory;

    // 保存を許可するカラム
    protected $fillable = ['tourist_spot_id', 'photo_path'];

    // 親の観光スポットへの逆リレーション（所属）
    public function touristSpot()
    {
        return $this->belongsTo(TouristSpot::class);
    }
}