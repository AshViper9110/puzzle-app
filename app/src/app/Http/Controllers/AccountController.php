<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function home(Request $request)
    {
        return view('/accounts/home');
    }

    public function users(Request $request)
    {
        $title = 'アカウント一覧';
        $data = Accounts::all();
        return view('accounts/users',
            [
                'title' => $title,
                'accounts' => $data
            ]);
    }

    public function scores(Request $request)
    {
        $title = 'アカウント一覧';
        $data = [
            [
                'id' => 1,
                'name' => 'test01',
                'score' => '10000'
            ],
            [
                'id' => 2,
                'name' => 'test02',
                'score' => '2345'
            ]
        ];
        return view('accounts/scores',
            [
                'title' => $title,
                'accounts' => $data
            ]);
    }

    public function index(Request $request)
    {
        $accounts = Accounts::all();
        $count = count($accounts);
        return view('accounts/index', ['accounts' => $accounts, 'count' => $count]);
    }
}
