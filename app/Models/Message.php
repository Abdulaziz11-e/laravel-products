<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    public $timestamps = false;
    
     // добавляем это|
     protected $fillable = [
         'message', 'contact' //->аттрибуты массового присваивания.
    ];

}
