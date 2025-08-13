<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'User',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Budi Santoso'),
        new OA\Property(property: 'email', type: 'string', example: 'budi@perusahaan.com'),
        new OA\Property(property: 'phone_number', type: 'string', example: '08123456789'),
        new OA\Property(property: 'is_active', type: 'boolean', example: true),
        new OA\Property(property: 'department', type: 'string', example: 'IT'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time')
    ]
)]
class UserManagement extends Model
{
    use HasFactory;
    protected $table = 'users_management';
    
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'is_active',
        'department'
    ];
    
    protected $casts = [
        'is_active' => 'boolean'
    ];
}
