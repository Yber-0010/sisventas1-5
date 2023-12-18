<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarcarLeidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function marcarLeido(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
    public function marcarLeidoo($id){
        foreach (auth()->user()->unreadNotifications as $notification) {
            
            if($notification->id == $id) {
            $notification->markAsRead();
            }
        }
        //auth()->user()->unreadNotifications->markAsRead($id);
        return redirect()->back();
    }
}
