<?php

namespace App\Http\ViewComposers;

use App\Traits\MenuPermissionTrait;

class NavigationComposer
{
	use MenuPermissionTrait;

	public function compose($view)
	{
	    $view->with('menus',  $this->menuSidebar())
	         ->with('menuActive',  $this->currentMenu())
	         ->with('currentPermissionDetail',  $this->currentPermissionDetail());
	}

	
}