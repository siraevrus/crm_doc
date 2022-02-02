<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDocument extends Model
{
    use HasFactory;

    protected $table = 'client_documents';

    protected $fillable = ['client_id', 'name', 'file', 'signed', 'type'];

    protected $casts = [
        'name' => 'string',
        'client_id' => 'integer',
        'file' => 'string',
        'signed' => 'boolean',
        'type' => 'string'
    ];
}
