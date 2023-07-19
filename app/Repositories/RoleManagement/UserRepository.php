<?php

namespace App\Repositories\RoleManagement;

use App\Models\RoleManagement\User;
use App\Repositories\BaseRepository;
use App\Repositories\RoleManagement\{ RoleRepository, UserRoleRepository };

class UserRepository extends BaseRepository
{
    public function __construct(User $user, RoleRepository $role, UserRoleRepository $userRole)
    {
        $this->model    = $user;
        $this->role     = $role;
        $this->userRole = $userRole;
    }

    public function storeUser($request)
    {
        $recordCreated       = true;
        $storeImage          = true;
        $request['password'] = bcrypt($request['password']);

        $user     = $this->store($request->except(['role', 'password_confirmation']), $storeImage, $recordCreated);
        $userRole = $this->userRole->store([
                        'user_id' => $user->user_id, 
                        'role_id' => $request->role
                    ]);

        return $userRole;
    }

    public function updateUser($request, $userId)
    {
        $recordUpdated = true;
        $updateImage   = true;
        $role          = $this->role->show($request->role);
        
        if($request['password'] == ''){
            unset($request['password']);
        } else {
            $request['password'] = bcrypt($request['password']);
        }

        $user = $this->update($request->except(['role', 'password_confirmation']), $userId, $updateImage, $recordUpdated);

        $userRole = $this->userRole->update(['role_id' => $request->role], $user->userRole->user_role_id);

        return $userRole;
    }

    public function deleteUSer($userId)
    {
        return $this->delete($userId);
    }

    public function userDatatable($request)
    {
        $collection = $this->model
                           ->select([ 
                                $this->addRowNum($request),
                                'user_id',
                                'username',
                                'email',
                                'created_at'
                            ]);

        return \DataTables::of($collection)
            ->editColumn('created_at', function($collection) {
                return \Helper::tglIndo($collection->created_at); 
            })
            ->addColumn('action', function($row) {
                return view('partials.buttons.datatable',[
                    'show'    => route('user.show', $row->user_id),
                    'edit'    => route('user.edit', $row->user_id),
                    'destroy' => route('user.destroy', $row->user_id)
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}