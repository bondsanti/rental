<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'description'];

    public static function addLog($user_id, $action, $description)
    {
        self::create([
            'user_id' => $user_id,
            'action' => $action,
            'description' => $description
        ]);
    }
}
