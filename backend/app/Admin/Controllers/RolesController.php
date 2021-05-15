<?php


namespace App\Admin\Controllers;


use App\Admin\Models\Permissions;
use App\Admin\Models\Roles;
use App\Admin\Transformers\Role\Format;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    public function index(Request $request): object
    {
        $name   = $request->input('name', '');
        $offset = $request->input('offset', 1) - 1;
        $limit  = $request->input('limit', 10);

        $res = Roles::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%{$name}%");
        });

        $total = $res->count();

        $list = $res->with('permissions')->offset($offset)->limit($limit)->orderBy('id', 'asc')->get();

        $data = (new Format())->index($list);

        return apiReturn(['total' => $total, 'data' => $data]);
    }

    public function add(Request $request): object
    {
        $request->validate([
            'name'        => 'required|max:255',
            'key'         => 'required|unique:roles,key|max:255',
            'permissions' => 'nullable|array'
        ]);

        DB::transaction(function () use ($request) {
            $role = Roles::create([
                'name' => $request->name,
                'key'  => $request->key
            ]);

            $role->syncPermissions($request->permissions);
        });

        return apiReturn();
    }

    public function detail(Request $request): object
    {
        $request->validate([
            'id' => 'required|exists:roles,id',
        ]);

        $detail = Roles::with('permissions')->find($request->id);

        $data = (new Format())->detailFormat($detail);

        return apiReturn($data);
    }

    public function edit(Request $request): object
    {
        $request->validate([
            'id'          => 'required|exists:roles,id',
            'name'        => 'required|max:255',
            'key'         => 'required|unique:roles,key,' . $request->id . '|max:255',
            'permissions' => 'nullable|array'
        ]);

        DB::transaction(function () use ($request) {
            $role = Roles::find($request->id);
            $role->update([
                'name' => $request->name,
                'key'  => $request->key
            ]);

            $role->syncPermissions($request->permissions);
        });

        return apiReturn();
    }

    public function delete(Request $request): object
    {
        $request->validate([
            'id' => 'required|exists:roles,id',
        ]);

        $role = Roles::find($request->id);
        $role->removePermissions();
        $role->delete();

        return apiReturn();
    }

    public function removePermission(Request $request): object
    {
        $request->validate([
            'role_id'       => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id'
        ]);

        $role = Roles::find($request->role_id);
        $role->removePermission($request->permission_id);

        return apiReturn();
    }

    public function addOrEditViewData(): object
    {
        $permissions = Permissions::get(['id', 'name', 'key'])->toArray();

        return apiReturn($permissions);
    }
}