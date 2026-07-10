<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HospitalImage extends Model
{
    public $timestamps = false;

    const UPDATED_AT = null;

    protected $fillable = [
        'hospital_id',
        'user_id',
        'url',
        'caption',
        'sort_order',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function displayCaption(): ?string
    {
        if ($this->caption === null || $this->caption === '') {
            return null;
        }

        if (app()->getLocale() !== 'en') {
            return $this->caption;
        }

        $map = [
            '外観' => 'Exterior',
            '入口' => 'Entrance',
            '内観' => 'Interior',
        ];

        return $map[$this->caption] ?? $this->caption;
    }

    protected function displayUrl(): Attribute
    {
        return Attribute::get(function (): string {
            if (str_starts_with($this->url, 'http://') || str_starts_with($this->url, 'https://')) {
                return $this->url;
            }

            if (str_starts_with($this->url, 'images/')) {
                return asset($this->url);
            }

            if (str_starts_with($this->url, 'hospitals/')) {
                return asset('images/' . $this->url);
            }

            if (str_starts_with($this->url, 'hospital/')) {
                if (file_exists(public_path('images/' . $this->url))) {
                    return asset('images/' . $this->url);
                }

                return asset('storage/' . $this->url);
            }

            return asset('images/' . $this->url);
        });
    }
}
