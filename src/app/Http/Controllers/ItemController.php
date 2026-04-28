<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

class ItemController extends Controller
{
    // インデックス
    public function index(Request $request) {
        $tab = $request->query('tab');
        $keyword = $request->query('keyword');

        if ($tab === 'mylist' && !auth()->check()) {
            $items = collect();
            return view('items.index', compact('items', 'tab', 'keyword'));
        }

        if ($tab === 'mylist') {
            $items = auth()
                    ->user()
                    ->likes()
                    ->where('products.user_id', '!=', auth()->id())
                    ->where('name', 'like' , '%' . $request->keyword . '%')
                    ->get();
        } else {
            $items = Product::where('user_id', '!=', auth()->id())
                ->where('name', 'like', '%' . $request->keyword . '%')
                ->get();
        }

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    public function search(Request $request) {
        $tab = $request->tab;
        $keyword = $request->query('keyword');

        if($tab === 'mylist' && !auth()->check()) {
            $items = [];
            return view('items.index', compact('items', 'tab', 'keyword'));
        }

        if ($tab === 'mylist') {
            $items = auth()
                    ->user()
                    ->likes()
                    ->where('products.user_id', '!=', auth()->id())
                    ->where('name', 'like' , '%' . $request->keyword . '%')
                    ->get();
        } else {
            $items = Product::where('products.user_id', '!=', auth()->id())
                            ->where('name', 'like' , '%' . $request->keyword . '%')
                            ->get();
        }

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    // 商品詳細表示
    public function show($item_id) {
        $item = Product::withCount(['likes', 'comments'])
        ->with('likes')
        ->with('comments')
        ->findOrFail($item_id);

        return view('items.show', compact('item'));
    }

    // 商品出品ページ
    public function sell() {
        $user = Auth::user();
        if (!$user->profile) {
            return redirect('/profile/edit');
        }

        $categories = Category::all();

        return view('items.create', compact('categories'));
    }

    // 商品出品処理
    public function create(ExhibitionRequest $request) {
        $user = auth()->user();

        $imagePath = $request->file('image')->store('products', 'public');

        // 商品を保存
        $item = [
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
            "brand" => $request->brand,
            "condition" => $request->condition,
            "image" => $imagePath,
            "is_sold" => false,
        ];
        $product = $user->products()->create($item);

        // 中間テーブルにカテゴリを保存
        if ($request->filled('category'))
            $product->categories()->sync($request->category);

        return redirect('/');
    }

    // いいね
    public function like($item_id) {
        $user = auth()->user();

        $user->likes()->toggle($item_id);

        return redirect()->back()->withFragment('like');
    }

    // コメント
    public function comment(CommentRequest $request, $item_id) {
        $user = auth()->user();
        $item = Product::findOrFail($item_id);

        $item->comments()->create([
            "user_id" => $user->id,
            "content" => $request->comment,
        ]);

        return redirect()->back()->withFragment('comment');
    }
}