<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaqCategory extends Model
{
    protected $fillable = ['name', 'slug', 'icon_class', 'sort_order'];

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class, 'faq_category_id');
    }
}
