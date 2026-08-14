<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Contact;


class AdminController extends Controller
{
    /**
     * お問い合せ一覧ページを表示する
     */
    public function admin()
    {
        $categories = Category::all();
        $contacts = Contact::with('category', 'tags')->paginate(10);
        $tags = Tag::all();

        return view('admin.index', compact('categories', 'contacts', 'tags'));
    }

    /**
     * お問い合せ詳細ページを表示する
     */
    public function show(string $id)
    {
        $contact = Contact::with('category', 'tags')->findOrFail($id);
        return view('admin.show', compact('contact')); 
    }

    /**
     * お問い合せ削除
     */
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.index')->with('success', 'お問い合わせを削除しました。');
    }

    /**
     * お問い合せ検索
     */
    public function index(Request $request)
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
        
        //性別検索
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // カテゴリ検索
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // 日付検索
        if ($request->filled('date' )) {
            $query->whereDate('created_at', $request->input('date'));
        }  

        $contacts = $query->with('category', 'tags')->paginate(10);
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.index', compact('contacts', 'categories', 'tags'));
    }
    
   
}
