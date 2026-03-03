<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct(
        protected TagService $tagService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = $this->tagService->getTags();
        return view('tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        try {
            $this->tagService->store($request->validated());
            return redirect()->route('tag.index')->with('success', 'Tag created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        try {
            $this->tagService->update($tag, $request->validated());
            return redirect()->route('tag.index')->with('success', 'Tag updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try {
            $this->tagService->delete($tag);
            return back()->with('success', 'Tag deleted successfully.');
        } catch (\Exception $e) {
            // This catches the 'associated with products' exception from the service
            return back()->with('error', $e->getMessage());
        }
    }
}