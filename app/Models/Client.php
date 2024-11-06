<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

	// protected $table = 'clients';

	protected $fillable = [
        'cpfcnpj',
        'name',
        'email',
        'phone',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

}
