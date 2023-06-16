<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeProduct extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'attribute_product';

    public function attributeProductValues(): HasMany
    {
        return $this->hasMany(AttributeProductValue::class);
    }
}
