<?php

namespace App\Usecases\Stripe;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class CheckoutSessionAction
{
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(['api_key' => config('stripe.stripe_secret_key')]);
    }

    public function __invoke(Request $request): JsonResponse
    {
        // ユーザーが選択した商品の価格IDを取得
        $priceId = $request->input('stripe_price_id');

        // ユーザーのstripe_account_idを取得
        $stripeAccountId = $request->user()->account->stripe_account_id ?? null;

        // 支払いページ作成オプション
        $options = [
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => 'https://kaoo-pass.com/success',
            'cancel_url' => 'https://kaoo-pass.com/cancel',
        ];

        // stripe_account_idが存在する場合、オプションに追加
        if ($stripeAccountId !== null) {
            $options['stripe_account'] = $stripeAccountId;
        }

        // 支払いページ作成
        $session = $this->stripe->checkout->sessions->create($options);
        $url = $session->url;

        return response()->json(['url' => $url], 200);
    }
}
