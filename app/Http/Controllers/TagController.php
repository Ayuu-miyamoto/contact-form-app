<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Requests\StoreTagRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * タグ追加する
     */
    public function store(StoreTagRequest $request)
    {
        $validated =$request->validated();

        $tag = new Tag();
        $tag->name = $validated['name'];
        $tag->save();

        return redirect('/admin');
    }

    /**
     * タグ編集ページを表示する
     */
    public function edit(string $id)
    {
        $tag = \App\Models\Tag::findOrFail($id);
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * タグ更新する
     */
    public function update(UpdateTagRequest $request, string $id)
    {
        $tag = Tag::findOrFail($id);
        $validated = $request->validated();
        $tag->update($validated);
        
        return redirect('/admin');
     }

    /**
     * タグ削除する
     */
    public function destroy(string $id)
    {
        $tag = \App\Models\Tag::findOrFail($id);
        $tag->delete();

        return redirect('/admin');
    }
}
