<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    use FilterTrait;

    protected $guarded = [];
    protected $table = 'products';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function AttributeProducts(): HasMany
    {
        return $this->hasMany(AttributeProduct::class, 'product_id');
    }

    public function scopeFilter(Builder $query, $filter = [])
    {
        
        $filter = $filter ?: request()->all();
        $filter = collect($filter);
        // dd($filter);
        
        $query->filterStrColumn($filter, 'title');



        return $query;
    }

}
