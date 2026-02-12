<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = ['category_id', 'name', 'description', 'image', 'is_active', 'can_be_combo'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    // المنتج الواحد ليه كذا حجم (Single, Chunky...)
    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }
}
