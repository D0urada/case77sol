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

    // Define timestamp fields if you need custom names
	const CREATED_AT = 'created_at';

	/**
	 * Create a new factory instance for the model.
	 */
	protected static function newFactory()
	{
		return ClientFactory::new();
	}
}
