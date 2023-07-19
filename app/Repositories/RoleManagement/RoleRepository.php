<?php

namespace App\Repositories\RoleManagement;

use App\Models\RoleManagement\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function roleDatatable($request)
    {
        $collection = $this->model
                           ->select([ 
                                $this->addRowNum($request),
                                'role.role_id',
                                'role.role_name',
                                'role.description'
                            ]);

        return \DataTables::of($collection)
            ->addColumn('action', function($row) {
                return view('partials.buttons.datatable',[
                    'show'    => route('role.show', $row->role_id),
                    'edit'    => route('role.edit', $row->role_id),
                    'destroy' => route('role.destroy', $row->role_id)
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}