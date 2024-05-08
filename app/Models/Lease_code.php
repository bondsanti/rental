<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease_code extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'lease_code_id';
}
