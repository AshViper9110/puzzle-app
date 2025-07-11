<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Stage;
use App\Models\StageCell;
use Illuminate\Http\Request;

class StageController extends Controller
{
    public function index(Request $request)
    {
        $stages = Stage::all();
        return response()->json($stages);
    }

    public function cell(Request $request)
    {
        $stages = StageCell::where('stage_id', $request->stage_id)->get();
        return response()->json($stages);
    }

    public function get($id)
    {
        $stage = Stage::with('cells')->findOrFail($id);

        return response()->json([
            'id' => $stage->id,
            'name' => $stage->name,
            'description' => $stage->description,
            'cells' => $stage->cells->map(function ($cell) {
                return [
                    'x' => $cell->x,
                    'y' => $cell->y,
                    'type' => $cell->type,
                ];
            }),
        ]);
    }

    public function count()
    {
        $count = Stage::count();

        return response()->json([
            'count' => $count
        ]);
    }
}
