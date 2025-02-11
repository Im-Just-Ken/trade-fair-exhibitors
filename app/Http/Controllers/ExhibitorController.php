<?php

namespace App\Http\Controllers;

use App\Models\Exhibitor;
use Illuminate\Http\Request;

class ExhibitorController extends Controller
{
    public function index()
    {
        return response()->json(Exhibitor::all());
    }

    public function search(Request $request)
    {
        $query = Exhibitor::query();
        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }
        if ($request->has('country')) {
            $query->where('country', $request->country);
        }
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $exhibitor = Exhibitor::create($request->all());
        return response()->json($exhibitor);
    }

    public function update(Request $request, $id)
    {
        $exhibitor = Exhibitor::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'country' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:255',
            'website' => 'nullable|url'
        ]);

        $exhibitor->update($validatedData);

        return response()->json(['message' => 'Exhibitor updated successfully', 'data' => $exhibitor]);
    }


    public function destroy($id)
    {
        Exhibitor::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function show($id)
{
    $exhibitor = Exhibitor::find($id);

    if (!$exhibitor) {
        return response()->json(['message' => 'Exhibitor not found'], 404);
    }

    return response()->json($exhibitor);
}

}
