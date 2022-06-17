<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProveedorController extends Controller
{
    public function index(){
        $user = Auth::user();
        $nameUser = $user->name;
        return view('proveedor',compact('nameUser'));
    }
}
