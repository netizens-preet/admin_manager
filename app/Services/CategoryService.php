<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class CategoryService
{
    public function getCategories()
    {
        return Category::all();
    }

    public function storeOrRestore(array $data)
    {
        DB::beginTransaction();
        try {
            $data['slug'] = Str::slug($data['name']);
            
            // Logic for checking deleted categories
            $category = Category::onlyTrashed()->where('name', $data['name'])->first();

            if ($category) {
                $category->restore();
                $category->update($data);
            } else {
                $category = Category::create($data);
            }

            DB::commit();
            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Category Store Failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function update(Category $category, array $data)
    {
        DB::beginTransaction();
        try {
            $category->update($data);
            DB::commit();
            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Category Update Failed', ['id' => $category->id]);
            throw $e;
        }
    }

    public function delete(Category $category)
    {
        // Business logic check before deletion
        if ($category->products()->exists()) {
             throw new Exception("Cannot delete: Category contains active products.");
        }

        return $category->delete();
    }

    public function getCategoryDetails(Category $category)
    {
        // Aggregating data for the show page
        $stats = [
            'total_reviews' => $category->reviews()->count(),
            'average_rating' => $category->reviews()->avg('rating') ?? 0,
        ];

        $recentReviews = $category->reviews()
            ->with(['product', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        return [
            'category' => $category,
            'stats' => $stats,
            'recentReviews' => $recentReviews
        ];
    }
}