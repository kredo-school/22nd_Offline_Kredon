<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class MedicalOfficeController extends Controller
{
    public function getMedicalOfficeStatus(): array
    {
        $office = $this->getOfficeBadge();

        return [
            'office' => $office,
            'doctor' => $this->getDoctorStatus(),
            'is_closed' => $office['badge_class'] !== 'bg-success',
        ];
    }

    private function getOfficeBadge(): array
    {
        $now = Carbon::now('Asia/Manila');
        $day = $now->dayOfWeek;
        $time = $now->format('H:i');

        if ($day === Carbon::SATURDAY || $day === Carbon::SUNDAY) {
            return [
                'badge_class' => 'bg-danger',
                'label' => __('healthcare.medical_office.weekend'),
            ];
        }

        if ($time >= '08:00' && $time <= '17:00') {
            return [
                'badge_class' => 'bg-success',
                'label' => __('healthcare.medical_office.open'),
            ];
        }

        return [
            'badge_class' => 'bg-secondary',
            'label' => __('healthcare.medical_office.closed'),
        ];
    }

    private function getDoctorStatus(): array
    {
        $now = Carbon::now('Asia/Manila');

        $day = $now->dayOfWeek;
        $time = $now->format('H:i');

        if ($day === Carbon::SATURDAY || $day === Carbon::SUNDAY) {
            return [
                'type' => 'danger',
                'message' => __('healthcare.medical_office.status.weekend'),
            ];
        }

        if (in_array($day, [Carbon::MONDAY, Carbon::WEDNESDAY, Carbon::FRIDAY])) {
            if ($time >= '13:00' && $time <= '17:00') {
                return [
                    'type' => 'success',
                    'message' => __('healthcare.medical_office.status.japanese_doctor'),
                ];
            }
        }

        if (in_array($day, [Carbon::TUESDAY, Carbon::THURSDAY])) {
            if ($time >= '10:00' && $time <= '12:00') {
                return [
                    'type' => 'info',
                    'message' => __('healthcare.medical_office.status.kotobia_doctor'),
                ];
            }
        }

        return [
            'type' => 'secondary',
            'message' => __('healthcare.medical_office.status.off_hours'),
        ];
    }
}
