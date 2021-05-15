<?php


namespace App\Admin\Transformers\Role;


use Carbon\Carbon;

class Format
{
    public function index($list): array
    {
        $data = [];
        foreach ($list as $item) {
            $data[] = $this->detailFormat($item);
        }

        return $data;
    }

    public function detailFormat($role): array
    {
        $permissions = [];
        foreach ($role->permissions as $permission) {
            $permissions[] = [
                'id'   => $permission->id,
                'name' => $permission->name,
                'key'  => $permission->key,
            ];
        }

        return [
            'id'         => $role->id,
            'name'       => $role->name,
            'key'        => $role->key,
            'permissions' => $permissions,
            'created_at' => Carbon::parse($role->created_at)->format('Y-m-d H:i'),
            'updated_at' => Carbon::parse($role->updated_at)->format('Y-m-d H:i'),
        ];

    }
}