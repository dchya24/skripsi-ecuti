<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($view, $data = [], $sidebar_menu = null, $sidebar_submenu = null){
        return view($view, array_merge($data, [
            'sidebar_menu' => $sidebar_menu, 
            'sidebar_submenu' => $sidebar_submenu
        ]));
    }
}
