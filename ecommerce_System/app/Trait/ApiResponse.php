<?php

namespace App\Trait;

use Illuminate\Http\JsonResponse;
use Throwable;

trait ApiResponse
{
    public static function response($data, $message, $code = 200, $meta = null): JsonResponse
    {
        $response = ['message' => $message, 'status' => $code];
        if ($meta) {
            $response = array_merge(['meta' => $meta], $response);
        }
        $response = array_merge(['data' => $data], $response);
        return response()->json($response, $code);
    }
    protected function SuccessOne($data, $resource, $message = 'Success', $code = 200, $Additional = null): JsonResponse
    {
        if ($resource) {
            $data = $Additional ? new $resource($data, $Additional) : new $resource($data);
        }
        return $this->response($data, $message, $code);
    }
    protected function SuccessMany($data, $resource, $message = 'Success', $code = 200): JsonResponse
    {
        $paginationMeta = $this->getPaginationMeta($data);
        $response = $resource::collection($data);
        return static::response($response, $message, $code, $paginationMeta);
    }

    protected function getPaginationMeta($paginator): array
    {
        return [
            'per_page' => $paginator->perPage(),
            'count' => $paginator->count(),
            'current_page' => $paginator->currentPage(),
            'path' => $paginator->path(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'prev' => $paginator->previousPageUrl(),
            'next' => $paginator->nextPageUrl(),
        ];
    }
    public static function Error(Throwable $th, $code = 500): JsonResponse
    {
        // Cast the exception code to an integer if it's numeric
        $exceptionCode = $th->getCode();
        if ($exceptionCode != 0 && is_numeric($exceptionCode)) {
            $code = (int) $exceptionCode;
        } else {
            $code = 500; // Default to 500 if the code is invalid
        }

        $response = [
            'error' => true,
            'message' => $th->getMessage(),
        ];

        return response()->json($response, $code);
    }
}
