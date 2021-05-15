<?php


namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    public $table = 'permissions';
    public $primaryKey = 'id';
    public $guarded = ['_token'];

    const TYPE_MENU = 1;
    const TYPE_BTN  = 2;
    public static $typeMap = [
        self::TYPE_MENU => '菜单',
        self::TYPE_BTN  => '按钮'
    ];

    public function menus(): object
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->where('parent_id', '!=', 0)->where('type', Permissions::TYPE_MENU);
    }

    public function children(): object
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('type', '!=', self::TYPE_BTN)->with('children', 'btn');
    }

    public function btn(): object
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('type', self::TYPE_BTN);
    }

    public function parent(): object
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }
}