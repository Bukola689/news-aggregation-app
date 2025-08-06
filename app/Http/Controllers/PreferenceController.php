<?php

namespace App\Http\Controllers;

use App\Models\Source;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
     public function index(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'preferred_sources' => $user->preferredSources,
            'preferred_categories' => $user->preferredCategories,
            'preferred_authors' => $user->preferredAuthors,
        ]);
    }

     public function update(Request $request)
    {
        $user = $request->user();
        
        $validated = $request->validate([
            'sources' => 'sometimes|array',
            'sources.*' => 'exists:sources,id',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id',
            'authors' => 'sometimes|array',
            'authors.*' => 'exists:authors,id',
        ]);
        
        if (isset($validated['sources'])) {
            $user->preferredSources()->sync($validated['sources']);
        }
        
        if (isset($validated['categories'])) {
            $user->preferredCategories()->sync($validated['categories']);
        }
        
        if (isset($validated['authors'])) {
            $user->preferredAuthors()->sync($validated['authors']);
        }
        
        return response()->json(['message' => 'Preferences updated successfully']);
    }
}
