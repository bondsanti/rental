<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportInOut extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'reportinout';
}
