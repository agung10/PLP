<?php

namespace App\Http\Controllers\RoleManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleManagement\{ RoleMenuRepository, RoleRepository };

class RoleMenuController extends Controller
{
    protected $roleMenuRepo;
    
    public function __construct(RoleMenuRepository $roleMenuRepo, RoleRepository $roleRepo)
    {
        $this->roleMenuRepo = $roleMenuRepo;
        $this->roleRepo     = $roleRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        return view ('role_management.role_menu.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int 
     * @return \Illuminate\Http\Response
     */
    public function show($roleId)
    {
        $editableMenu = false;
        $role         = $this->roleRepo->show($roleId);
        $menu         = $this->roleMenuRepo->menuForRole($roleId, $editableMenu);
        $roleMenu     = $this->roleMenuRepo->constructMenu($menu);

        return view('role_management.role_menu.show', compact('role', 'roleMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int
     * @return \Illuminate\Http\Response
     */
    public function edit($roleId)
    {
        $editableMenu = true;
        $role         = $this->roleRepo->show($roleId);
        $menu         = $this->roleMenuRepo->menuForRole($roleId, $editableMenu);
        $roleMenu     = $this->roleMenuRepo->constructMenu($menu);

        return view('role_management.role_menu.edit', compact('role', 'roleMenu'));
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
        $update = $this->roleMenuRepo->updateRoleMenu( $request, $roleId );

        return redirect()->route('role-menu.index')->with(\Helper::alertStatus('update', $update));
    }

    /**
    * Showing list bank by datatable
    * @param $request ajax
    * @return json
    */
    public function ajaxDatatable(Request $request)
    {
        return $this->roleMenuRepo->datatableRoleMenu($request);
    }
}
