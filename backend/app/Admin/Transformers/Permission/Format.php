<?php


namespace App\Admin\Transformers\Permission;


use Carbon\Carbon;

class Format
{
    public function index($list): array
    {
        $data = [];
        foreach ($list as $item) {
            $arr = [
                'id'          => $item->id,
                'name'        => $item->name,
                'key'         => $item->key,
                'btns'         => $this->btnFormat($item->btn),
                'uri'         => $item->uri,
                'parent_id'   => $item->parent_id,
                'parent_name' => $item->parent_id == 0 ? '顶级菜单' : $item->parent->name,
                'created_at'  => Carbon::parse($item->created_at)->format('Y-m-d H:i'),
                'updated_at'  => Carbon::parse($item->updated_at)->format('Y-m-d H:i'),
            ];

            if (!$item->children->isEmpty()) {
                $arr['children'] = $this->index($item->children);
            }

            $data[] = $arr;
        }

        return $data;
    }

    private function btnFormat($list): array
    {
        $data = [];
        foreach ($list as $item) {
            $data[] = [
                'id'   => $item->id,
                'name' => $item->name,
                'key'  => $item->key,
                'uri'  => $item->uri,
            ];
        }

        return $data;
    }

    public function detailFormat($permission): array
    {
        $data = [
            'id'          => $permission->id,
            'name'        => $permission->name,
            'key'         => $permission->key,
            'btn'         => $this->btnFormat($permission->btn),
            'uri'         => $permission->uri,
            'parent_id'   => $permission->parent_id,
            'parent_name' => $permission->parent_id == 0 ? '顶级菜单' : $permission->parent->name,
            'created_at'  => Carbon::parse($permission->created_at)->format('Y-m-d H:i'),
            'updated_at'  => Carbon::parse($permission->updated_at)->format('Y-m-d H:i'),
        ];

        if (!$permission->children->isEmpty()) {
            $data['children'] = $this->index($permission->children);
        }

        return $data;
    }

    public function viewFormat($menus): array
    {
        $data = [];
        foreach ($menus as $item) {
            $arr = [
                'id'   => $item->id,
                'name' => $item->name,
                'key'  => $item->key,
            ];

            if (!$item->children->isEmpty()) {
                $arr['children'] = $this->viewFormat($item->children);
            }

            $data[] = $arr;
        }

        return array_values($data);
    }
}