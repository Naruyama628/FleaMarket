<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Like;
use App\Models\Comment;

class ItemController extends Controller
{
    // インデックス
    public function index(Request $request) {
        $tab = $request->query('tab');

        if ($tab === 'mylist' && !auth()->check()) {
            return redirect()->route('login');
        }

        if ($tab === 'mylist') {
            $items = auth()->user()->likes()->where('is_sold', false)->get();
        } else {
            $items = Product::where('is_sold', false)->get();
        }

        return view('items.index', compact('items', 'tab'));
    }

    public function search(Request $request) {
        $tab = $request->tab;

        if ($tab === 'mylist') {
            $items = auth()
                    ->user()
                    ->likes()
                    ->where('is_sold', false)
                    ->where('name', 'like' , '%' . $request->keyword . '%')
                    ->get();
        } else {
            $items = Product::where('is_sold', false)
                            ->where('name', 'like' , '%' . $request->keyword . '%')
                            ->get();
        }

        return view('items.index', compact('items', 'tab'));
    }

    // 商品詳細表示
    public function show($item_id) {
        $user = auth()->user();

        $item = Product::withCount(['likes', 'comments'])
        ->with('likes')
        ->with('comments')
        ->findOrFail($item_id);

        return view('items.show', compact('item'));
    }

    // 商品出品ページ
    public function sell() {
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
    public function comment(Request $request, $item_id) {
        $user = auth()->user();
        $item = Product::findOrFail($item_id);

        $item->comments()->updateOrCreate([
            "user_id" => $user->id,
            'product_id' => $item->id                ,
        ],
        [
            "content" => $request->comment,
        ]);

        return redirect()->back()->withFragment('comment');
    }
}