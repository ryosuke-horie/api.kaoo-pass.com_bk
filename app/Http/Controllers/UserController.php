<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

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

        // アバター画像のURLを設定
        $users->each(function ($user) {
            if ($user->avatar_image) {
                $user->avatar_image = Storage::disk('s3')->url($user->avatar_image);
            }
        });

        return response()->json($users);
    }
}
