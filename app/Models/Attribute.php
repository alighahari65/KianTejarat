<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'attributes';

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function AttributeProducts()
    {
        return $this->hasMany(AttributeProduct::class, 'attribute_id');
    }
}
