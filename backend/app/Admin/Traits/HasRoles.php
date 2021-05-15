<?php


namespace App\Admin\Traits;


use App\Admin\Models\Roles;

trait HasRoles
{
    use HasPermissions, HasNavs;

    /**
     * 返回用户拥有的角色
     * @return object
     */
    public function roles(): object
    {
        return $this->BelongsToMany(Roles::class, 'user_has_roles', 'user_id', 'role_id');
    }

    /**
     * 查询角色并返回
     *
     * @param $role
     * @return Roles
     */
    protected function getStoredRole($role): Roles
    {
        if (is_numeric($role)) {
            return Roles::find($role);
        }

        if (is_string($role)) {
            return Roles::where('name', $role)->first();
        }

        return $role;
    }

    /**
     * @param ...$roles
     * @return $this
     */
    public function assignRole(...$roles)
    {
        try {
            $roles = collect($roles)
                ->flatten()
                ->map(function ($role) {
                    if (empty($role)) {
                        return false;
                    }

                    return $this->getStoredRole($role);
                })
                ->map->id
                ->all();

            $this->roles()->sync($roles, false);
        } catch (\Exception $exception) {
            return $this;
        }

        return $this;
    }

    /**
     * 添加角色关联
     *
     * @param ...$roles
     * @return object
     */
    public function syncRoles(...$roles): object
    {
        $this->roles()->detach();

        return $this->assignRole($roles);
    }

    /**
     * 解除用户与单个角色关联
     *
     * @param $role
     * @return $this
     */
    public function removeRole($role): object
    {
        $this->roles()->detach($this->getStoredRole($role));

        return $this;
    }

    /**
     * 解除用户与所有角色关联
     *
     * @param $role
     * @return $this
     */
    public function removeRoles(): object
    {
        $this->roles()->detach();

        return $this;
    }
}