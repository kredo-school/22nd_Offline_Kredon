<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotPhoto extends Model
{
    use HasFactory;

    // 保存を許可するカラム
    protected $fillable = ['spot_id', 'photo_path'];

    // 親のスポットへの逆リレーション
    public function spot()
    {
        return $this->belongsTo(Spot::class);
    }
}
