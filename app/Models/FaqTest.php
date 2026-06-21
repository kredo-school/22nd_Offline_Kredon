<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqTest extends Model
{
    protected $table    = 'faqs_test'; 

    protected $fillable = ['faq_category_id', 'question', 'answer'];
    public function category()
    {
        return $this->belongsTo(FaqCategoryTest::class, 'faq_category_id');
    }
}
