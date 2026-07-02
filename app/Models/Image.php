<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    protected $table = 'images';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'url',
        'caption',
        'imageable_id',
        'imageable_type',
        'sort_order',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
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

            // Legacy: public/images/hospital/ or storage/app/public/hospital/
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
