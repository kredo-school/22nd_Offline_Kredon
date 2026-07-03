<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotificationTemplate extends Model
{
    use HasFactory;

    protected $table = 'notif_templates';

    protected $fillable = [
        'category',
        'title',
        'body',
        'target_type',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // --- Relations ---

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'template_id');
    }

    // --- Scopes ---

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // --- Helpers ---

    /**
     * テンプレートの {{variable}} を実際の値に展開する
     * 例: render(['commenter_name' => '田中', 'post_title' => 'Cebu City Hall'])
     */
    public function render(array $variables): array
    {
        $title = $this->title;
        $body = $this->body;

        foreach ($variables as $key => $value) {
            $title = str_replace('{{' . $key . '}}', $value, $title);
            $body = str_replace('{{' . $key . '}}', $value, $body);
        }

        return ['title' => $title, 'body' => $body];
    }

    public function isManual(): bool
    {
        return $this->type === 'manual';
    }

    public function isAuto(): bool
    {
        return $this->type === 'auto';
    }

    public function isScheduled(): bool
    {
        return $this->type === 'scheduled';
    }
}