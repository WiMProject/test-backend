<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseController extends Controller
{
    protected function successResponse($data = null, string $message = 'Berhasil', int $status = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    protected function errorResponse(string $message = 'Terjadi kesalahan', int $status = 500, $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    protected function handleException(\Exception $e): JsonResponse
    {
        if ($e instanceof ValidationException) {
            return $this->errorResponse('Data tidak valid', 422, $e->errors());
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->errorResponse('Data tidak ditemukan', 404);
        }

        return $this->errorResponse('Terjadi kesalahan pada server', 500);
    }
}