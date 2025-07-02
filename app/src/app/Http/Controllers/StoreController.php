<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function create(Request $request)
    {
        return view('store.create');
    }

    public function set(Request $request)
    {
        Item::create([
            'name' => $request['name'],
            'type' => $request['type'],
        ]);
        return redirect()->route('store.completion', ['name' => $request['name']]);
    }

    public function completion(Request $request)
    {
        return view('store.completion', ['name' => $request['name']]);
    }

    public function delete($name, Request $request)
    {
        // 削除完了フラグをリクエストやセッションなどで受け取るイメージ
        $done = $request->query('done', false);
        if ($done) {
            // 削除済みの画面を表示
            return view('store.delete', ['name' => $name, 'done' => true]);
        } else {
            // 削除確認画面を表示
            return view('store.delete', ['name' => $name, 'done' => false]);
        }
    }

    public function destroy($name)
    {
        $item = Item::where('name', $name)->firstOrFail();
        $item->delete();

        return redirect()->route('store.delete', ['name' => $name, 'done' => true]);
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('store.update', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->name = $request->input('name');
        $item->type = $request->input('type');
        $item->save();

        return redirect()->route('accounts.items');
    }
}
