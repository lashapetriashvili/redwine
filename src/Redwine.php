<?php

namespace Redwine;

use Redwine\Models\Role;
use Redwine\Models\Permission;
use Redwine\Controllers\Pagecontroller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Redwine
{
    /**
     * The array of models.
     *
     * @var array
     */
    protected $models = [
        "Permission" => Permission::class,
        "Role"       => Role::class
    ];

    /**
     * Check if permission loaded.
     *
     * @var bool
     */
    protected $permissionsLoaded = false;

    /**
     * The array of permissions.
     *
     * @var array
     */
    protected $permissions = [];

    /**
     * Controller namespace.
     * 
     * @return string
     */
    public function controllerNamespace()
    {
        return 'Redwine\\Http\\Controllers';
    }

    /**
     * Get model from $models array.
     *
     * @param  string  $name
     * 
     * @return model
     */
    public function modelClass($name)
    {
        return $this->models[$name];
    }

    /**
     * Get model.
     *
     * @param  string  $name
     * 
     * @return $name
     */
    public function model($name)
    {
        return new $name;
    }

    /**
     * Try if permission exist.
     *
     * @param  string  $permission
     * 
     * @return \Exception|bool
     */
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

    /**
     * Check if permission fail.
     *
     * @param  string  $permission
     * 
     * @return \Exception|bool
     */
    public function permissionFail($permission)
    {
        if (!$this->try($permission)) {
            throw new \Exception('For this user permission does not exist', 400);
        }

        return true;
    }

    /**
     * Try if permission exist for blade tamplate engine.
     *
     * @param  string  $permission
     * 
     * @return bool
     */
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

    /**
     * Check if permission fail for blade tamplate engine.
     *
     * @param  string  $permission
     * 
     * @return bool
     */
    public function bladePermissionFail($permission)
    {
        if (!$this->bladeTry($permission)) {
            return false;
        }

        return true;
    }

    /**
     * Try if permission exist.
     *
     * @param  string  $permission
     * @param  int  $statusCode
     * 
     * @return abort|bool
     */
    public function permissionAbort($permission, $statusCode = 403)
    {
        if (!$this->try($permission)) {
            return abort($statusCode);
        }

        return true;
    }

    /**
     * Upload image in uploads/images folder.
     * 
     * @return string
     */
    public function imageUpload($request, $name)
    {
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $extension = $request->file($name)->guessClientExtension();

                if (in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'tiff'])) {
                    
                    $imageName = time() . '.' . $request[$name]->getClientOriginalExtension();
                    
                    if (!file_exists(base_path('public/index.php'))) {
                        $request[$name]->move(base_path('uploads/images'), $imageName);
                    } else {
                        $request[$name]->move(public_path('uploads/images'), $imageName);
                    }
                    
                    return $imageName;
                }
            }
        }
    }

    /**
     * Load permissions.
     * 
     * @return void
     */
    protected function loadPermissions()
    {
        if (!$this->permissionsLoaded) {
            $this->permissionsLoaded = true;

            $this->permissions = Permission::all();
        }
    }

    /**
     * Get user.
     *
     * @param  int  $id|null
     * 
     * @return int
     */
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

    /**
     * Get value from settigs table.
     *
     * @param  string  $name
     * 
     * @return string
     */
    public function setting($name)
    {
        return $this->model('Redwine\Models\Settings')
            ->where('name', $name)
            ->select('value')
            ->first()['value'];
    }

    /**
     * Get menu.
     *
     * @param  string  $name
     * @param  array  $detal
     * 
     * @return html
     */
    public function menu($name, $detal = [])
    {
        $html = \App::call('Redwine\Http\Controllers\MenuController@menu', ['name' => $name, 'detal' => $detal]);

        return $html;
    }

    /**
     * Get url.
     *
     * @param  int  $number
     * 
     * @return mixed
     */
    public function url($number = 0)
    {
        $url = '';
        $explode = explode('/', url()->current());

        for ($i = 3; $i < count($explode) - $number; $i++) {
            $url .= '/' . $explode[$i];
        }

        return $url;
    }

    /**
     * Get Redwine language.
     *
     * @param  string  $fullText
     * @param  array  $array
     * @param  string  $lang
     * 
     * @return mixed
     */
    public function lang($arg, $array = [], $lang = '')
    {
        $name   = explode('.', $arg);
        $folder = isset($name[0]) ? $name[0] : '';
        $file   = isset($name[1]) ? $name[1] : '';
        $get    = isset($name[2]) ? $name[2] : '';
        $lang   = $lang == '' ? \App::getLocale() : $lang;
        $path   = resource_path('redwineLang/'. $folder .'/'. $lang .'/'. $file .'.json'); 

        if (file_exists($path)) {

            $json      = File::get($path);
            $langArray = json_decode($json, true);
            $text      = isset($langArray[$get]) ? $langArray[$get] : $arg;
            
            return strchr($text, '{') ? $this->langArg($text, $array) : $text;

        } else {
            return $arg;
        }
    }

    /**
     * Change Redwine language argument.
     *
     * @param  string  $fullText
     * @param  array  $array
     * 
     * @return mixed
     */ 
    protected function langArg($fullText, $array)
    {
        $find = strchr($fullText, '{');
        $find = strtok(substr($find, 1, strlen($find)), '}');

        if (array_key_exists($find, $array)) {

            $text = str_replace('{'. $find .'}', $array[$find], $fullText);

            if (strchr($text, '{')) {
               $text = $this->langArg($text, $array); 
            }
            
            return $text;
        } else {
            return $fullText;
        }
    }

    /**
     * Redwine language method for authorized users.
     *
     * @param  string  $arg
     * @param  array  $array
     * @param  bool  $uppercase
     * 
     * @return mixed
     */ 
    public function userLang($arg, $array = [], $uppercase = false)
    {
        $text = $this->lang($arg, $array, \Auth::user()->lang);
        return $uppercase ? strtoupper($text) : $text;
    }

    /**
     * Redwine plugin method.
     *
     * @param  string  $arg
     * 
     * @return object|null
     */ 
    public function plugin($arg)
    {
        $name       = explode('.', $arg);
        $folder     = isset($name[0]) ? $name[0] : '';
        $controller = isset($name[1]) ? $name[1] : '';
        $file       = isset($name[2]) ? $name[2] : '';
        $method     = isset($name[3]) ? $name[3] : '';

        $namespace = '\\App\\RedwinePlugins\\' . $folder . '\\' . $controller . '\\' . $file;
        $namespace = class_exists($namespace) ? new $namespace : false;

        return $namespace ? $namespace->{$method}() : '';
    }
}
