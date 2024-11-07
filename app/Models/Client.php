<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ClientFactory;

class Client extends Model
{
    use HasFactory;

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
