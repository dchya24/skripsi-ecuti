<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index(){
        return $this->view('cuti.index', sidebar_menu: "cuti", sidebar_submenu: "cuti.index");
    }

    public function showCreatePage(){
        return $this->view('cuti.add', sidebar_menu: "cuti", sidebar_submenu: "cuti.add");
    }
}
