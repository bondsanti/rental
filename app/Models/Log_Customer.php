<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_Customer extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'log_customer';
}
