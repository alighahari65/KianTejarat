<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

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

    public function scopeFilter(Builder $query, $filter = [])
    {
        
        $filter = $filter ?: request()->all();
        
        $filter = collect($filter);
        
        $query->filterStrColumn($filter, 'title');
        return $query;
    }

}
