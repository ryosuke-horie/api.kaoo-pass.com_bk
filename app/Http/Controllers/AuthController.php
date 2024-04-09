<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Usecase\Auth\LoginAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected LoginAction $loginAction;

    public function __construct()
    {
        $this->loginAction = new LoginAction();
    }

    /**
     * ログイン
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // ログインロジック
        $token = ($this->loginAction)($request);

        if ($token === '') {
            return response()->json(['error' => '認証に失敗しました。'], 401);
        }

        return response()->json(['token' => $token], 200);
    }

    /**
     * ユーザー情報取得
     */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        // ユーザーが認証されているか確認
        if ($user === null) {
            return response()->json(['error' => 'ユーザーが認証されていません。'], 401);
        }

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /**
     * ログアウト
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        // ユーザーが認証されているか確認
        if ($user === null) {
            return response()->json(['error' => 'ユーザーが認証されていません。'], 401);
        }

        // 現在のアクセストークンを取得し、削除する
        // @phpstan-ignore-next-line
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'ログアウトしました。'], 200);
    }
}
