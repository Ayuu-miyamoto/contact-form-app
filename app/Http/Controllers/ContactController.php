<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Http\Requests\ExportContactRequest;

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

    /**
     * エクスポートする 
     */
    public function export(ExportContactRequest $request)
    {
    $query = Contact::query();

    // キーワード検索
    if ($request->filled('keyword')) {
        $keyword = $request->input('keyword');

        $query->where(function ($q) use ($keyword) {
            $q->where('first_name', 'like', "%{$keyword}%")
              ->orWhere('last_name', 'like', "%{$keyword}%")
              ->orWhere('email', 'like', "%{$keyword}%");
        });
    }

    // 性別検索
    if ($request->filled('gender')) {
        $query->where('gender', $request->input('gender'));
    }
    
    // カテゴリ検索
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->input('category_id'));
    }

    // 日付検索
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->input('date'));
    }

    // 新着順で全件取得
    $contacts = $query
        ->with('category')
        ->orderBy('created_at', 'desc')
        ->get();
        $genderLabels = [
            1 => '男性',
            2 => '女性',
            3 => 'その他',
];

        $csv = "\xEF\xBB\xBF";

        $csv .= "ID,氏名,性別,メール,電話,住所,建物,カテゴリ,内容,作成日時\n";

foreach ($contacts as $contact) { 
    $row = [
        $contact->id,
        $contact->last_name . ' ' . $contact->first_name,
        $genderLabels[$contact->gender] ?? '',
        $contact->email,
        $contact->tel,
        $contact->address,
        $contact->building,
        $contact->category->name ?? '',
        $contact->detail,
        $contact->created_at,
    ];

    $csv .= implode(',', array_map(function ($value) {
        return '"' . str_replace('"', '""', $value ?? '') . '"';
    }, $row)) . "\n";
}

return response($csv)
    ->header('Content-Type', 'text/csv; charset=UTF-8')
    ->header('Content-Disposition', 'attachment; filename="contacts.csv"');
    }
}
