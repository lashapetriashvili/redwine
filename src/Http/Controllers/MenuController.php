<?php

namespace Redwine\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redwine\Facades\Redwine;
use Redwine\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        Redwine::permissionFail('browse_menu');

        $menus = Menu::select('menu_name')->get();
        $array = [];

        foreach ($menus as $key => $menu) {
            if (!in_array($menu->menu_name, $array)) {
                $array[$key] = $menu->menu_name;
            }
        }

        return view('redwine::menu.table', compact('array'));
    }

    public function add()
    {
        Redwine::permissionFail('add_menu');

        $controller = $this;

        $items = [];

        return view('redwine::menu.edit', compact('controller', 'items'));
    }

    public function check($name)
    {
        $count = Menu::where('menu_name', $name)->count();

        return $count == 0 ? response()->json(false) : response()->json(true);
    }

    public function edit($name)
    {
        Redwine::permissionFail('edit_menu');

        $menus = Menu::where('menu_name', $name)->orderBy('sort')->get();
        $ref   = [];
        $items = [];
        foreach ($menus as $key => $menu) {
            $thisRef = &$ref[$menu->id];
            $thisRef['parent'] = $menu->parent;
            $thisRef['label'] = $menu->label;
            $thisRef['link'] = $menu->link;
            $thisRef['icon'] = $menu->icon;
            $thisRef['menuName'] = $menu->menu_name;
            $thisRef['id'] = $menu->id;
            if ($menu->parent == 0) {
                $items[$menu->id] = &$thisRef;
            } else {
                $ref[$menu->parent]['child'][$menu->id] = &$thisRef;
            }
        }

        $controller = $this;

        return view('redwine::menu.edit', compact('controller', 'items', 'name'));
    }

    public function getMenu($items, $class = 'dd-list')
    {
        $html = "<ol class=\"".$class."\" id=\"menu-id\">";
        foreach ($items as $key => $value) {
            $html.= '<li class="dd-item dd3-item" data-id="'. $value['id'] .'" >
                        <div class="dd-handle dd3-handle">Drag</div>
                        <div class="dd3-content"><span id="label_show'. $value['id'] .'">'. $value['label'] .'</span>
                            <span class="dd-button"><a class="edit-button edit_'. $value['id'] .'" style="cursor:pointer" id="'. $value['id'] .'" label="'. $value['label'] .'" link="'. $value['link'] .'" icon="'. $value['icon'] .'" name="'. $value['menuName'] .'"><i class="fa fa-pencil"></i></a>
                            <a class="del-button" style="cursor:pointer" id="'. $value['id'] .'"><i class="fa fa-trash"></i></a></span>
                        </div>';
            if (array_key_exists('child', $value)) {
                $html .= $this->getMenu($value['child'], 'child');
            }
                $html .= "</li>";
        }
        $html .= "</ol>";
        return $html;
    }

    public function save(Request $request)
    {
        if ($request->id != '') {
            Redwine::permissionFail('edit_menu');

            $menu = Menu::find($request->id);

            $menu->label = $request->label;
            $menu->link = $request->link;
            $menu->icon = $request->icon;
            $menu->menu_name = $request->menuName;


            $save = $menu->save();

            if ($save) {
                $array['type']  = 'edit';
                $array['label'] = $request->label;
                $array['link']  = $request->link;
                $array['icon']  = $request->icon;
                $array['menuName']  = $request->menuName;
                $array['id']    = $request->id;
            }
        } else {
            Redwine::permissionFail('add_menu');

            $menu = new Menu;

            $menu->label = $request->label;
            $menu->link = $request->link;
            $menu->icon = $request->icon;
            $menu->menu_name = $request->menuName;

            $save = $menu->save();

            if ($save) {
                $array['menu'] =  '<li class="dd-item dd3-item" data-id="'. $menu->id .'" >
                        <div class="dd-handle dd3-handle">Drag</div>
                        <div class="dd3-content"><span id="label_show'. $menu->id .'">'. $request->label .'</span>
                            <span class="dd-button"><a class="edit-button edit_'. $menu->id .'" style="cursor:pointer" id="'. $menu->id .'" label="'. $request->label .'" link="'. $request->link .'" icon="'. $request->icon .'" name="'. $request->menu_name .'"><i class="fa fa-pencil"></i></a>
                            <a class="del-button" style="cursor:pointer" id="'. $menu->id .'"><i class="fa fa-trash"></i></a></span>
                        </div>';
                $array['type'] = 'add';
            }
        }

        return response()->json($array);
    }

    public function parseJsonArray($jsonArray, $parentID = 0)
    {
        $return = array();
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = array();
            if (isset($subArray->children)) {
                $returnSubSubArray = $this->parseJsonArray($subArray->children, $subArray->id);
            }

            $return[] = array('id' => $subArray->id, 'parentID' => $parentID);
            $return = array_merge($return, $returnSubSubArray);
        }

        return $return;
    }

    public function saveChange(Request $request)
    {
        Redwine::permissionFail('edit_menu');

        foreach ($this->parseJsonArray(json_decode($request->data)) as $key => $row) {
            $menu = Menu::find($row['id']);

            $menu->parent = $row['parentID'];
            $menu->sort = $key;

            $save = $menu->save();
        }
    }

    public function delete(Request $request)
    {
        Redwine::permissionFail('delete_menu');

        $this->loadDelete($request->id);
    }

    public function loadDelete($id)
    {
        $menus = Menu::where('parent', $id)->select('id')->get();

        foreach ($menus as $key => $menu) {
            $this->loadDelete($menu->id);
        }

        $delete = Menu::where('id', $id)->delete();
    }

    public function menuDelete($name)
    {
        Redwine::permissionFail('delete_menu');

        $delete = Menu::where('menu_name', $name)->delete();
    }

    public function menu($name, $detal = [])
    {
        $items = Menu::where('menu_name', $name)
            ->orderBy('sort')
            ->get();

        $id = '';
        $html = '';

        $html .= isset($detal['main-ul-class']) && $detal['main-ul-class'] != '' ? '<ul class="'. $detal['main-ul-class'] .'">' : '<ul>';

        foreach ($items as $item) {
            if ($item['parent'] == 0) {
                $link = $item->link == '' ? $item->link = '#' : $item->link;
                $html .= "<li". $this->menuClass($detal, $link) ."><a href='$link'>". $this->menuIcon($item->icon) ."<p>$item->label</p></a>";
                $id = $item->id;
                $html .= $this->subMenu($items, $id, $detal);
                $html .= '</li>';
            }
        }

        $html .= '</ul>';

        return $html;
    }

    protected function subMenu($items, $id, $detal = [])
    {
        $html = '';

        foreach ($items as $item) {
            if ($item->parent == $id) {
                $link = $item->link == '' ? $item->link = '#' : $item->link;
                $html .= '<ul>';
                $html .= "<li". $this->menuClass($detal, $link) ."><a href='$link'>". $this->menuIcon($item->icon) ."<p>$item->label</p></a>";
                $html .= $this->subMenu($items, $item->id, $detal);
                $html .= '</li>';
                $html .= '</ul>';
            }
        }

        return $html;
    }

    protected function menuClass($detal, $link)
    {
        if (isset($detal['class'])) {
            if (isset($detal['active']) && Redwine::url() == $link) {
                return ' class="'. $detal['active'] .' '. $detal['class'] .'"';
            } else {
                return ' class="'. $detal['class'] .'"';
            }
        } elseif (isset($detal['active']) && Redwine::url() == $link) {
            return ' class="'. $detal['active'] .'"';
        }
    }

    protected function menuIcon($icon)
    {
        if (isset($icon)) {
            if (substr($icon, 0, 3) === "fa ") {
                return "<i class='$icon'></i>";
            } else {
                return "<i class='material-icons'>$icon</i>";
            }
        }
    }
}
