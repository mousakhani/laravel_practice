<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
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
        return $this->successResponse(['data' => $collection], $code);
    }

    protected function showOne($model, $code = 200)
    {

        return $this->successResponse(['data' => $model], $code);
    }
}
