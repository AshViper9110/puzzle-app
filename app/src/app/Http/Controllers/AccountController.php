<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Amounts;
use App\Models\Item;
use App\Models\User;
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
        $data = User::all();
        return view('accounts/users',
            [
                'title' => $title,
                'accounts' => $data
            ]);
    }

    public function items(Request $request)
    {
        $title = 'アイテム一覧';
        $data = Item::all();
        return view('accounts/items',
            [
                'title' => $title,
                'accounts' => $data
            ]);
    }

    public function amounts(Request $request)
    {
        $title = '所持品一覧';

        $query = Amounts::with(['user', 'item']);

        if ($request->filled('select')) {
            $query->where('id', $request->input('select'));
        }

        $amounts = $query->get();

        return view('accounts.amounts', [
            'title' => $title,
            'amounts' => $amounts
        ]);
    }

    public function index(Request $request)
    {
        //$accounts = Accounts::all();
        $accounts = Accounts::simplePaginate(10);
        $count = count($accounts);
        return view('accounts/index', ['accounts' => $accounts, 'count' => $count]);
    }
}
