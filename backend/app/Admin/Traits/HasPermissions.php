<?php


namespace App\Admin\Traits;


use App\Admin\Models\Permissions;

trait HasPermissions
{
    /**
     * 返回用户直接拥有的权限
     * @return object
     */
    public function permissions(): object
    {
        return $this->BelongsToMany(Permissions::class, 'user_has_permissions', 'user_id', 'permission_id');
    }

    /**
     * 返回用户通过角色拥有的权限
     * @return object
     */
    public function getPermissionsViaRoles(): object
    {
        return $this->loadMissing('roles', 'roles.permissions')
            ->roles->flatMap(function ($role) {
                return $role->permissions;
            })->sort()->values();
    }

    /**
     * 返回用户拥有的全部权限
     * @return object
     */
    public function getAllPermissions(): object
    {
        $permissions = $this->permissions;

        $roles_key = $this->roles->map(function ($role) {
            return $role->key;
        })->sort()->values()->toArray();

        if (in_array('developer', $roles_key)) {
            //开发者拥有所有权限
            $permissions = Permissions::get();
        } elseif ($this->roles) {
            $permissions = $permissions->merge($this->getPermissionsViaRoles());
        }

        return $permissions->sort()->values();
    }

    /**
     * 查询权限并返回
     *
     * @param $permissions
     * @return mixed
     */
    protected function getStoredPermission($permissions)
    {
        if (is_numeric($permissions)) {
            return Permissions::find($permissions);
        }

        if (is_string($permissions)) {
            return Permissions::where('name', $permissions)->first();
        }

        if (is_array($permissions)) {
            return Permissions::whereIn('id', $permissions)
                ->get();
        }

        return $permissions;
    }

    /**
     * @param ...$permissions
     * @return $this
     */
    public function givePermissionTo(...$permissions)
    {
        try {
            $permissions = collect($permissions)
                ->flatten()
                ->map(function ($permission) {
                    if (empty($permission)) {
                        return false;
                    }

                    return $this->getStoredPermission($permission);
                })
                ->map->id
                ->all();

            $this->permissions()->sync($permissions, false);
        } catch (\Exception $exception) {
            return $this;
        }

        return $this;
    }

    /**
     * 删除所有当前权限，并赋予指定权限
     *
     * @param ...$permissions
     * @return object
     */
    public function syncPermissions(...$permissions): object
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }

    /**
     * 解除用户权限关联
     *
     * @param $role
     * @return $this
     */
    public function removePermission($permission): object
    {
        $this->permissions()->detach($this->getStoredPermission($permission));

        return $this;
    }

    /**
     * 解除用户所有权限关联
     *
     * @param $role
     * @return $this
     */
    public function removePermissions(): object
    {
        $this->permissions()->detach();

        return $this;
    }
}