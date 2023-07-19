<?php

namespace App\Http\Controllers\RoleManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleManagement\{ RoleRepository };
use App\Http\Requests\RoleManagement\RoleRequest;
use App\Models\RoleManagement\Menu;
use App\Models\RoleManagement\MenuPermission;
use App\Models\RoleManagement\Permission;
use App\Models\RoleManagement\RoleMenu;

class RoleController extends Controller
{
    protected $role;
        
    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('role_management.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('role_management.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $data['role_name']   = $request->role_name;
        $data['description'] = $request->description;
        $data['is_active']   = true;
        $data['created_by']  = \Auth::user()->user_id;
        $data['updated_by']  = \Auth::user()->user_id;
        $data['created_at']  = date('Y-m-d H:i:s');
        $data['updated_at']  = date('Y-m-d H:i:s');
        $recordData = $this->role->create($data);

        /** ROLE Menu **/
        $menus = Menu::all();
        foreach ($menus as $menu) {
            if (($menu->menu_id != 2 && $menu->id_parent != 2) && ($menu->menu_id != 7 && $menu->id_parent != 7)) {
                RoleMenu::create([
                    'role_id'    => $recordData->role_id,
                    'menu_id'    => $menu->menu_id
                ]);
            }
        }       

        // Menu Permissiona
        $roleMenus   = RoleMenu::where('role_id', $recordData->role_id)->get();
        $permissions = Permission::all();
        foreach ($roleMenus as $roleMenu) {
            foreach ($permissions as $permission) {
                MenuPermission::create([
                    'role_menu_id'  => $roleMenu->role_menu_id,
                    'permission_id' => $permission->permission_id
                ]);
            }
        }
        
        $status = !empty($recordData) ? true : false;

        return redirect()->route('role.index')->with(\Helper::alertStatus('store', $status));
    }

    /**
     * Display the specified resource.
     *
     * @param  int 
     * @return \Illuminate\Http\Response
     */
    public function show($roleId)
    {
        $role = $this->role->show($roleId);

        return view('role_management.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int
     * @return \Illuminate\Http\Response
     */
    public function edit($roleId)
    {
        $role = $this->role->show($roleId);

        return view('role_management.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int 
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $roleId)
    {
        $update = $this->role->update( $request->all(), $roleId );

        return redirect()->route('role.index')->with(\Helper::alertStatus('update', $update));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       return $this->role->delete($id);
    }

    /**
    * Showing list bank by datatable
    * @param $request ajax
    * @return json
    */
    public function ajaxDatatable(Request $request)
    {
        return $this->role->roleDatatable($request);
    }
}
