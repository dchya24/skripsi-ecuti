<?php

namespace App\Http\Controllers;

use App\Models\PerizinanCuti;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($view, $data = [], $sidebar_menu = null, $sidebar_submenu = null){
        $user = Auth::user();

        $perizinanCuti = PerizinanCuti::where('user_id', $user->id)
            ->whereDate('created_at', now())
            ->orderBy('created_at', 'desc')->first();
        // dd($perizinanCuti);

        return view($view, array_merge($data, [
            'sidebar_menu' => $sidebar_menu, 
            'sidebar_submenu' => $sidebar_submenu,
            'notification' => $perizinanCuti
        ]));
    }
}
