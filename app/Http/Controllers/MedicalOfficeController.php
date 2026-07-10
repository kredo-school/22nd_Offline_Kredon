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
            'next_doctor_visit' => $this->getNextDoctorVisitLabel(),
        ];
    }

    /**
     * @return array<int, array{start: string, end: string, time: string}>
     */
    private function doctorVisitSchedule(): array
    {
        $timeMwf = __('healthcare.medical_office.doctor_visit_time_mwf');
        $timeTt = __('healthcare.medical_office.doctor_visit_time_tt');

        return [
            Carbon::MONDAY => ['start' => '13:00', 'end' => '17:00', 'time' => $timeMwf],
            Carbon::TUESDAY => ['start' => '10:00', 'end' => '12:00', 'time' => $timeTt],
            Carbon::WEDNESDAY => ['start' => '13:00', 'end' => '17:00', 'time' => $timeMwf],
            Carbon::THURSDAY => ['start' => '10:00', 'end' => '12:00', 'time' => $timeTt],
            Carbon::FRIDAY => ['start' => '13:00', 'end' => '17:00', 'time' => $timeMwf],
        ];
    }

    public function getNextDoctorVisitLabel(): string
    {
        $now = Carbon::now('Asia/Manila');
        $schedule = $this->doctorVisitSchedule();
        $currentTime = $now->format('H:i');

        for ($daysAhead = 0; $daysAhead < 7; $daysAhead++) {
            $date = $now->copy()->addDays($daysAhead);
            $day = $date->dayOfWeek;

            if (! isset($schedule[$day])) {
                continue;
            }

            $slot = $schedule[$day];

            if ($daysAhead === 0 && $currentTime > $slot['end']) {
                continue;
            }

            $time = $slot['time'];

            if ($daysAhead === 0) {
                return __('healthcare.medical_office.next_visit_today', ['time' => $time]);
            }

            if ($daysAhead === 1) {
                return __('healthcare.medical_office.next_visit_tomorrow', ['time' => $time]);
            }

            $weekday = $date->locale(app()->getLocale())->isoFormat('dddd');

            return __('healthcare.medical_office.next_visit_weekday', [
                'weekday' => $weekday,
                'time' => $time,
            ]);
        }

        return __('healthcare.medical_office.no_visit_scheduled');
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
        $schedule = $this->doctorVisitSchedule();

        if ($day === Carbon::SATURDAY || $day === Carbon::SUNDAY) {
            return [
                'type' => 'danger',
                'message' => __('healthcare.medical_office.status.weekend'),
            ];
        }

        if (isset($schedule[$day])) {
            $slot = $schedule[$day];

            if ($time >= $slot['start'] && $time <= $slot['end']) {
                $message = in_array($day, [Carbon::TUESDAY, Carbon::THURSDAY], true)
                    ? __('healthcare.medical_office.status.kotobia_doctor')
                    : __('healthcare.medical_office.status.japanese_doctor');

                return [
                    'type' => in_array($day, [Carbon::TUESDAY, Carbon::THURSDAY], true) ? 'info' : 'success',
                    'message' => $message,
                ];
            }
        }

        return [
            'type' => 'secondary',
            'message' => __('healthcare.medical_office.status.off_hours'),
        ];
    }
}
