<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function edit() {
        $user = Auth::user();
        return view('profiles.edit', compact('user'));
    }

    public function create(ProfileRequest $request) {
        $user = auth()->user();

        // 画像をアップロードした際の処理
        if ($request->hasFile('image')) {
            // 既に設定されているプロフィール画像を削除
            $profile = Profile::where('user_id', $user->id)->first();

            if ($profile && $profile->profile_image) {
                Storage::disk('public')->delete($profile->profile_image);
            }

            // アップロードされた画像を保存
            $imagePath = $request->file('image')->store('profiles', 'public');
        } else {
            // 画像がアップロードされなかった際の処理
            if($user->profile) {
                // プロフィールがあればプロフィール画像を再び設定
                $imagePath = $user->profile->profile_image;
            }else {
                // プロフィールがなければプロフィール画像をnullに設定
                $imagePath = null;
            }
        }
        
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'profile_image' => $imagePath,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]
        );

        User::updateOrCreate(
            ['id' => $user->id],
            [
                'name' => $request->name,
            ]
        );

        return redirect()->intended('/');
    }

    public function mypage(Request $request) {
        $user = Auth::user();

        $page = $request->query('page');
        if ($page === 'buy') {
            $items = Order::where('user_id', $user->id)->with('product')->get()->pluck('product');;
        } else {
            $items = Product::where('user_id', $user->id)->get();
        }

        return view('profiles.show', compact('items', 'user', 'page'));
    }
}
