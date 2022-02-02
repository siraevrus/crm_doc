<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class RequestHandler
{
    public function handleCriterions(Builder $baseQuery, array $criterions) : LengthAwarePaginator
    {
        $page = $criterions['page'] ?? 1;
        $perPage = $criterions['per_page'] ?? 10;

        if(isset($criterions['filter']) && count($criterions['filter'])) {
            foreach ($criterions['filter'] as $filter) {
                if(str_contains($filter['field'], '.')) {
                    $chunks = explode('.', $filter['field']);
                    $baseQuery->whereHas($chunks[0], function (Builder $query) use ($filter, $chunks){
                        $query->where($chunks[1], $filter['operator'], $filter['value']);
                    });
                } else {
                    $logicOperator = isset($filter['or']) ? "orWhere" : 'where';
                    $baseQuery->{$logicOperator}($filter['field'], $filter['operator'], $filter['operator'] == 'ilike' ?
                        '%'.$filter['value'].'%' : $filter['value']);
                }
            }
        }
        if(isset($criterions['order'])) {
            $baseQuery->orderBy($criterions['order']['field'], $criterions['order']['direction']);
        } else {
            $baseQuery->orderBy('created_at', 'asc');
        }

        return $baseQuery->paginate($perPage, '*', 'page', $page);
    }
}
