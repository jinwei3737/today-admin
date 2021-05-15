<?php


namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class UserHasPermissions extends Model
{
    public $table = 'user_has_permissions';
    public $primaryKey = 'id';
    public $guarded = ['_token'];

}