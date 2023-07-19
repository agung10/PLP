<?php

namespace App\Traits;

use App\Models\RoleManagement\{ RoleMenu, MenuPermission, Permission };

trait MenuPermissionTrait
{
    // get role menu by role user and current menu
    public function availablePermission() {
        if( is_null(\Auth::user()) || is_null($this->currentMenu()) ) return [];

        $roleMenu = RoleMenu::where('role_id', \Auth::user()->role->role_id)
                            ->where('menu_id', $this->currentMenu()->menu_id)
                            ->first();

        $permissions = MenuPermission::where('role_menu_id', $roleMenu->role_menu_id)
                            ->with('permission')
                            ->get();
                            
        return $this->permissionOnly($permissions);
    }

    public function permissionOnly($permissions) {
        $permissionList = [];

        foreach ($permissions as $permission) {
            array_push($permissionList, $permission->permission->permission_action);    
        }

        return $permissionList;
    }

    public function userMenu() {
        return \Auth::user()->role->menu; 
    }

    public function currentRoute($param) {
        $route  = \Request::route()->getName();
        $routes = explode('.', $route);
        $currentRoute = collect();
        
        $actionRoute = empty($routes[1]) ? '' : array_pop($routes); // remove action route from url (last segment url)
        $urlRoute = implode(".", $routes);
        $currentRoute->put('route', $urlRoute);
        $currentRoute->put('action', $actionRoute);
        $currentRoute->put('full', $route);

        return $currentRoute[$param];
    }

    public function currentPermissionDetail() {
        $permission['name'] = \Route::getCurrentRoute()->getActionMethod(); 
        $permissionRecord   = Permission::where('permission_action', $permission['name'])->first();
        $permission['page'] = $permissionRecord ? $permissionRecord->permission_name : ''; 
        
        return $permission;
    }

    public function currentMenu() {
        return $this->userMenu()->where('route', $this->currentRoute('route'))->first();
    }

    /*
    * -- parent
    * ---- menu
    * ------ submenu
    */
    public function menuSidebar()
    {
        $arrangedMenu  = [];
        $parents       = $this->userMenu()->sortBy('order')->whereNull('id_parent');

        foreach ($parents as $parent) {
            $arrParent            = [];
            $arrParent['menu_id'] = $parent->menu_id;
            $arrParent['name']    = $parent->name;
            $arrParent['route']   = $parent->route;
            $arrParent['icon']    = $parent->icon;
            $arrParent['active']  = $this->currentRoute('route') === $parent->route;
            $arrParent['menu']    = [];

            $menus = $this->userMenu()->sortBy('order')->where('id_parent', $parent->menu_id);

            foreach ($menus as $menu) {
                $arrMenu            = [];
                $arrMenu['menu_id'] = $menu->menu_id;
                $arrMenu['name']    = $menu->name;
                $arrMenu['route']   = $menu->route;
                $arrMenu['icon']    = $menu->icon;
                $arrMenu['active']  = false;
                // set active menu from parent to menu
                if($this->currentRoute('route') === $menu->route) {
                    $arrMenu['active']    = true;
                    $arrParent['active']  = true;
                }

                $arrMenu['submenu'] = [];

                $submenus = $this->userMenu()->sortBy('order')->where('id_parent', $menu->menu_id);

                foreach ($submenus as $submenu) {
                    $arrSubmenu            = [];
                    $arrSubmenu['menu_id'] = $submenu->menu_id;
                    $arrSubmenu['name']    = $submenu->name;
                    $arrSubmenu['route']   = $submenu->route;
                    $arrSubmenu['icon']    = $submenu->icon;
                    $arrSubmenu['active']  = false; 
                    // set active menu from parent to submenu
                    if($this->currentRoute('route') === $submenu->route) {
                        $arrMenu['active']    = true;
                        $arrParent['active']  = true;
                        $arrSubmenu['active'] = true;   
                    }

                    array_push($arrMenu['submenu'], $arrSubmenu);
                }
                
                array_push($arrParent['menu'], $arrMenu);
            }
            
            array_push($arrangedMenu, $arrParent);
        }

        return $arrangedMenu;
    }

}