<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'request';
    protected $fillable = [
        'created_on',
        'location',
        'service',
        'status',
        'priority',
        'department',
        'request_by',
        'assigned_to',
    ];

    
}
