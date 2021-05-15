<?php


namespace App\Admin\Models;


use App\Admin\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasPermissions;

    public $table = 'roles';
    public $primaryKey = 'id';
    public $guarded = ['_token'];

    public function permissions(): object
    {
        return $this->BelongsToMany(Permissions::class, 'role_has_permissions', 'role_id', 'permission_id');
    }

    public function navs(): object
    {
        return $this->BelongsToMany(Permissions::class, 'role_has_permissions', 'role_id', 'permission_id')->where(['parent_id' => 0, 'type' => Permissions::TYPE_MENU])->with('menus');
    }
}