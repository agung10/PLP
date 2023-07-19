<?php

namespace App\Http\ViewComposers;

use App\Traits\MenuPermissionTrait;

class ActionsComposer
{
	use MenuPermissionTrait;

	public function compose($view)
	{
	    $view->with('availablePermission',  $this->availablePermission())
	         ->with('menuActive',  $this->currentMenu());
	}

	
}