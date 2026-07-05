<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hospital extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_clinic' => 'boolean',
        'is_jhd_supported' => 'boolean',
        'is_24_hours' => 'boolean',
        'supports_grab' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(HospitalImage::class)->orderBy('sort_order');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(HospitalBookmark::class);
    }

    public function specialties(): BelongsToMany
    {
        return $this->belongsToMany(Specialty::class, 'hospital_specialty');
    }

    public function isBookmarkedBy($user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }

    public function guideTips(): string
    {
        $locale = app()->getLocale();

        if ($locale === 'en' && $this->guide_tips_en) {
            return $this->guide_tips_en;
        }

        return $this->guide_tips_ja ?? '';
    }

    public function googleMapsUrl(): ?string
    {
        if ($this->lat === null || $this->lng === null) {
            return null;
        }

        return 'https://www.google.com/maps/search/?api=1&query='
            . urlencode("{$this->lat},{$this->lng}");
    }

    public function googleMapsDirectionsUrl(): ?string
    {
        if (! $this->supports_grab || $this->lat === null || $this->lng === null) {
            return null;
        }

        return 'https://www.google.com/maps/dir/?api=1&destination='
            . urlencode("{$this->lat},{$this->lng}");
    }
}
