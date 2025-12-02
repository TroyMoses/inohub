<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

        if (is_logged_in()) {
            h_set_session('current_page','Dashboard');
            return redirect()->route('dashboard');
        }
        
        return view('user_pages/users/login');
    }
}
