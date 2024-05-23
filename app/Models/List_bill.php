<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class List_bill extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'list_bills';
}
