<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Cast\Object_;

trait ApiResponser
{
    private function successResponse($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    protected  function errorResponse($message, $code = 400)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        $collection = $this->filterData($collection);
        $collection = $this->sortData($collection);
        $collection = $this->paginate($collection);
        return $this->successResponse(['data' => $collection->values()], $code);
    }

    protected function showOne($model, $code = 200)
    {
        return $this->successResponse(['data' => $model], $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }


    protected function sortData(Collection $collection)
    {

        // Sorting worked based regional attributes on the models
        if (request()->has('sort_by')) {
            $attribute = request()->sort_by;
            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }

    protected function filterData(Collection $collection)
    {
        foreach (request()->query() as $query => $value) {
            $attributes = $collection->first()->getAttributes();
            if (array_key_exists($query, $attributes)) {
                $collection = $collection->where($query, $value);
            }
        }
        return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 2;
        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator(
            $results,
            $collection->count(),
            $perPage,
            $page,
            [
                'path' => 'sdf',
            ]
        );

        $paginated->appends(request()->all());
        return $paginated;
    }
}
