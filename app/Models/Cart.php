<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

    public $timestamps = false;
    
     // добавляем это|
     protected $fillable = [
         'name', 'price', 'image' //->аттрибуты массового присваивания.
    ];

}
