<?php


namespace App\Admin\Traits;


use App\Admin\Models\Permissions;

trait HasNavs
{
    /**
     * 返回用户直接拥有的导航和菜单
     * @return object
     */
    public function navsAndMens(): object
    {
        return $this->BelongsToMany(Permissions::class, 'user_has_permissions', 'user_id', 'permission_id')->where(['parent_id' => 0, 'type' => Permissions::TYPE_MENU])->with('menus');
    }

    /**
     * 返回用户通过角色拥有的导航和菜单
     * @return object
     */
    public function getNavsAndMenusViaRoles(): object
    {
        return $this->loadMissing('roles', 'roles.navs')
            ->roles->flatMap(function ($role) {
                return $role->permissions;
            })->sort()->values();
    }

    /**
     * 返回用户拥有的导航和菜单
     * @return object
     */
    public function getNavsAndMenus(): object
    {
        $navs_menus = $this->navsAndMens;

        $roles_key = $this->roles->map(function ($role) {
            return $role->key;
        })->sort()->values()->toArray();

        if (in_array('developer', $roles_key)) {
            //开发者拥有所有导航和菜单
            $navs_menus = Permissions::where(['parent_id' => 0, 'type' => Permissions::TYPE_MENU])->with('menus')->get();
        } elseif ($this->roles) {
            $navs_menus = $navs_menus->merge($this->getNavsAndMenusViaRoles());
        }

        return $navs_menus->sort()->values();
    }
}