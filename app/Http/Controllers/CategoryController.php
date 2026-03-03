<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    // Inject the service
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getCategories();
        return view("category.index", compact("categories"));
    }

    public function create()
    {
        return view("category.create");
    }

    public function store(CategoryRequest $request)
    {
        try {
            $this->categoryService->storeOrRestore($request->validated());
            return redirect()->route("category.index")
                ->with('success', 'Category saved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Category $category)
    {
        // Let the service prepare the complex data
        $data = $this->categoryService->getCategoryDetails($category);
        return view('category.show', $data);
    }

    public function edit(Category $category)
    {
        return view("category.edit", compact("category"));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $this->categoryService->update($category, $request->validated());
            return redirect()->route("category.index")
                ->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Update failed.');
        }
    }

    public function destroy(Category $category)
    {
        try {
            $this->categoryService->delete($category);
            return redirect()->route("category.index")
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}