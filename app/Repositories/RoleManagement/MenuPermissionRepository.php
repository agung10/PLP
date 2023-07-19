<?php

namespace App\Repositories\RoleManagement;

use App\Models\RoleManagement\MenuPermission;
use App\Repositories\BaseRepository;
use App\Repositories\RoleManagement\{ 
	RoleRepository, 
	RoleMenuRepository, 
	PermissionRepository
};
use App\Traits\MenuPermissionTrait;

class MenuPermissionRepository extends BaseRepository
{
    use MenuPermissionTrait;

    public function __construct(MenuPermission $menuPermission, RoleRepository $role, RoleMenuRepository $roleMenu, PermissionRepository $permission)
    {
		$this->model      = $menuPermission;
		$this->role       = $role;
		$this->roleMenu   = $roleMenu;
		$this->permission = $permission;
    	
    }

    public function appendPermissionByRole($roleId) {
		$role             = $this->role->show($roleId);
		$menuPermissions  = $role->menuPermissions;
		$uniquePermission = $menuPermissions->unique('permission_id')->pluck('permission_id');
		$permissions      = $this->permission->whereIn('permission_id', $uniquePermission)->get();

        $stringPermission = '';

        foreach ($permissions as $permission) {
            $stringPermission .= '<code>'. $permission->permission_name .'</code>&ensp;';
        }
        
        // return \Helper::limitText($stringPermission, 10);
        return $stringPermission;
    }

    public function updateMenuPermission($request, $roleId) {
        $menuPermissions = json_decode($request->menu_permission);
        $update          = false;
        $deletedRecords  = [];
        $newRecords      = [];

    	foreach ($menuPermissions as $menuPermission) {
    		$roleMenu = $this->roleMenu->where([
    						'role_id' => $roleId,
    						'menu_id' => $menuPermission->menu_id
    					])
    					->first();
    		
            array_push($deletedRecords, $roleMenu->role_menu_id);

    		foreach ($menuPermission->permissions as $permission) {
    			$newRecord['role_menu_id'] = $roleMenu->role_menu_id;
                $newRecord['permission_id'] = $permission;

                array_push($newRecords, $newRecord);
    		}
   
    	}

        $delete = $this->deleteBatch('role_menu_id', $deletedRecords);
        
        return $this->storeBatch($newRecords);
    }

    public function datatableMenuPermission($request)
    {
		$sqlRowNum = $this->addRowNum($request, 'role', 'role_id');
        $role  = $this->role->select([
                        $sqlRowNum,
                        'role.role_id',
                        'role.role_name'
                      ]);

    	return \DataTables::of($role)
    			->addColumn('menu', function($role){
		            return $this->roleMenu->appendMenuByRole($role->role_id);
		        })
		        ->addColumn('permission', function($role){
		            return $this->appendPermissionByRole($role->role_id);
		        })
    			->addColumn('action', function($role){
		            
                    return view('partials.buttons.datatable',[
                        'show'    => route('menu-permission.show', $role->role_id),
                        'edit'    => route('menu-permission.edit', $role->role_id)
                    ]);
		        })
		        ->rawColumns(['menu', 'permission', 'action']) // to html
	            ->make(true);
    }
}