<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function login(Request $request)
    {
        return redirect('/accounts/home')->with('success', 'ログインしました');
    }
}
