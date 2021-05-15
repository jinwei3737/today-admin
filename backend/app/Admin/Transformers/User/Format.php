<?php


namespace App\Admin\Transformers\User;


use Carbon\Carbon;

class Format
{
    public function index($list): array
    {
        $data = [];
        foreach ($list as $item) {
            $data[] = [
                'id'          => $item->id,
                'name'        => $item->name,
                'email'       => $item->email,
                'avatar'      => $item->avatar,
                'roles'       => $item->roles,
                'permissions' => $item->permissions,
                'created_at'  => Carbon::parse($item->created_at)->format('Y-m-d H:i'),
                'updated_at'  => Carbon::parse($item->updated_at)->format('Y-m-d H:i'),
            ];
        }

        return $data;
    }

    public function detailFormat($user): array
    {
        return [
            'id'          => $user->id,
            'name'        => $user->name,
            'email'       => $user->email,
            'avatar'      => $user->avatar,
            'roles'       => $user->roles->map(function ($role) {
                return $role->id;
            })->sort()->values(),
            'permissions' => $user->permissions->map(function ($permission) {
                return $permission->id;
            })->sort()->values()
        ];
    }
}