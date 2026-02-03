<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseHelper
{
    /**
     * Give success response.
     *
     * @param mixed|null $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public static function success(mixed $data = null, string $message = 'Berhasil mengambil data', int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ], $code);
    }

    /**
     * Give error response.
     *
     * @param string $message
     * @param int $code
     * @param mixed|null $data
     * @return JsonResponse
     */
    public static function error(string $message = 'Terjadi kesalahan', int $code = Response::HTTP_BAD_REQUEST, mixed $data = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ], $code);
    }

    /**
     * Give unauthorized response.
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'code' => Response::HTTP_FORBIDDEN,
        ], Response::HTTP_FORBIDDEN);
    }

    /**
     * Give not found response.
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function notFound(string $message = 'Data tidak ditemukan'): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'code' => Response::HTTP_NOT_FOUND,
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Give created response.
     *
     * @param mixed|null $data
     * @param string $message
     * @return JsonResponse
     */
    public static function created(mixed $data = null, string $message = 'Data berhasil ditambahkan'): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'code' => Response::HTTP_CREATED,
            'data' => $data,
        ], Response::HTTP_CREATED);
    }

    /**
     * Give validation error response.
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function validationError(mixed $errors, string $message = 'Validasi gagal'): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'errors' => $errors,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
