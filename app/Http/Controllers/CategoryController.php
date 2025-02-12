<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();

        // Validate the incoming request
        $validatedData = $request->validate([
            'catName' => [
                'required',
                'string',
                'max:255',
                // Custom validation rule to check unique category name for the same user
                function ($attribute, $value, $fail) use ($userId) {
                    if (Category::where('user_id', $userId)->where('name', $value)->exists()) {
                        $fail('The category name has already been taken for your account.');
                    }
                },
            ],
        ], [
            'catName.required' => 'Category name is required.',
            'catName.string' => 'Category name must be a string.',
            'catName.max' => 'Category name may not be greater than 255 characters.',
        ]);

        // Create a new category instance
        $category = new Category();
        $category->name = $validatedData['catName'];
        $category->user_id = $userId;

        // Save the category to the database
        $category->save();

        // Optionally, you can return a response indicating success
        return response()->json(['message' => 'Category created successfully'], 200);
    }


    public function update(Request $request, $id)
    {
        $user = Auth::user()->id;
        // Fetch the category for the authenticated user
        $category = Category::where('user_id', $user)->findOrFail($id);
        // Update the category name
        $category->name = $request->name;
        // Save the updated category
        $category->save();
        return response()->json(['success' => 'Category updated successfully']);
    }

    public function destroy($id)
    {
        $user = Auth::user()->id;
        // Fetch the category for the authenticated user
        $category = Category::where('user_id', $user)->findOrFail($id);
        // Delete the category
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
