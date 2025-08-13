<?php

namespace App\Http\Controllers\Api;

use App\Models\UserManagement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'API Manajemen User',
    description: 'API untuk mengelola data user dengan operasi CRUD lengkap'
)]
#[OA\Server(
    url: 'http://localhost:8000',
    description: 'Development Server'
)]
class UserController extends BaseController
{
    #[OA\Get(
        path: '/api/users',
        summary: 'Ambil semua user',
        tags: ['Users'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Data user berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Data user berhasil diambil'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/User')
                        )
                    ]
                )
            )
        ]
    )]
    public function index(): JsonResponse
    {
        try {
            $users = UserManagement::all();
            return $this->successResponse($users, 'Data user berhasil diambil');
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    #[OA\Post(
        path: '/api/users',
        summary: 'Buat user baru',
        tags: ['Users'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'phone_number', 'department'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Budi Santoso'),
                    new OA\Property(property: 'email', type: 'string', example: 'budi@perusahaan.com'),
                    new OA\Property(property: 'phone_number', type: 'string', example: '08123456789'),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                    new OA\Property(property: 'department', type: 'string', example: 'IT')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'User berhasil dibuat',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'User berhasil dibuat'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/User')
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Data tidak valid',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Data tidak valid'),
                        new OA\Property(property: 'errors', type: 'object')
                    ]
                )
            )
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users_management,email',
                'phone_number' => 'required|string|regex:/^[0-9]{10,}$/',
                'is_active' => 'boolean',
                'department' => 'required|string|max:255'
            ], [
                'name.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'phone_number.required' => 'Nomor telepon wajib diisi',
                'phone_number.regex' => 'Nomor telepon harus berupa angka minimal 10 digit',
                'department.required' => 'Departemen wajib diisi'
            ]);

            $user = UserManagement::create($validatedData);
            return $this->successResponse($user, 'User berhasil dibuat', 201);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    #[OA\Get(
        path: '/api/users/{id}',
        summary: 'Ambil user berdasarkan ID',
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Detail user berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Detail user berhasil diambil'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/User')
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Data tidak ditemukan'
            )
        ]
    )]
    public function show(string $id): JsonResponse
    {
        try {
            $user = UserManagement::findOrFail($id);
            return $this->successResponse($user, 'Detail user berhasil diambil');
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    #[OA\Put(
        path: '/api/users/{id}',
        summary: 'Update user',
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Budi Santoso Updated'),
                    new OA\Property(property: 'email', type: 'string', example: 'budi.updated@perusahaan.com'),
                    new OA\Property(property: 'phone_number', type: 'string', example: '08987654321'),
                    new OA\Property(property: 'is_active', type: 'boolean', example: false),
                    new OA\Property(property: 'department', type: 'string', example: 'Marketing')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'User berhasil diupdate',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'User berhasil diupdate'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/User')
                    ]
                )
            )
        ]
    )]
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $user = UserManagement::findOrFail($id);
            
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users_management,email,' . $id,
                'phone_number' => 'sometimes|required|string|regex:/^[0-9]{10,}$/',
                'is_active' => 'sometimes|boolean',
                'department' => 'sometimes|required|string|max:255'
            ], [
                'name.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'phone_number.required' => 'Nomor telepon wajib diisi',
                'phone_number.regex' => 'Nomor telepon harus berupa angka minimal 10 digit',
                'department.required' => 'Departemen wajib diisi'
            ]);

            $user->update($validatedData);
            return $this->successResponse($user->fresh(), 'User berhasil diupdate');
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    #[OA\Delete(
        path: '/api/users/{id}',
        summary: 'Hapus user',
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User berhasil dihapus',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'User berhasil dihapus')
                    ]
                )
            )
        ]
    )]
    public function destroy(string $id): JsonResponse
    {
        try {
            $user = UserManagement::findOrFail($id);
            $user->delete();
            return $this->successResponse(null, 'User berhasil dihapus');
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }
}
