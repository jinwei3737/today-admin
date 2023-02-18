<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table      = 'order';
    public $primaryKey = 'id';
    public $guarded    = ['_token'];

}
