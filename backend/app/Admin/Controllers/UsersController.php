<?php


namespace App\Admin\Controllers;


use App\Admin\Models\Permissions;
use App\Admin\Models\Roles;
use App\Admin\Transformers\User\Format;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request): object
    {
        $name   = $request->input('name', '');
        $offset = $request->input('offset', 1) - 1;
        $limit  = $request->input('limit', 10);

        $res = User::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%{$name}%");
        });

        $total = $res->count();

        $list = $res->with(['roles' => function ($query) {
            $query->select('id', 'name', 'key');
        }, 'permissions'            => function ($query) {
            $query->select('id', 'name', 'key');
        }])->offset($offset)->limit($limit)->orderByDesc('id')->get();

        $data = (new Format())->index($list);

        return apiReturn(['total' => $total, 'data' => $data]);
    }

    public function add(Request $request): object
    {
        $request->validate([
            'name'        => 'required|max:255',
            'email'       => 'required|unique:users,email|email:rfc,dns',
            'password'    => 'required|confirmed|min:6',
            'roles'       => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);
        });

        return apiReturn();
    }

    public function detail(Request $request): object
    {
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        $detail = User::with('roles', 'permissions')->find($request->id);

        $data = (new Format())->detailFormat($detail);

        return apiReturn($data);
    }

    public function edit(Request $request): object
    {
        $request->validate([
            'id'          => 'required|exists:users,id',
            'name'        => 'required|max:255',
            'email'       => 'required|unique:users,email,' . $request->id . '|email:rfc,dns',
            'password'    => 'nullable|confirmed|min:6',
            'roles'       => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::find($request->id);
            $post = [
                'name'  => $request->name,
                'emial' => $request->email,
            ];
            if ($request->input('password', '')) {
                $post['password'] = Hash::make($request->password);
            }
            $user->update($post);

            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);
        });

        return apiReturn();
    }

    public function delete(Request $request): object
    {
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->id);
        $user->removeRoles();
        $user->removePermissions();
        $user->delete();

        return apiReturn();
    }

    public function removeRole(Request $request): object
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::find($request->user_id);
        $user->removeRole($request->role_id);

        return apiReturn();
    }

    public function removePermission(Request $request): object
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        $user = User::find($request->user_id);
        $user->removePermission($request->permission_id);

        return apiReturn();
    }

    public function addOrEditViewData(): object
    {
        $roles       = Roles::get(['id', 'name', 'key']);
        $permissions = Permissions::get(['id', 'name', 'key']);

        return apiReturn(['roles' => $roles, 'permissions' => $permissions]);
    }
}