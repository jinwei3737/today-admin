<?php


namespace App\Admin\Controllers;


use App\Admin\Models\Permissions;
use App\Admin\Transformers\Permission\Format;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionsController extends Controller
{
    public function index(Request $request): object
    {
        $name   = $request->input('name', '');
        $offset = $request->input('offset', 1) - 1;
        $limit  = $request->input('limit', 1000);

        $res = Permissions::where(['parent_id' => 0, 'type' => Permissions::TYPE_MENU])
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', "%{$name}%");
            });

        $total = $res->count();

        $list = $res->with(['children', 'btn', 'parent'])->offset($offset)->limit($limit)->orderBy('id', 'asc')->get();

        $data = (new Format())->index($list);

        return apiReturn(['total' => $total, 'data' => $data]);
    }

    public function add(Request $request): object
    {
        $request->validate([
            'parent_id' => 'nullable',
            'name'      => 'required|max:255',
            'key'       => 'required|unique:permissions,key|max:255',
            'uri'       => 'nullable|max:255',
            'type'      => ['required', Rule::in(array_keys(Permissions::$typeMap))],
        ]);

        Permissions::create([
            'parent_id' => $request->parent_id ?: 0,
            'name'      => $request->name,
            'key'       => $request->key,
            'uri'       => $request->uri ?: '',
            'type'      => $request->type,
        ]);

        return apiReturn();
    }

    public function detail(Request $request): object
    {
        $request->validate([
            'id' => 'required|exists:permissions,id',
        ]);

        $detail = Permissions::find($request->id);

        $data = (new Format())->detailFormat($detail);

        return apiReturn($data);
    }

    public function edit(Request $request): object
    {
        $request->validate([
            'id'   => 'required|exists:permissions,id',
            'name' => 'required|max:255',
            'key'  => 'required|unique:permissions,key,' . $request->id . '|max:255',
            'uri'  => 'nullable|max:255',
        ]);

        Permissions::where('id', $request->id)->update([
            'name' => $request->name,
            'key'  => $request->key,
            'uri'  => $request->uri ?: ''
        ]);

        return apiReturn();
    }

    public function delete(Request $request): object
    {
        $request->validate([
            'id' => 'required|exists:permissions,id',
        ]);

        $permission = Permissions::find($request->id);

        if (!$permission->children->isEmpty() || !$permission->btn->isEmpty()) {
            return apiReturn([], '请先删除子菜单或按钮权限', 500);
        }

        $permission->delete();

        return apiReturn();
    }

    public function addOrEditViewData()
    {
        $menus = Permissions::where(['parent_id' => 0, 'type' => Permissions::TYPE_MENU])
            ->with('children')->get(['id', 'name', 'key']);

        $data = (new Format())->viewFormat($menus);

        array_unshift($data, ['id' => 0, 'name' => '顶级菜单', 'key' => '']);

        return apiReturn(array_values($data));
    }
}