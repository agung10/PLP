<?php

namespace App\Http\Controllers\RoleManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleManagement\{ 
    MenuPermissionRepository, 
    RoleRepository, 
    RoleMenuRepository,
    PermissionRepository 
};

class MenuPermissionController extends Controller
{

    public function __construct(
        MenuPermissionRepository $menuPermissionRepo, 
        RoleRepository $roleRepo,
        RoleMenuRepository $roleMenuRepo,
        PermissionRepository $permissionRepo
    )
    {
        $this->menuPermissionRepo = $menuPermissionRepo;
        $this->roleRepo           = $roleRepo;
        $this->permissionRepo     = $permissionRepo;
        $this->roleMenuRepo       = $roleMenuRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('role_management.menu_permission.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int 
     * @return \Illuminate\Http\Response
     */
    public function show($roleId)
    {
        $editableMenu   = false;
        $withPermission = true;
        $role           = $this->roleRepo->show($roleId);
        $permissions    = $this->permissionRepo->all();
        $permissionIds  = $this->permissionRepo->pluck('permission_id');
        $menu           = $this->roleMenuRepo->menuForRole($roleId, $editableMenu, $withPermission);
        $menuPermission = $this->roleMenuRepo->constructMenu($menu);
        
        return view('role_management.menu_permission.show', compact('role', 'menuPermission', 'permissions', 'permissionIds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int
     * @return \Illuminate\Http\Response
     */
    public function edit($roleId)
    {
        $editableMenu   = false;
        $withPermission = true;
        $role           = $this->roleRepo->show($roleId);
        $permissions    = $this->permissionRepo->all();
        $permissionIds  = $this->permissionRepo->pluck('permission_id');
        $menu           = $this->roleMenuRepo->menuForRole($roleId, $editableMenu, $withPermission);
        $menuPermission = $this->roleMenuRepo->constructMenu($menu);

        return view('role_management.menu_permission.edit', compact('role', 'menuPermission', 'permissions', 'permissionIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $roleId)
    {
        $update = $this->menuPermissionRepo->updateMenuPermission( $request, $roleId );

        return ['status' => $update];
    }

    /**
    * Showing list bank by datatable
    * @param $request ajax
    * @return json
    */
    public function ajaxDatatable(Request $request)
    {
        return $this->menuPermissionRepo->datatableMenuPermission($request);
    }
}
