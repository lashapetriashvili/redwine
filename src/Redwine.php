<?php

namespace Redwine;

use Redwine\Models\Role;
use Redwine\Models\Permission;
use Redwine\Controllers\Pagecontroller;
use Illuminate\Support\Facades\Storage;

class Redwine
{
    protected $models = [
        "Permission"    => Permission::class,
        "Role"          => Role::class
    ];
    protected $permissionsLoaded = false;
    protected $permissions = [];

    public function controllerNamespace()
    {
        return "Redwine\\Http\\Controllers";
    }

    public function modelClass($name)
    {
        return $this->models[$name];
    }

    public function model($name)
    {
        return new $name;
    }

    public function try($permission)
    {
        $this->loadPermissions();

        $exist = $this->permissions->where('key', $permission)->first();

        if (!$exist) {
            throw new \Exception('Permission does not exist', 400);
        }

        $user = $this->getUser();
        if ($user == null || !$user->hasPermission($permission)) {
            return false;
        }

        return true;
    }

    public function permissionFail($permission)
    {
        if (!$this->try($permission)) {
            throw new \Exception('For this user permission does not exist', 400);
        }

        return true;
    }

    public function bladeTry($permission)
    {
        $this->loadPermissions();

        $exist = $this->permissions->where('key', $permission)->first();

        if (!$exist) {
            return false;
        }

        $user = $this->getUser();
        if ($user == null || !$user->hasPermission($permission)) {
            return false;
        }

        return true;
    }

    public function bladePermissionFail($permission)
    {
        if (!$this->bladeTry($permission)) {
            return false;
        }

        return true;
    }

    public function permissionAbort($permission, $statusCode = 403)
    {
        if (!$this->try($permission)) {
            return abort($statusCode);
        }

        return true;
    }

    public function imageUpload($request, $name)
    {
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $extension = $request->file($name)->guessClientExtension();

                if (in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'tiff'])) {
                    
                    $imageName = time() . '.' . $request[$name]->getClientOriginalExtension();
                    
                    if (!file_exists(base_path('public/index.php'))) {
                        $request[$name]->move(base_path('uploads'), $imageName);
                    } else {
                        $request[$name]->move(public_path('uploads'), $imageName);
                    }
                    
                    return $imageName;
                }
            }
        }
    }

    protected function loadPermissions()
    {
        if (!$this->permissionsLoaded) {
            $this->permissionsLoaded = true;

            $this->permissions = Permission::all();
        }
    }

    protected function getUser($id = null)
    {
        if (is_null($id)) {
            $id = auth()->check() ? auth()->user()->id : null;
        }

        if (is_null($id)) {
            return;
        }

        if (!isset($this->users[$id])) {
            $this->users[$id] = $this->model('Redwine\Models\User')->find($id);
        }

        return $this->users[$id];
    }

    public function setting($name)
    {
        return $this->model('Redwine\Models\Settings')
            ->where('name', $name)
            ->select('value')
            ->first()['value'];
    }

    public function menu($name, $detal = [])
    {
        $html = \App::call('Redwine\Http\Controllers\MenuController@menu', ['name' => $name, 'detal' => $detal]);

        return $html;
    }

    public function url($number = 0)
    {
        $url = '';
        $explode = explode('/', url()->current());

        for ($i = 3; $i < count($explode) - $number; $i++) {
            $url .= '/' . $explode[$i];
        }

        return $url;
    }
}
