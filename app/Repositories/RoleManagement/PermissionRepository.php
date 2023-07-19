<?php

namespace App\Repositories\RoleManagement;

use App\Models\RoleManagement\Permission;
use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository
{
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    public function permissionDatatable($request)
    {
        $collection = $this->model
                           ->select([ 
                                $this->addRowNum($request),
                                'permission.permission_id',
                                'permission.permission_name',
                                'permission.permission_action',
                                'permission.created_at'
                            ]);

        return \DataTables::of($collection)
            ->editColumn('created_at', function($collection) {
                return \Helper::tglIndo($collection->created_at); 
            })
            ->addColumn('action', function($row) {
                return view('partials.buttons.datatable',[
                    'show'    => route('permission.show', $row->permission_id),
                    'edit'    => route('permission.edit', $row->permission_id),
                    'destroy' => route('permission.destroy', $row->permission_id)
                ]);
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}