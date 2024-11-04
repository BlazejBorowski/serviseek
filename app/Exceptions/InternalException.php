<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InternalException extends Exception
{
    public function render(Request $request): JsonResponse|Response
    {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => $this->getMessage(),
            ], $this->getCode() ?: 500);
        }

        return response()->view('errors.custom-exception', [
            'message' => $this->getMessage(),
        ], $this->getCode() ?: 500);
    }
}
