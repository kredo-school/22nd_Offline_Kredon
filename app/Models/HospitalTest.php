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
        return $this->hasMany(HospitalImage::class, 'hospital_id');
    }
    // 営業中かを判定するメソッド
    public function isCurrentlyOpen()
    {
        // もし open_at が 00:00:00 なら24時間営業とみなす等のルール
        if ($this->open_at === '00:00:00' && $this->close_at === '00:00:00') {
            return true;
        }

        // それ以外の場合は、現在時間を比較する
        $now = now()->format('H:i:s');
        return $this->open_at <= $now && $this->close_at >= $now;
    } 
}
