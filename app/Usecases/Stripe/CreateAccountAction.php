<?php

namespace App\Usecases\Stripe;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class CreateAccountAction
{
    private StripeClient $stripe;

    public function __construct()
    {
        // Stripeクライアントの初期化
        $this->stripe = new StripeClient(['api_key' => config('stripe.stripe_secret_key')]);
    }

    public function __invoke(Request $request): JsonResponse
    {
        // 認証中のアカウントを取得
        $account = $request->user();

        // アカウントが存在しない場合はエラーレスポンスを返す
        if (! $account) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Stripeのアカウント作成
        $stripeAccount = $this->stripe->accounts->create([
            'country' => 'JP',
            'type' => 'express',
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
            // sports_clubs_fields(スポーツクラブ、運動場)としての利用を想定
            'business_profile' => [
                'mcc' => '7941',
            ],
        ]);

        // StripeのアカウントIDを取得
        $stripeAccountId = $stripeAccount->id ?? null;

        // アカウント情報を更新
        $account->stripe_account_id = $stripeAccountId;
        $account->save();

        // オンボーディングフローのURLを取得
        $onboardingUrl = $this->stripe->accountLinks->create([
            'account' => $stripeAccountId,
            'refresh_url' => 'https://kaoo-pass.com',
            'return_url' => 'https://kaoo-pass.com/dashboard',
            'type' => 'account_onboarding',
        ])->url;

        // オンボーディングフローのURLを返す
        return response()->json(['onboarding_url' => $onboardingUrl], 200);
    }
}
