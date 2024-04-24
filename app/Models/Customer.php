<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    // protected $connection = 'mysql_report';
	// protected $table = 'rental_customer';
	public $timestamps = false;
}
