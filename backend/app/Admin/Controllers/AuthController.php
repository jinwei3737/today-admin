<?php


namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): object
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return apiReturn([], 'The provided credentials are incorrect.', 403);
        }

        $token = $user->createToken(md5(mt_rand()))->plainTextToken;

        return apiReturn(['token' => $token]);
    }

    public function logout(Request $request): object
    {
        $request->user()->tokens()->delete();

        return apiReturn([], 'logout success');
    }

    public function info(Request $request): object
    {
        $user = $request->user();

        $data = [
            'id'          => $user['id'],
            'name'        => $user['name'],
            'email'       => $user['email'],
            'roles'       => $user->roles->map(function ($role) {
                return $role->key;
            })->sort()->values()->toArray(),
            'avatar'      => $user['avatar'],
            'permissions' => array_map(function ($permission) {
                return $permission['key'];
            }, $user->getAllPermissions()->toArray()),
            'navs'        => [],
            'menus'       => [],
        ];

        foreach ($user->getNavsAndMenus() as $nav) {
            $data['navs'][$nav->id] = [
                'id'   => $nav->id,
                'name' => $nav->name,
                'key'  => $nav->key,
            ];

            foreach ($nav->menus as $menu){
                $data['menus'][$nav->id][] = [
                    'id'   => $menu->id,
                    'name' => $menu->name,
                    'key'  => $menu->key,
                ];
            }
        }

        $data['active_index'] = key($data['navs']);

        return apiReturn($data);
    }
}
