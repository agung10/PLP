<?php

namespace App\Http\Controllers\RoleManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleManagement\{ UserRepository, RoleRepository, UserRoleRepository };
use App\Http\Requests\RoleManagement\UserRequest;

class UserController extends Controller
{
    protected $user;
    protected $role;
    protected $userRole;
    
    public function __construct(UserRepository $user, RoleRepository $role, UserRoleRepository $userRole)
    {
        $this->user     = $user;
        $this->role     = $role;
        $this->userRole = $userRole;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('role_management.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->role->makeDropdown('role_name');

        return view ('role_management.user.create', compact('roles') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $store = $this->user->storeUser($request);

        return redirect()->route('user.index')->with(\Helper::alertStatus('store', $store));
    }

    /**
     * Display the specified resource.
     *
     * @param  int 
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        $user = $this->user->show($userId);

        return view('role_management.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int
     * @return \Illuminate\Http\Response
     */
    public function edit($userId)
    {
        $user  = $this->user->show($userId);
        $roles = $this->role->makeDropdown('role_name');

        return view('role_management.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int 
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $userId)
    {
        $update = $this->user->updateUser($request, $userId);

        return redirect()->route('user.index')->with(\Helper::alertStatus('update', $update));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       return $this->user->deleteUser($id);
    }

    /**
    * Showing list bank by datatable
    * @param $request ajax
    * @return json
    */
    public function ajaxDatatable(Request $request)
    {
        return $this->user->userDatatable($request);
    }

    public function switchRole(Request $request)
    {
        $status = $this->userRole->switchRole($request->role_id);

        return ['status' => $status];
    }
}
