<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = Users::findOrFail($request->user_id);
        return response()->json(
            UserResource::make($user)
        );
    }

    public function index(Request $request)
    {
        $users = Users::all();
        return response()->json(
            UserResource::collection($users)
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer',
        ]);

        // exp を追加
        $validated['exp'] = 0;

        $user = Users::create($validated);

        $token = $user->createToken($validated['name'])->plainTextToken;

        return response()->json([
            'user_id' => $user->id,
            'token' => $token
        ]);
    }
}
