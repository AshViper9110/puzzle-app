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
}
