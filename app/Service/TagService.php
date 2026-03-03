<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class TagService
{
    public function getTags()
    {
        return Tag::latest()->get();
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $data['slug'] = Str::slug($data['name']);
            $tag = Tag::create($data);

            DB::commit();
            return $tag;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tag Store Failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function update(Tag $tag, array $data)
    {
        DB::beginTransaction();
        try {
            $data['slug'] = Str::slug($data['name']);
            $tag->update($data);

            DB::commit();
            return $tag;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tag Update Failed', ['id' => $tag->id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function delete(Tag $tag)
    {
        DB::beginTransaction();
        try {
            // Logic check: distribute specific business rules here
            if ($tag->products()->exists()) {
                throw new Exception('Cannot delete tag because it is associated with products.');
            }

            $tag->delete();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tag Delete Failed', ['id' => $tag->id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }
}