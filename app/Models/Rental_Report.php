<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental_Report extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'rental_id';
    protected $table = 'rental_report';
}
