<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Faq;

class Faqcategory extends Model
{   
    protected $table = 'faq_categories_test'; 

    protected $fillable = ['name', 'slug', 'icon_class'];

    public function faqs()
    {
        return $this->hasMany(Faq::class,'faq_category_id');    
    }
}
