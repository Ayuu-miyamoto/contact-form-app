<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;


class ContactController extends Controller
{
    /**
     * お問い合せフォームを表示する.
     */
    public function index()
    {
        //
        $categories = Category::all();
        $tags = Tag::all();

        return view('contact.index', compact('categories', 'tags'));
        
    }

    /**
     * 確認ページを表示する
     */
    public function confirm(ContactRequest $request)
    {
        //
        $validated = $request->validated();
        $category = Category::find($validated['category_id']);
        $tags = Tag::whereIn('id', $validated['tags_ids'] ?? [])->get();

        return view('contact.confirm', compact('validated', 'category', 'tags'));

    }

    /**
     * サンクスページを表示する
     */
    public function store(ContactRequest $request)
    {
        //
        $validated = $request->validated();
        $contact = Contact::create($validated);
        $contact->tags()->sync($validated['tags_ids'] ?? []);
        $category = Category::find($validated['category_id']);
        $tags = Tag::whereIn('id', $validated['tags_ids'] ?? [])->get();

        return view('contact.thanks', compact('validated', 'category', 'tags'));
    }   

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
