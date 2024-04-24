<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    // protected $connection = 'mysql_report';
	// protected $table = 'rental_room';
	public $timestamps = false;
    protected $fillable = [
        'pid', 'HomeNo', 'RoomNo','Building', 'Floor','RoomType', 'price', 'Size','Location','Stauts_Room',
    ];

    public function project(){
        return $this->belongsTo(Project::class, 'pid');
    }


}
