<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease_auto_code extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'lease_auto_code';
}
