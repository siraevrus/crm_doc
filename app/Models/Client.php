<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = ['name'];

    protected $casts = [
        'name' => 'string'
    ];

    public function documents()
    {
        return $this->hasMany(ClientDocument::class);
    }
}
