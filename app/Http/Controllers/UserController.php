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

        return response()->json($users);
    }
}
