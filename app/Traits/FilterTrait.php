<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

trait FilterTrait
{
    abstract public function scopeFilter(Builder $query, $filter = []);

    public function scopeFilterStrColumn(Builder $builder, Collection $filter, $name)
    {
        return $builder->when($filter->get($name), function ($query) use ($name, $filter) {

            $query->where($name, 'like', "%{$filter->get($name)}%");
        });
    }
}
