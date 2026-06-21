<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategoryTest extends Model
{   
    protected $table = 'faq_categories_test'; 

    protected $fillable = ['name', 'slug', 'icon_class'];

    public function faqs()
    {
        return $this->hasMany(FaqTest::class,'faq_category_id');    
    }
}
