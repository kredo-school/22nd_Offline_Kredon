<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\NotificationTemplate;

class NotifSchedule extends Model
{
    protected $table = 'notif_schedules';
    protected $fillable = [
        'template_id',
        'delivery_mode',
        'trigger_event',
        'recurrence_rule',
        'recurrence_day_of_week',
        'recurrence_time',
        'next_run_at',
        'target_type',
        'is_active',
        'created_by',
    ];
    protected $casts = ['is_active' => 'boolean'];

    public function template(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplate::class, 'template_id');
    }
}
