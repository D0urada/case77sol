<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'client_id',
        'location_uf',
        'installation_type',
        'equipment'
    ];

    protected $casts = [
        'equipment' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
