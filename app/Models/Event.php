<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Chat;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'location',
        'start_date',
        'end_date',
        'image1',
        'image2',
        'organizer_type',
        'display_channel',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // 投稿者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // コメント
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // 参加者
    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_participants')
            ->withTimestamps();
    }

    // グループチャット
    public function chat()
    {
        return $this->hasOne(Chat::class);
    }

    // イベント終了判定（end_date基準に変更）
    public function getExpiredAttribute()
    {
        return now()->gt($this->end_date);
    }

    // 開催中/予定/終了のラベル
    public function getStatusLabelAttribute()
    {
        $today = today();

        if ($today->between($this->start_date, $this->end_date)) {
            return 'Now on';
        }

        if ($this->start_date->gt($today)) {
            // 開催3日前以内なら「Before applications open」
            return $today->diffInDays($this->start_date) <= 3
                ? 'Before applications open'
                : 'Upcoming';
        }

        return 'Ended';
    }

    // Admin/企業が登録したイベントのみ
    public function scopeCompanyEvents($query)
    {
        return $query->where('organizer_type', 'company');
    }

    // Share Info表示対象のみ
    public function scopeForShareInfo($query)
    {
        return $query->where('display_channel', 'share_info');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
