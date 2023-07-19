<?php

namespace App\Repositories\RoleManagement;

use App\Models\RoleManagement\RoleMenu;
use App\Repositories\RoleManagement\{ RoleRepository, MenuRepository };
use App\Traits\MenuPermissionTrait;
use App\Repositories\BaseRepository;

class RoleMenuRepository extends BaseRepository
{

    public function __construct(RoleMenu $roleMenu, RoleRepository $role, MenuRepository $menu)
    {
		$this->model = $roleMenu;
		$this->role  = $role;
		$this->menu  = $menu;
    }

    /**
     * Return menu collection for selected role
     * when $editableMenu === true then add other menu to collection from
     * table menu which not in this role menu collection then set active for added menu = FALSE
     * when $withPermission === true then add available permission for menu by role
     * @param  int $roleId
     * @param  boolean $editableMenu
     * @return \Illuminate\Support\Collection
     */
    public function menuForRole($roleId, $editableMenu=FALSE, $withPermission=FALSE) {
        $role      = $this->role->show($roleId);
        $menuUsers = $role->menu;
        $menu = collect();
        foreach ($menuUsers as $menuUser) {
            $menuCollection = collect($menuUser);
            $menuCollection->put('active', $editableMenu);

            if($withPermission) {
                $roleMenus = $this->where([
                    'menu_id' => $menuUser->menu_id,
                    'role_id' => $roleId
                ])
                ->first();
                $menuPermissions = $roleMenus->permission;
                $permissions     = $menuPermissions->pluck('permission_id')->toArray();
                $menuCollection->put('permissions', $permissions);
            }

            $menu->push($menuCollection);
        }

        if($editableMenu) {
            $menuUserIds = $menuUsers->pluck('menu_id');
            $restMenus   = $this->menu
                                ->whereNotIn('menu_id', $menuUserIds)
                                ->get();

            foreach ($restMenus as $restMenu) {
            	$menuCollection = collect($restMenu); 
                $menuCollection->put('active',  false);
                $menu->push($menuCollection); 
            }
        }

        return $menu;
    }

    /**
     * Return constructed (nested) menu
     * - parent 
     * -- child
     * --- grandchild
     * @param  collection $menu from menuforRole function
     * @return \Illuminate\Support\Collection
     */
    public function constructMenu($menu) {
        $constructedMenu = collect([]);
        $parents         = $menu->sortBy('order')->whereNull('id_parent');

        foreach ($parents as $parent) {
            $parent->put('menu', collect([]) );
            $childs = $menu->sortBy('order')->where('id_parent', $parent['menu_id']);

            foreach ($childs as $child) {
                $child->put('menu', collect([]) );
                $grandchilds = $menu->sortBy('order')->where('id_parent', $child['menu_id']);

                foreach ($grandchilds as $grandchild) {

                    $child['menu']->push($grandchild);
                }
                
                $parent['menu']->push($child);
            }
            
            $constructedMenu->push($parent);
        }


        return $constructedMenu;
    }

    public function updateRoleMenu($request, $roleId) {
        $roleMenu     = $this->menuForRole($roleId, false);
        $roleMenuIds  = $roleMenu->pluck('menu_id');
        $menuToUpdate = !empty($request->menu) ? $request->menu : [];

        $menuToDelete    = $roleMenu->whereNotIn('menu_id', $menuToUpdate);
        $menuToCreate    = array_diff($menuToUpdate, $roleMenuIds->toArray());

        $deletedRoleMenu = $this->deleteRoleMenu($roleId, $menuToDelete);
        $createdRoleMenu = $this->createRoleMenu($roleId, $menuToCreate);
        
        return $createdRoleMenu;
    }

    public function createRoleMenu($roleId, $menuToCreate) {
        $createRoleMenu = true;

        foreach ($menuToCreate as $menu) {
            $createRoleMenu = $this->store([
                'role_id' => $roleId,
                'menu_id' => $menu
            ]);
        }

        return $createRoleMenu;
    }

    public function deleteRoleMenu($roleId, $menuToDelete) {
        $deleteRoleMenu = false;

        foreach ($menuToDelete as $menu) {
            $deleteRoleMenu = $this->where([
                'role_id' => $roleId,
                'menu_id' => $menu['menu_id']
            ])
            ->delete();
        }

        return $deleteRoleMenu;
    }

    public function datatableRoleMenu($request)
    {
        $sqlRowNum = $this->addRowNum($request, 'role', 'role_id');
        $role  = $this->role
                      ->select([
                        $sqlRowNum,
                        'role.role_id',
                        'role.role_name'
                      ]);

    	return \DataTables::of($role)
    			->addColumn('menu', function($role) {
		            return $this->appendMenuByRole($role->role_id);
		        })
    			->addColumn('action', function($role) {

                    return view('partials.buttons.datatable',[
                        'show'    => route('role-menu.show', $role->role_id),
                        'edit'    => route('role-menu.edit', $role->role_id)
                    ]);
		        })
		        ->rawColumns(['menu', 'action']) // to html
	            ->make(true);
    }

    public function appendMenuByRole($roleId) {
        $role       = $this->role->show($roleId);
        $menus      = $role->menu;
        $stringMenu = '';

        foreach ($menus as $key => $value) {
            $stringMenu .= '<code>'. $value->name .'</code>&ensp;';

            // if menu more than 10 just add ...
            if($key > 10) {
                $stringMenu .= '<code>etc...</code>';
                break;
            } 
        }
        
        // return \Helper::limitText($stringMenu, 10);
        return $stringMenu;
    }


}