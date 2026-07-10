<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class NotificationSubscription extends Model
{
    use HasFactory;

    protected $table = 'notif_subscriptions';

    protected $fillable = [
        'user_id',
        'subscribable_type',
        'subscribable_id',
        'category',
        'notify_on',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // --- Relations ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

   
    // 対象 (Spot, Market, Item など) への polymorphic relation
    public function subscribable(): MorphTo
    {
        return $this->morphTo();
    }

    // --- Scopes ---

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNotifyOn($query, string $event)
    {
        return $query->where('notify_on', $event);
    }
}