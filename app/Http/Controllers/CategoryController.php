<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::all();
        return view("category.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view("category.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::onlyTrashed()->where('name', $validated['name'])->first();

        if ($category) {
            $category->restore();
            $category->update($validated);
            return redirect()->route("category.index")->with('success', 'Category restored and updated successfully.');
        }

        Category::create($validated);
        return redirect()->route("category.index")->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

        return view("category.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {

        $category->update($request->validated());
        return redirect()->route("category.index")->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {

        // if ($category->products()->whereHas('orderItems')->exists()) {
        //     return back()->with('error', 'Cannot delete category: Some products in this category are attached to existing orders.');
        // }

        $category->delete();
        return redirect()->route("category.index")->with('success', 'Category deleted successfully.');
    }
}
