<?php

namespace App\Order\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $connection = 'today_service';
    public $table      = 'order';
    public $primaryKey = 'id';
    public $guarded    = ['_token'];

}
