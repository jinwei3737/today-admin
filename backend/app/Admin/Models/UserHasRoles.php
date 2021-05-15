<?php


namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class UserHasRoles extends Model
{
    public $table = 'user_has_roles';
    public $primaryKey = 'id';
    public $guarded = ['_token'];

}