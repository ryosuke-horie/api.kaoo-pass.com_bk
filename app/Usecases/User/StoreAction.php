<?php

namespace App\Usecases\User;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class StoreAction
{
    public function __invoke($user)
    {
        // ログイン中のアカウントIDを取得
        $account_id = (int) auth()->id();

        // ファイル名の生成：ファイル名_uuid.拡張子
        $avatarImageName = $user['avatar_image']->getClientOriginalName().uniqid().'.'.$user['avatar_image']->extension();
        $image2Name = $user['image2']->getClientOriginalName().uniqid().'.'.$user['image2']->extension();
        $image3Name = $user['image3']->getClientOriginalName().uniqid().'.'.$user['image3']->extension();

        // ユーザー情報を登録
        User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'account_id' => $account_id,
            'address' => $user['address'],
            'phone' => $user['phone'],
            'age' => $user['age'],
            'avatar_image' => $avatarImageName,
            'image2' => $image2Name,
            'image3' => $image3Name,
        ]);

        // ファイルの保存
        Storage::putFileAs('public', $user['avatar_image'], $avatarImageName);
        Storage::putFileAs('public', $user['image2'], $image2Name);
        Storage::putFileAs('public', $user['image3'], $image3Name);

        // レスポンス
        return response()->json([], 200);
    }
}
