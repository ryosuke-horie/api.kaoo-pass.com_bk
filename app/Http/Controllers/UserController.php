<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * ユーザー一覧を取得
     */
    public function index(): JsonResponse
    {
        // ログイン中のアカウントIDを取得
        $account_id = auth()->id();
        // ログイン中のアカウントに紐づくユーザー一覧を取得
        $users = User::where('account_id', $account_id)->get();

        // TODO: Fix
        // avatar_imageカラムは以下に固定（確認用）
        $users->each(function ($user) {
            $user->avatar_image = 'https:kaoo-pass.com/images/rapture_20240127134057.jpg';
        });

        return response()->json($users);
    }
}
