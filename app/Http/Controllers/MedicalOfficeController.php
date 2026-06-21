<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class MedicalOfficeController extends Controller
{
    /**
     * 医師訪問状況を判定
     */
    public function getDoctorStatus(): array
    {
        $now = Carbon::now('Asia/Manila');

        $day = $now->dayOfWeek;
        $time = $now->format('H:i');

        // ** 土日判定 ** //
        if ($day === Carbon::SATURDAY || $day === Carbon::SUNDAY) {
        
        return [

            'type' => 'danger',
            'message' => '本日医務室はお休みです'
        ];
    }

        // ** 月・水・金 判定  ** /
        if (in_array($day, [Carbon::MONDAY, Carbon::WEDNESDAY, Carbon::FRIDAY])) {

            if ($time >= '13:00' && $time <= '17:00') {

                return [

                    'type'    => 'success',
                    'message' => '日本語対応可能な医師が訪問中です'
                ];
            }
        }

        //** 火・木 **//
        if (in_array($day, [Carbon::TUESDAY, Carbon::THURSDAY])) {

            if ($time >= '10:00' && $time <= '12:00') {

                return [
                    'type' => 'info',
                    'message' => 'ことビアクリニックの医師が訪問中です'
                ];
            }
        }

        // それ以外（平日だが時間外）
         return [

        'type' => 'secondary',
        'message' => '現在、訪問時間外です。'

        ];
    }
}
