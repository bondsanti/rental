<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_Images extends Model
{
    use HasFactory;
    // protected $fillable = ['rid','img_path','img_category'];
    // protected $connection = 'mysql_report';
	protected $table = 'room_images';
	public $timestamps = false;


}
