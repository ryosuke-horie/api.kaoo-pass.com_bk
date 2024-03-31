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

        if (config('stripe.stripe_secret_key') === null) {
            return response()->json(['error' => 'Stripe secret key is not set'], 500);
        }

        // Stripeクライアントの生成
        $stripe = new \Stripe\StripeClient([
            'api_key' => config('stripe.stripe_secret_key'),
        ]);

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

        // オンボーディングフローのリダイレクトURLを取得
        $onboardingUrl = $stripe->accountLinks->create([
            'account' => $stripeAccountId,
            'refresh_url' => 'https://example.com/reauth',
            'return_url' => 'https://example.com/return',
            'type' => 'account_onboarding',
        ])->url;

        // オンボーディングフローのリダイレクトURLを返す
        return response()->json(['onboarding_url' => $onboardingUrl], 200);
    }
}
