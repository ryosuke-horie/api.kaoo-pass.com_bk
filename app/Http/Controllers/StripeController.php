<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    /**
     * Stripeアカウントを作成
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        // 認証中のアカウントを取得
        $account = $request->user();

        // アカウントが存在しない場合はエラーレスポンスを返す
        if (! $account) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Stripeクライアントの生成
        $stripe = new \Stripe\StripeClient('sk_test_09l3shTSTKHYCzzZZsiLl2vA');

        // Stripeのアカウント作成
        $stripeAccount = $stripe->accounts->create([
            'country' => 'JP',
            'type' => 'express',
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
        ]);

        // StripeのアカウントIDを取得
        $stripeAccountId = $stripeAccount->id ?? null;

        // アカウント情報を更新
        $account->stripe_account_id = $stripeAccountId;
        $account->save();

        return response()->json([], 200);
    }
}
