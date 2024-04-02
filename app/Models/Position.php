<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $connection = 'mysql_user';
	protected $table = 'tb_position';
    
	public function user_ref()
	{
		return $this->hasMany(User::class, 'position_id','id');
	}

    public function roleUser()
    {
        return $this->hasMany(Role_user::class, 'role_id','id');
    }
}
