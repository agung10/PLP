<?php

namespace App\Http\Controllers\RoleManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleManagement\{ MenuRepository };
use App\Http\Requests\RoleManagement\MenuRequest;

class MenuController extends Controller
{
    protected $menu;
    
    public function __construct(MenuRepository $menu)
    {
        $this->menu = $menu;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('role_management.menu.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuList   = $this->menu->menuList();
        $statusList = $this->menu->statusList();

        return view ('role_management.menu.create', compact('menuList', 'statusList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $store = $this->menu->storeMenu($request->all());

        return redirect()->route('menu.index')->with(\Helper::alertStatus('store', $store));
    }

    /**
     * Display the specified resource.
     *
     * @param  int 
     * @return \Illuminate\Http\Response
     */
    public function show($menuId)
    {
        $menu          = $this->menu->show($menuId);
        $statusList    = $this->menu->statusList();

        return view('role_management.menu.show', compact('menu', 'statusList'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int
     * @return \Illuminate\Http\Response
     */
    public function edit($menuId)
    {
        $menu       = $this->menu->show($menuId);
        $menuList   = $this->menu->menuList();
        $statusList = $this->menu->statusList();

        return view('role_management.menu.edit', compact('menu', 'menuList', 'statusList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int 
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $menuId)
    {
        $update = $this->menu->updateMenu( $request->all(), $menuId );

        return redirect()->route('menu.index')->with(\Helper::alertStatus('update', $update));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       return $this->menu->deleteMenu($id);
    }

    /**
    * Showing list bank by datatable
    * @param $request ajax
    * @return json
    */
    public function ajaxDatatable(Request $request)
    {
        return $this->menu->menuDatatable($request);
    }
}
