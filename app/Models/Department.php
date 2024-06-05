<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $connection = 'mysql_user';
    protected $table = 'tb_department';

    // public function department()
    // {
    //     return $this->belongsTo(User::class, 'id', 'department_id');
    // }
}
