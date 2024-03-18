<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * ログイン
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // 認証に成功した後、現在のユーザーを取得
            $user = Auth::user(); // ここで$userはnullではないはずです

            if ($user !== null) {
                // トークン名をリクエストから取得するか、デフォルト値を使用
                /**
                 * @var string $tokenName
                 */
                $tokenName = $request->has('token_name') ? $request->token_name : 'AccessToken';
                $token = $user->createToken($tokenName)->plainTextToken;

                return response()->json(['token' => $token], 200);
            }
        }

        return response()->json(['error' => '認証に失敗しました。'], 401);
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
